<table>
    <tr>
        <th style="font-weight: bold;">{{ $jobOrd->JOB_NO }}</th>
        <th style="font-weight: bold;">{{ $jobOrd->ITEM_ID }}</th>
        <th style="font-weight: bold;">{{ $jobOrd->ITEM_NM }}</th>
        <th style="font-weight: bold;">{{ $jobOrd->ORD_QTY }}</th>
        <th style="font-weight: bold;">{{ $jobOrd->PROD_QTY }}</th>
        <th style="font-weight: bold;">{{ $jobOrd->ORD_NM }}</th>
        <th style="font-weight: bold;">{{ $jobOrd->FACT_CD }}</th>
    </tr>

    <tr>
        <th style="font-weight: bold;">>공정순서</th>
        <th style="font-weight: bold;">>공정명</th>
        <th style="font-weight: bold;">>공정내용</th>
        <th style="font-weight: bold;">>소요시간</th>
        <th style="font-weight: bold;">>CCP 유무</th>
        <th style="font-weight: bold;">>시작시간</th>
        <th style="font-weight: bold;">>종료시간</th>
        <th style="font-weight: bold;">>작업자</th>
    </tr>

    @foreach ($items as $item)
        <tr>
            <td>{{ $item->SEQ_NM }}</td>
            <td>{{ $item->PROC_NM }}</td>
            <td>{{ $item->PROC_DTL }}</td>
            <td>{{ $item->PROC_TIME }}</td>
            <td>{{ $item->CCP_YN }}</td>
            <td>{{ $item->SRT_DTM }}</td>
            <td>{{ $item->END_DTM }}</td>
            <td>{{ $item->EMP_NM }}</td>
        </tr>
    @endforeach
</table>