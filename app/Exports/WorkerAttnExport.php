<?php

namespace App\Exports;

use App\WorkerAttn;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkerAttnExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    public $from, $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $items = WorkerAttn::query();

        if (!empty($this->from)) {
            $items = $items->whereDate('ON_DTM', '>=', now()->parse($this->from)->format('YmdHis'));
        }

        if (!empty($this->to)) {
            $items = $items->whereDate('ON_DTM', '<=', now()->parse($this->to)->format('YmdHis'));
        }

        $items = $items->with(['worker'])->orderBy('ON_DTM', 'ASC');

        return $items->get();
    }

    public function map($workerAttn): array
    {
        return [
            $workerAttn->EMP_ID,
            $workerAttn->worker->EMP_NM,
            now()->parse($workerAttn->ON_DTM)->format('Y-m-d H:i'),
            (!empty($workerAttn->OFF_DTM)) ? now()->parse($workerAttn->ON_DTM)->diffInHours(now()->parse($workerAttn->OFF_DTM)) . ' hours' : '',
            (!empty($workerAttn->OFF_DTM)) ? now()->parse($workerAttn->OFF_DTM)->format('Y-m-d H:i') : '',
        ];
    }

    public function headings(): array
    {
        return [
            '사번',
            '이름',
            '출근일시',
            'duration',
            '퇴근일시',
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
