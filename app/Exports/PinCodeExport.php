<?php

namespace App\Exports;

use App\PinCode;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings; 

class PinCodeExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return PinCode::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'PinCode',
            'is_used',
            'create',
            'updated_at'
            // etc


        ];
    }
}
