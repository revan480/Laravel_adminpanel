@extends(backpack_view('blank'))

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Verdana;
        }
        .boxes {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
            text-decoration: none;
        }

        .box {
            margin-right: 30px;
            margin-left: 30px;
            width: 300px;
            height: 200px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            text-align: center;
            color: #000000;
            text-decoration: none;
        }
        .box a {
        text-decoration: none;
        }
        .boxes a:hover {
        text-decoration: none;
        }

        .box:hover {
            background-color: #ddd;
            cursor: pointer;
        }

        .box img {
            max-width: 60%;
            max-height: 60%;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .box h3 {
            font-size: 20px;
        }

        .navbar a:last-child {
            float: right;
            color: white;
        }

        @media (max-width: 768px) {
            .navbar a {
                float: none;
                display: block;
                text-align: center;
            }

            .boxes {
                display: block;
                margin-top: 0;
            }

            .box {
                margin: 30px auto;
            }
        }
        .settings {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-top: 10px;

          }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="logout.php">Çıxış</a>
    </div>
    <div class="settings">
      <h2>Tənzimləmələr</h2>
      <p>Hər hansı birini seçin</p>
    </div>
    <div class="boxes">
        <a href="/admin/room">
            <div class="box">
                <img src="/images/adminpanel/room.png" alt="register">
                <h3>Otaqlar</h3>
            </div>
        </a>
        <a href="/admin/doctor">
            <div class="box">
                <img src="/images/adminpanel/personal.png" alt="checkout">
                <h3>İşçilər</h3>
            </div>
        </a>
        <a href="/admin/bill">
            <div class="box">
                <img src="/images/adminpanel/payment.png" alt="admin">
                <h3>Ödəniş növləri</h3>
            </div>
        </a>
    </div>
</body>
</html>
@endsection
