<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PresenceExport implements FromView
{
    use Exportable;

    public function __construct($presence)
    {
        $this->presence = $presence;
    }

    public function view(): View
    {
        //
        return view('presences.excel', [
            'presences' => $this->presence
        ]);
    }
}