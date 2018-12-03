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
    <table>
    @for($a=1;$a<=$karton;$a++)
        @if($a == 1)
        <tr>
        @endif
            <td width="33%">
                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($barcode, 'I25', 1.5)}}" alt="Barcode">
                <p class="text-center">{{ $barcode }}</p>
            </td>
            </td>
        <?php $mod = $a%3; ?>
        @if($mod == 0 )
        </tr>
        <tr>
        @endif
    @endfor
    </table> 
    </div>
</body>
</html>