<table style="border: 1 dashed black">
  <tr>
    <th colspan="5" style="font-weight: bold;">
      <span>작업지시서전표</span>
    </th>
  </tr>

  <tr>
    <th colspan="5" style="font-weight: bold;">
      <span>전표번호</span>
      <span> : {{ $details['job_ord'] }}</span>
    </th>
  </tr>

  <tr>
    <th style="font-weight: bold; text-align: center;">품목코드</th>
    <th style="font-weight: bold; text-align: center;">품명 및 규격</th>
    <th style="font-weight: bold; text-align: center;">생산공장명</th>
    <th style="font-weight: bold; text-align: center;">수량</th>
    <th style="font-weight: bold; text-align: center;">안전재고</th>
  </tr>

  @foreach ($details['summary'] as $tr)
    <tr>
      <td>{{ $tr['item_id'] }}</td>
      <td>{{ $tr['item_nm'] }}</td>
      <td>{{ $tr['fact_nm'] }}</td>
      <td style="text-align: right;">{{ $tr['ord_qty'] }}</td>
      <td></td>
    </tr>
  @endforeach

  <tr>
    <th colspan="5">
      {{ $details['summary_dt'] }}
    </th>
  </tr>
</table>

<table style="border: 1 dashed black">
  <tr>
    <th colspan="6" style="font-weight: bold;">
      <span>작업지시서전표</span>
    </th>
  </tr>
  <tr>
    <th style="font-weight: bold; text-align: center;">품목코드</th>
    <th style="font-weight: bold; text-align: center;">품명 및 규격</th>
    <th style="font-weight: bold; text-align: center;">소요량</th>
    <th style="font-weight: bold; text-align: center;">안전재고수량</th>
    <th style="font-weight: bold; text-align: center;">함량비(%)</th>
    <th style="font-weight: bold; text-align: center;">원산지</th>
  </tr>

  @foreach ($details['details'] as $detail)
    @foreach ($detail['subdetails'] as $tr)
      <tr>
        <td>{{ $tr['item_id'] }}</td>
        <td>{{ $tr['item_nm'] }}</td>
        <td style="text-align: right;">{{ $tr['req'] }}</td>
        <td></td>
        <td style="text-align: center;">{{ $tr['ratio'] }}</td>
        <td>{{ $tr['origin'] }}</td>
      </tr>
    @endforeach
    <tr>
      <td colspan="2" style="text-align: center;">합계</td>
      <td style="text-align: right;">{{ $detail['reqSum'] }}</td>
      <td></td>
      <td style="text-align: center;">{{ $detail['ratio'] }}</td>
      <td>{{ $detail['origin'] }}</td>
    </tr>
  @endforeach

  <tr>
    <th colspan="6">
      {{ $details['details_dt'] }}
    </th>
  </tr>
</table>