<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectExport implements WithHeadings, FromArray
{
    protected $data;
    protected $months;

    public function __construct($data, $months)
    {
        $this->data = $data;
        $this->months = $months;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        $to_return =  [
            'Group',
            'Task',
            'Unit',
            'Start Date',
            'End Date',
            'No. of Units',
            'Unit Price',
            'Total Task Value',

        ];

        foreach ($this->months as $month) {
            $to_return[] = $month;
        }

        $to_return = array_merge($to_return, [
            'Units Done',
            'Units incl Forecast',
            'Amount Done',
            'Status',
        ]);

        return $to_return;
    }
}
