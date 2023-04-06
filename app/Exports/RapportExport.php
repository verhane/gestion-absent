<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class RapportExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $dpointage;
    public function __construct($dpointages)
    {
        $this->dpointage = $dpointages;
    }
    public function view(): View
    {
        return view('rapports.export.listExcel', [
            'detailspointages' =>$this->dpointage
        ]);
    }
}
