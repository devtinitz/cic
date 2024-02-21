<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Artisan;
use Config;
use Exception;
use File;

class SetupController extends Controller
{
    protected $dbConfig;

    public function __construct()
    {
        set_time_limit(8000000000);
    }

    /**
     * Display a listing of the resource.
     * Fonction d'affichage de la vue de demarrage de l'installation
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return view('install.index');
    }

    /*
     * Fonction d'affichage de la vue des éléments requis pour l'application
     * */
    public function requirements(){
        [$checks, $success] = $this->checkMinimumRequirements();
        return view('install.requirement', compact('checks', 'success'));
    }

    /*
     * Fonction de verification des éléments requis pour l'installation
     * */
    public function checkMinimumRequirements()
    {
        $checks = [
            'php_version' => 'Version PHP  >= 7.4.0',
            'extension_bcmath' => 'PHP Extension: BCMath',
            'extension_ctype' => 'PHP Extension: Ctype',
            'extension_json' => 'PHP Extension: JSON',
            'extension_openssl' => 'PHP Extension: OpenSSL',
            'extension_pdo_mysql' => 'PHP Extension: PDO',
            'extension_tokenizer' => 'PHP Extension: Tokenizer',
            'extension_xml' => 'PHP Extension: XML',
            'env_writable' => 'Fichier .env présent et modifiable',
        ];

        $success = (!in_array(false, $checks, true));
        return [$checks, $success];
    }

    /*
     * Fonction d'affichage de la vue des infos de la base de données
     *
     * */
    public function database(){
        return view('install.database');
    }

    /*
     * Fonction de sauvegarde des éléments de la bd et configuration de la base de données
     * */
    public function databaseSubmit(Request $request){
        try {
            $configs = $request->validate([
                'connection' => 'required',
                'host' => 'required',
                'port' => 'required',
                'database' => 'required',
                'username' => 'required',
                'password' => 'nullable',
            ]);

            $this->createDatabaseConnection($configs);
            $migration = $this->runDatabaseMigration();

            if ($migration !== true) {
                return redirect()->back()->withInput()->withErrors([$migration]);
            }

            $this->changeEnvDatabaseConfig($request->all());
            //$this->createEspace();

            return redirect()->route('install.account');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /*
     * Test de connexion à la base de données
     * */

    public function database_test_connexion(Request $request){
        try {
            $configs = $request->validate([
                'connection' => 'required',
                'host' => 'required',
                'port' => 'required',
                'database' => 'required',
                'username' => 'required',
                'password' => 'nullable',
            ]);

            Config::set('database.default', 'mysql');
            Config::set('host', $configs['host']);
            Config::set('port', $configs['port']);
            Config::set('database', $configs['database']);
            Config::set('username', $configs['username']);
            Config::set('password', $configs['password']);

            $pdo = new \PDO(
                "mysql:host={$configs['host']};dbname={$configs['database']}",
                $configs['username'],
                $configs['password']
            );

            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            if($pdo){
                session()->flash('type', 'alert-success');
                session()->flash('message', 'Test de connexion à la base de données réussie.');
                return redirect()->back()->withInput();
            }else{
                return redirect()->back()->withInput()->withErrors(['Impossible de trouver la base de données. Veuillez vérifier votre configuration.']);
            }

        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Fonction de connexion à la base de données
     **/
    public function createDatabaseConnection($configs)
    {
        Artisan::call('config:clear');
        config(['database.default' => $configs['connection']]);
        $this->dbConfig = config('database.connections.'.$configs['connection']);
        $this->dbConfig['host'] = $configs['host'];
        $this->dbConfig['port'] = $configs['port'];
        $this->dbConfig['database'] = $configs['database'];
        $this->dbConfig['username'] = $configs['username'];
        $this->dbConfig['password'] = $configs['password'];
        Config::set('database.connections.setup', $this->dbConfig);
    }

    /**
     * Fonction de migration des tables vers la base de données
     **/
    public function runDatabaseMigration()
    {
        try {
            Artisan::call('migrate:fresh', [
                '--database' => 'setup',
                '--force' => 'true',
                '--no-interaction' => true,
            ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Fonction de modification des infos de la bd dans le fichier Env
     **/
    public function changeEnvDatabaseConfig($configs)
    {
        $this->changeEnvValues('DB_HOST', $configs['host']);
        $this->changeEnvValues('DB_PORT', $configs['port']);
        $this->changeEnvValues('DB_DATABASE', $configs['database']);
        $this->changeEnvValues('DB_USERNAME', $configs['username']);
        $this->changeEnvValues('DB_PASSWORD', $configs['password']);
    }

    /**
     * Fonction de modification des valeurs du fichier ENV
     */
    private function changeEnvValues($key, $value)
    {
        file_put_contents(app()->environmentFilePath(), str_replace(
            $key . '=' . env($key),
            $key . '=' . $value,
            file_get_contents(app()->environmentFilePath())
        ));
    }

    /*
    * Fonction de vérification de la configuration complète de l'application
    * */
    public function setupComplete()
    {
        try{
            $setupStage = Setting::firstOrFail();
            if($setupStage->setup_stage != '3'){
                return redirect()->back()->withInput()->withErrors(['errors' => 'La configuration est incomplète']);
            }
            $setupStage->update(['setup_stage' => '4']);
            Setting::firstOrFail()->update(['setup_complete' => '1']);
            return view('install.complete');
        }catch(Exception $e){
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }

}
