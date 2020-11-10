<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Report Room Maintenance Costs<title>
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
            text-align: center;
            vertical-align: middle;
        }

    </style>
    <center>
        <font size="6" face="arial">SIMPLY APARTMENT</font>
    </center>
    <center><b>
            <font size="2" face="arial">Jl. Ciung Wanara IV No.28, Renon, Renon Denpasar, Kota Denpasar, Bali 80234
            </font>
        </b></center>
    <center><b>
            <font size="2" face="arial">Telp. (0623) 61226707 Phone. +62 878-6014-8529</font>
        </b></center>
    <hr width="100%"></hr>
                    <center>
                        @if($data_type == 1)
                        <font size="5" face="arial">Report Maintenance Cost</font><br>
                        <b><u>{{ \Carbon\Carbon::parse($date_start)->format('d-m-Y') }}</u></b> - <b><u>{{ \Carbon\Carbon::parse($date_finish)->format('d-m-Y') }}</u></b> 
                        <br><br>
                        @else
                        <font size="5" face="arial">Urgency Report Maintenance Cost</font><br>
                        <b><u>{{ \Carbon\Carbon::parse($m)->format('F') }}</u></b> - <b><u>{{ \Carbon\Carbon::parse($y)->format('Y') }}</u></b> 
                        <br><br>
                        @endif
                    </center>
                    @foreach($data_room as $darom)
                <font size="3" face="arial">Room {{$darom->roomnumber}} :</font><br>
                    <table border='1' width='100%' cellspacing='0'>
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;">No</th>
                                <th style="vertical-align: middle;">Date Maintenance</th>
                                <th style="vertical-align: middle;">Code Inventory</th>
                                <th style="vertical-align: middle;">Product Name</th>
                                <th style="vertical-align: middle;">Model</th>
                                <th style="vertical-align: middle;">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1 @endphp
                            @foreach($data_maintenance_costs as $dacos)
                                @if(($darom->roomnumber == $dacos->roomnumber))
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ \Carbon\Carbon::parse($dacos->date_maintenance)->format('d-m-Y') }}</td>
                                        <td>{{$dacos->codeinven}}</td>
                                        <td>{{$dacos->proname}}</td>
                                        <td>{{$dacos->model}}</td>
                                        <td>{{$dacos->cost}}</td>
                                    </tr>
                                @endif
                            @endforeach
                            @foreach($data_cost as $cost)
                                @if(($cost->roomnumber == $darom->roomnumber))
                                    <tr>
                                        <td colspan="5"><b>Total Cost</b></td>
                                        <td>{{$cost->total_cost}}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                    @endforeach
</body>

</html>
