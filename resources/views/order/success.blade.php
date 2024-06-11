<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <style>
        ._failed{ border-bottom: solid 4px red !important; }
        ._failed i{  color:red !important;  }

        ._success {
            box-shadow: 0 15px 25px #00000019;
            padding: 45px;
            width: 100%;
            text-align: center;
            margin: 40px auto;
            border-bottom: solid 4px #28a745;
        }

        ._success i {
            font-size: 55px;
            color: #28a745;
        }

        ._success h2 {
            margin-bottom: 12px;
            font-size: 40px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 10px;
        }

        ._success p {
            margin-bottom: 0px;
            font-size: 18px;
            color: #495057;
            font-weight: 500;
        }

        .links {
            width: 100%;
            display: flex;
            gap: 8px;
        }

        .links a {
            text-decoration: none;
            color: green;
            border: 1px solid green;
            padding: 4px 8px;

        }

        .links a:hover {
            border: 1px solid blue;
            color: blue;
        }
    </style>

</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was successful </h2>
                    <p> Thank you for your payment. we will <br>
    be in contact with more details shortly </p>
                </div>
            </div>
        </div>
    </div>
    <div class=" links row justify-content-center">
        <a href="{{route('product.index')}}" >
            Shop again
        </a>
        <a href="/order/{{$order->id}}">
            See orders
        </a>
        <a target="_blank" href="/order/{{$order->id}}/download-invoice">
            Download invoice
        </a>
    </div>
    <hr>
</body>
</html>

