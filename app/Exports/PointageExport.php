<?php

namespace App\Exports;

use App\Models\Pointage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
 class PointageExport implements FromView
{
    public $pointage;
    public function __construct($pointages)
    {
        $this->pointage = $pointages;
    }
    public function view(): View
    {
        return view('pointages.Export.excelPointage', [
            'pointages' =>$this->pointage
        ]);
    }
}
