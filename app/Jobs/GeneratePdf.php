<?php

namespace App\Jobs;

use App\Models\Setting;
use App\Models\Presencecic;
use PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use setasign\Fpdi\Fpdi;

class GeneratePdf implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $presences;
    protected $userId;
    protected $setting;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($presences, Setting $setting)
    {
        $this->presences = $presences;
        //$this->userId = $userId;
        $this->setting = $setting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach ($this->presences as $presence){
            dd($presence);
        }
    
    }


     /* //dd($this->presence);
        $data['setting'] = $this->setting;
        $data['total'] = $this->presence->count();
        $data['presences'] = $this->presence;
        $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->setPaper('a4', 'landscape')
            ->loadView('presences.pdf', $data);

            return $pdf->stream('presences.pdf'); */

        // Découpage des données en fichiers PDF temporaires
        /* $batchSize = 100; // Nombre de présences par fichier PDF
        $presences = $this->presence->chunk($batchSize);

        $setting = $this->setting;
        
        $pdfFiles = [];
        foreach ($presences as $index => $chunk) {
            Log::alert($chunk);
            break;
            $pdf = new Fpdi();
            $pdf->SetFont('Arial', '', 12);
            // Ajoute une nouvelle page pour chaque lot de données
            $pdfContent = view('presences.pdf', ['presences' => $chunk, 'setting' => $setting])->render();
            $pdf->AddPage();
            $pdf->Write(0, $pdfContent);
            // Enregistre le fichier PDF temporaire
            $tempPdfPath = storage_path('app/temp/presences_' . $index . '.pdf');
            $pdf->Output($tempPdfPath, 'F');
            $pdfFiles[] = $tempPdfPath;
        }

        $outputPdf = new Fpdi();
        foreach ($pdfFiles as $pdfFile) {
            $pageCount = $outputPdf->setSourceFile($pdfFile);
            for ($pageIndex = 1; $pageIndex <= $pageCount; $pageIndex++) {
                $outputPdf->AddPage();
                $template = $outputPdf->importPage($pageIndex);
                $outputPdf->useTemplate($template);
            }
        }

        $outputPdfPath = storage_path('app/temp/merged_presences.pdf');
        $outputPdf->Output($outputPdfPath, 'F');

        // Supprimer les fichiers temporaires (optionnel si tu fusionnes)
        foreach ($pdfFiles as $pdfFile) {
            unlink($pdfFile);
        }

        // Afficher le PDF fusionné à l'utilisateur (par exemple, le télécharger)
        return response()->download($outputPdfPath, 'merged_presences.pdf')->deleteFileAfterSend(true); */
}
