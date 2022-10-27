<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class TimesheetExport implements FromView, WithColumnFormatting
{
    /**
     * @return \Illuminate\Support\Collection
     */
    // public function collection()
    // {
    //     //
    // }
    public function __construct($data)
    {
        $this->data = $data;
        // $this->bulan = $bulan;
        // $this->tahun = $tahun;
    }

    public function view(): View
    {

        // dd($this->data);
        return view('pdf.excel', [
            'data'  => $this->data,
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'A' => 0
        ];
    }
}
