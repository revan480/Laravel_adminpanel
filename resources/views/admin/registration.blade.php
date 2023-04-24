@extends(backpack_view('blank'))

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration Form</title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    {{-- <style>
        body {
            font-family: Verdana;
            background-color: #f2f2f2;
        }
        .form-container {
            max-width: 1880px;
            margin: 110px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
        }

        .form-group {
            margin-bottom: 30px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .form-row label,
        .form-row input,
        .form-row select {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-row label {
            text-align: left;
        }

        .form-row select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-row select:focus {
            border-color: #14aba2;
            outline: none;
        }

        .form-row input:focus {
            border-color: #14aba2;
            outline: none;
        }

        .form-row .form-group-2,
        .form-row .form-group-3 {
            width: calc(50% - 10px);
        }

        .form-row .form-group-2 select,
        .form-row .form-group-3 select {
            width: 100%;
        }

        .form-row .form-group-3 input {
            width: 100%;
        }

        .feedback-group {
            margin-bottom: 30px;
        }

        .feedback-label {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .feedback-input {
            width: 100%;
            height: 100px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .feedback-input:focus {
            border-color: #14aba2;
            outline: none;
        }
        .btn-submit {
            background-color: #14aba2;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #02657e;
        }

        @media (max-width: 768px) {
            .form-row .form-group-2,
            .form-row .form-group-3 {
                width: 100%;
                margin-bottom: 20px;
            }
        }
    </style> --}}
</head>
<body>
    <div class="form-container">
        <h2>Müştəri Qeydiyyatı</h2>
        <form action="{{ route('page.registration.store') }}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputName">Müştərinin adı</label>
                    <input type="text" class="form-control" id="inputName" name="name" placeholder="Ad" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputSurname">Müştərinin Soyadı</label>
                    <input type="text" class="form-control" id="inputSurname" name="surname" placeholder="Soyad" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPhone">Telefon nömrəsi</label>
                    <input type="tel" class="form-control" id="inputPhone" name="phone" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" placeholder="050XXXXXXX" required>
                    <small>Məsələn: 0502110415</small>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputArea">Nahiyə</label>
                    <input type="text" class="form-control" id="inputArea" name="area" placeholder="Nahiyə" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPrice">Qiymət (AZN)</label>
                    <input type="number" class="form-control" id="inputPrice" name="price" placeholder="Qiymət" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputDate">Tarix</label>
                    <input type="datetime-local" class="form-control" id="inputDate" name="date"  placeholder="Tarix" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="inputDoctor">Mütəxəssis</label>
                    <select class="form-control" id="inputDoctor" name="doctor" required>
                        <option value="">Mütəxəssis seçin</option>
                        <?php
                            foreach ($doctors as $doctor) {
                                echo '<option value="'.$doctor->id.'">'.$doctor->name.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputRoom">Otaq nömrəsi</label>
                    <select class="form-control" id="inputRoom" name="room" required>
                        <option value="">Otaq seçin</option>
                        <?php
                            foreach ($rooms as $room) {
                                echo '<option value="'.$room->id.'">Otaq '.$room->number.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputCard">Ödəniş növü</label>
                    <select class="form-control" id="inputCard" name="bill" required>
                        <option value="">Ödəniş növünü seçin</option>
                        <option value="1">Nəğd</option>
                        <?php
                            foreach($bills as $bill){
                                if($bill->type == 'card')
                                    echo '<option value="'.$bill->id.'">'.$bill->name.'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="inputPacket">Paket</label>
                    <select class="form-control" id="inputPacket" name="packet">
                        <option value="1">Paket Yoxdur</option>
                        <?php
                            foreach ($packets as $packet) {
                                if($packet->name != 'Yoxdur')
                                    echo '<option value="'.$packet->id.'">Paket '.$packet->name.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputFeedback">Qeyd (İstəyə bağlı)</label>
                    <textarea class="form-control" id="inputFeedback" name="feedback" placeholder="Qeydlərinizi daxil edin"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <button type="submit" class="btn btn-primary">Qeyd et</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

@endsection
