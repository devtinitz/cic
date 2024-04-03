<?php

namespace App\Jobs;

use App\Models\Setting;
use App\Models\Presencecic;
use FPDF;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;


class GeneratePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var App\Modeles\Presencecic;
     * 
     */
    public $presences;
    public $setting;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($presences, $setting)
    {
        $this->presences = $presences;
        $this->setting = $setting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Découpage des données en fichiers PDF temporaires
        $batchSize = 100; // Nombre de présences par fichier PDF
        $presences = $this->presences->chunk($batchSize);
        $pdfFiles = [];

        $pdf = new FPDF(); // Initialisez FPDI
        $pdf->AddPage('L');
    
        // Générez le contenu du PDF pour ce lot de présences
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 10, 'LISTE DES PRESENCES', 0, 1, 'C');
        $pdf->Ln(10);
        // Créez un tableau pour afficher les données de présence
        $header = array('Date', 'Employe', 'Direction', 'Arrivee', 'Depart', 'Duree', 'Heure(s) Sup');
    
        // Dessinez le tableau dans le PDF
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 30); // Position du tableau
        $cellWidth = 30; // Largeur de la cellule
        $cellHeight = 7; // Hauteur de la cellule
    
        foreach ($header as $column) {
            if ($column === 'Employe') {
                $pdf->Cell(65, $cellHeight, $column, 1);
            }elseif ($column === 'Direction') {
                $pdf->Cell(50, $cellHeight, $column, 1);
            }elseif ($column === 'Heure(s) Sup' || $column === 'Date') {
                $pdf->Cell(35, $cellHeight, $column, 1);
            }else {
                $pdf->Cell($cellWidth, $cellHeight, $column, 1);
            }
        }
        $pdf->Ln(); // Aller à la ligne
    
        foreach ($presences as $index => $chunk) {
            // Dessinez les données dans le tableau
            foreach ($chunk as $presence) {
                $firstScan = $presence->scan()->first_scan;
                $lastScan = $presence->scan()->last_scan;
                $duree = $this->getTime($firstScan, $lastScan)['duree'];
                $tempSup = $this->getTime($firstScan, $lastScan)['tempSup'];

                $pdf->SetX(10); // Réinitialisez la position X pour chaque ligne de données
                $pdf->Cell(35, $cellHeight, date('d/m/Y', strtotime($presence->authDate)), 1);
                $pdf->Cell(65, $cellHeight, Str::limit($presence->personName, 18, ' ...'), 1);
                $pdf->Cell(50, $cellHeight, $presence->deviceName, 1);
                $pdf->Cell($cellWidth, $cellHeight, date('H:i:s', strtotime($firstScan)), 1);
                $pdf->Cell($cellWidth, $cellHeight, date('H:i:s', strtotime($lastScan)), 1);
                $pdf->Cell($cellWidth, $cellHeight, $duree.' min', 1); // Cellule vide pour 'Temps de travail'
                $pdf->Cell(35, $cellHeight, $tempSup.' min', 1); // Cellule vide pour 'Heure(s) Sup'
                $pdf->Ln(); // Aller à la ligne après chaque ligne de données
            }
        }
        
        // Enregistrez le fichier PDF temporaire
        $tempPdfPath = storage_path('app/temp/presences.pdf');
        $pdf->Output($tempPdfPath, 'F', true);
        $pdfFiles[] = $tempPdfPath;

        $outputPdf = new Fpdi();
        foreach ($pdfFiles as $pdfFile) {
            $pageCount = $outputPdf->setSourceFile($pdfFile);
            for ($pageIndex = 1; $pageIndex <= $pageCount; $pageIndex++) {
                $outputPdf->AddPage('L');
                $template = $outputPdf->importPage($pageIndex);
                $outputPdf->useTemplate($template);
            }
        }
    
        $outputPdfPath = public_path('pdf/merged_presences.pdf');
        $outputPdf->Output($outputPdfPath, 'F');
    
        // Supprimer les fichiers temporaires (optionnel si tu fusionnes)
        foreach ($pdfFiles as $pdfFile) {
            unlink($pdfFile);
        }
/*     
        // Afficher le PDF fusionné à l'utilisateur (par exemple, le télécharger)
        return response()->download($outputPdfPath, 'merged_presences.pdf')->deleteFileAfterSend(true);
*/  }

    /**
     * Recuperation de la duree et heures sup de travail
     * @param DateTime $firstScan|$lastScan
     */
    public function getTime($firstScan, $lastScan){
        $temp = 0;
        $duree = 0;

        // On convertie les heures de début et de fin de pointage en objets Carbon
        $heureDebutPointage = \Carbon\Carbon::parse(date('H:i:s', strtotime($firstScan)));
        $heureFinPointage = \Carbon\Carbon::parse(date('H:i:s', strtotime($lastScan)));

        //On calcule et formate la duree de presence
        $duree = $heureDebutPointage->diffInMinutes($heureFinPointage);

        // On convertie les heures de début et de fin de travail en objets Carbon
        $heureDebut = \Carbon\Carbon::parse($this->setting->debut_matin);
        $heureFin = \Carbon\Carbon::parse($this->setting->fin_soir);

        // On initialise le temps supplémentaire à 0 secondes
        $tempsSupplementaire = 0;

        // On calcule le temps supplémentaire le matin (avant l'heure de début)
        if ($heureDebutPointage->lt($heureDebut)) {
            $tempsSupplementaire += $heureDebutPointage->diffInMinutes($heureDebut);
        }

        // On calcule le temps supplémentaire le soir (après l'heure de fin)
        if ($heureFinPointage->gt($heureFin)) {
            $tempsSupplementaire += $heureFinPointage->diffInMinutes($heureFin);
        }

        // Formatage du temps supplémentaire
        $tempSup = $tempsSupplementaire;

        return [
            'duree' => $duree,
            'tempSup' => $tempSup,
        ];
    }
}
