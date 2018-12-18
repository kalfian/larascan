<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <style>
        div.center{
            text-align: center;
            display: inline-block;
        }
        h3{
            margin-left:15px;
            text-align: left;
            font-family: Arial, Helvetica, sans-serif
        }
        .barcode{
            margin: 0 10px 10px;
            width: 3cm;
            padding:1mm;
            vertical-align: center;
            /* display: inline-block; */
            float: left;
            border:1px solid #ccc;
        }
        .text-center{
            text-align: center;
        }
        p{
            margin:0;
            font-size: 10px;
        }
        table tr td{
            text-align: center;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <div class="center">
    @foreach($data as $datas)
        <h3>{{ $datas->loc }}</h3>
        @for($a=1;$a<=$datas->karton;$a++)
            <div class="barcode">
                <img style="max-width:100%" src="data:image/png;base64,{{DNS1D::getBarcodePNG($datas->barcode, 'I25', 1)}}" alt="Barcode">
                <p class="text-center">{{ $datas->barcode }}</p>
            </div>
        @endfor
        <br><br><br><br>
    @endforeach
    </div>
</body>
</html>