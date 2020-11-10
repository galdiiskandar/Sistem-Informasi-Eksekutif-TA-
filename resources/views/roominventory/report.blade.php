<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Report Room Inventories</title>  
  </head>    
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
      text-align: center;
      vertical-align: middle;
		}
  </style>
  <center><font size="6" face="arial">SIMPLY APARTMENT</font></center>
  <center><b><font size="2" face="arial">Jl. Ciung Wanara IV No.28, Renon, Renon Denpasar, Kota Denpasar, Bali 80234</font></b></center>
  <center><b><font size="2" face="arial">Telp. (0623) 61226707 Phone. +62 878-6014-8529</font></b></center>
  <hr width="100%"></hr>
  @foreach($data_room as $daron)
	<center>
  <h5>Laporan Room Inventories {{$daron->roomnumber}}</h5>
	</center>
	<table border='1' width='100%' cellspacing='0'>
		<thead>
			<tr>
        <th rowspan="2" style="vertical-align: middle;">No</th>
        <th rowspan="2" style="vertical-align: middle;">Code Inventory</th>
				<th rowspan="2" style="vertical-align: middle;">Product Name</th>
				<th rowspan="2" style="vertical-align: middle;">Model</th>
				<th rowspan="2" style="vertical-align: middle;">Serial Number</th>
        <th rowspan="2" style="vertical-align: middle;">Purchase Date</th>
        <th colspan="3" style="vertical-align: middle;">Condition</th>
				<th rowspan="2" style="vertical-align: middle;">Information</th>
      </tr>
      <tr>
        <th style="vertical-align: middle;">Very Good</th>
        <th style="vertical-align: middle;">Good</th>
        <th style="vertical-align: middle;">Bad</th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
      @foreach($data_room_inventory as $daroin)
      @if($daron->roomnumber == $daroin->roomnumber)
			<tr>
        <td>{{$i++}}</td>
        <td>{{$daroin->code_inventory}}</td>
        <td>{{$daroin->productname}}</td>
        <td>{{$daroin->model}}</td>
        <td>{{$daroin->product_serial_number}}</td>
        <td>{{\Carbon\Carbon::parse($daroin->purchase_date)->format('d-m-Y')}}</td>
        @if($daroin->condition == "Very good")
          <td>V</td>
          <td></td>
          <td></td>
        @endif
        @if($daroin->condition == "Good")
          <td></td>
          <td>V</td>
          <td></td>
        @endif
        @if($daroin->condition == "Bad")
          <td></td>
          <td></td>
          <td>V</td>
        @endif
        <td>{{$daroin->information}}</td>
      </tr>
      @endif
			@endforeach
    </tbody>
  </table>
  <br>
  @endforeach
  </body>
</html>