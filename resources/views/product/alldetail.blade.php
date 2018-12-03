<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report</title>
    <style>
        div.center{
            text-align: center;
        }
        table{
            width: 200mm;
            text-align: center;
        }
        .container{
            width: 210mm;
        }
        .barcode-container{
            width: 60mm;
            float: left;
        }
        .text-center{
            text-align: center;
        }
        p{
            margin-top:0;
            font-size: 12px;
        }
        table tr td{
            text-align: center;
            padding: 0 10px;
        }
    </style>
</head>
<body>
    <div class="center">
    <?php $b=1; ?> 
    @foreach($data as $datas)
    
    @for($a=1;$a<=$datas->karton;$a++)
    
        <div class="barcode-container">
            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($datas->barcode, 'I25', 1.5)}}" alt="Barcode">
            <p class="text-center">{{ $datas->barcode }}</p>
        </div>
        <?php $mod = $b%3; ?>
        @if($mod == 0)
        <br><br><br><br>
        @endif
    <?php $b++; ?>
    @endfor
    @endforeach
    </div>
</body>
</html>