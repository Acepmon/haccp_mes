<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::orderBy('reg_dtm', 'desc')->get();
    }

    public function map($user): array
    {
        return [
            $user->user_id,
            $user->user_nm,
            $user->email,
            $user->role_cd,
            $user->job_cd,
            $user->appr_cd,
            $user->user_sts_yn,
            $user->reg_id,
            now()->parse($user->reg_dtm)->format('Y-m-d')
        ];
    }

    public function headings(): array
    {
        return [
            'User ID',
            'User Name',
            'Email',
            'Role CD',
            'Job CD',
            'APPR_CD',
            'STATUS',
            'Register ID',
            'Register Date'
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
