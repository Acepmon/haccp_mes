<?php

namespace App\Exports;

use App\CommCd;
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
        return User::orderBy('REG_DTM', 'desc')->get();
    }

    public function map($user): array
    {
        $roles = CommCd::where('COMM1_CD', 'A10')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $user->ROLE_CD))->get();
        $approvals = CommCd::where('COMM1_CD', 'A20')->whereNotIn('COMM2_CD', ['$$'])->whereIn('COMM2_CD', explode(',', $user->APPR_CD))->get();

        return [
            $user->USER_ID,
            $user->USER_NM,
            $user->USER_PW,
            $user->EMAIL,
            implode(',', $approvals->pluck('COMM2_NM')->toArray()),
            implode(',', $roles->pluck('COMM2_NM')->toArray()),
            now()->parse($user->REG_DTM)->format('Y-m-d')
        ];
    }

    public function headings(): array
    {
        return [
            '사용자 ID',
            '이름',
            '비밀번호',
            '이메일',
            '메뉴접근권한',
            '담당업무',
            '등록일시',
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
