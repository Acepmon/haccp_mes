<?php

namespace App\Exports;

use App\CcpData;
use App\CommCd;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CcpDataExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $from, $to, $deviceId;

    public function __construct($from, $to, $deviceId)
    {
        $this->from = $from;
        $this->to = $to;
        $this->deviceId = $deviceId;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = CcpData::select('DEVICE_ID AS DEVICE', 'DATA', 'REG_DTM');

        if (!empty($this->deviceId)) {
            $items = $items->where('DEVICE_ID', $this->deviceId);
        }

        if (!empty($this->from)) {
            $from = now()->parse($this->from)->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) >= ' . intval($from));
        }

        if (!empty($this->to)) {
            $to = now()->parse($this->to)->format('YmdHis');
            $items = $items->whereRaw('CAST(REG_DTM AS SIGNED) <= ' . intval($to));
        }

        $items = $items->orderBy('REG_DTM', 'DESC');

        return $items->get();
    }

    public function map($ccpData): array
    {
        return [
            CommCd::where('COMM1_CD', 'C00')->whereNotIn('COMM2_CD', ['$$'])->where('COMM2_CD', $ccpData->DEVICE)->value('COMM2_NM'),
            $ccpData->DATA,
            now()->parse($ccpData->REG_DTM)->format('Y-m-d H:i:s'),
        ];
    }

    public function headings(): array
    {
        return [
            '장비명',
            '데이터',
            '일시',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
