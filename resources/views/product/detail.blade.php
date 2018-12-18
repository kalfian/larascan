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
    @for($a=1;$a<=$karton;$a++)
        <div class="barcode">
            <img style="max-width:100%" src="data:image/png;base64,{{DNS1D::getBarcodePNG($barcode, 'I25', 1)}}" alt="Barcode">
            <p class="text-center">{{ $barcode }}</p>
        </div>
    @endfor
    </div>
</div>
</body>
</html>