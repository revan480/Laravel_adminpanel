@extends(backpack_view('blank'))

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css -->

    <title>Document</title>
</head>
<style>
    /* Body styles */
    body {
    margin: 0;
    padding: 0;
    font-family: Verdana;
    background-color: #f5f5f5;
    }

    /* Header styles */
    header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
    }

    header h1 {
    margin: 0;
    }


    .room-selector{
        display: inline-block;
        margin: 10px;
    }

    .doctor-selector{
        display: inline-block;
        margin: 10px;
    }

    .form-group{
        display: inline-block;
        margin: 10px;

    }

    /* Checkout styles */
    .checkout {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: right;
    }

    .checkout h2 {
    margin: 0;
    }

    .checkout h2 span {
    font-weight: normal;
    }

    .checkout input[type="submit"] {
    background-color: #333;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }

    .checkout input[type="submit"]:hover {
    background-color: #555;
    }


    /* Media queries */
    @media screen and (max-width: 768px) {
    .main-content {
        flex-direction: column;
    }

    .sidebar {
        margin-right: 0;
        margin-bottom: 20px;
    }

    .room-box {
        width: 100%;
        margin-right: 0;
    }
    .btn-primary {
        margin-left: 10px;
    }
    #total-price:hover{
        cursor: pointer;
    }
}
</style>
<!-- Include the necessary CSS and JS files for table sorting and pagination -->

<body>
    <div id="price" style="background: linear-gradient(to right, #43cea2, #185a9d); color: white; width: 100%; max-width: 1800px; font-size: 32px; text-align: center; padding: 15px; padding-left: 10px; margin-top: 20px; border-radius: 5px; display: flex; justify-content: center; margin-left: auto; margin-right: auto;">
        Cəmi: {{ $total_bill }}
    </div>
    <div class="container" style="margin-top: 10px;">
        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('page.bill.checkout') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
                    @csrf
                    <div class="room-selector">
                        <label for="room-select">Otaq:</label>
                        <select id="room-select" name="room_selector">
                            <option value="">-</option>
                            <?php
                                foreach ($rooms as $room) {
                                    echo '<option value="' . $room->number . '">' . $room->number . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="doctor-selector">
                        <label for="doctor-name">Həkim adı:</label>
                        <select id="doctor-name" name="doctor_name">
                            <option value="">-</option>
                            <?php
                                foreach ($doctors as $doctor) {
                                    echo '<option value="' . $doctor->name . '">' . $doctor->name . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Tarix:</label>
                        <input type="date" id="fromDate" name="fromDate">
                        <label for="untilDate">-dan</label>
                        <input type="date" id="untilDate" name="untilDate">
                        <label for="untilDate">-dək</label>
                    </div>
                    <div class="form-group">
                        <label for="card">Ödəniş növü:</label>
                        <select name="card" id="card-select">
                            <option value="">-</option>
                            <?php
                                foreach ($bills as $bill) {
                                    echo '<option value="' .$bill->bill_name. '">' . $bill->bill_name . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="packet">Paket:</label>
                        <select name="packet" id="packet-select">
                            <option value="">-</option>
                            <?php
                                foreach ($packets as $packet) {
                                    echo '<option value="' .$packet->name. '">' . $packet->name . '</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <form method="GET" action="{{ route('page.bill.checkout') }}">
                        <input type="text" name="search" placeholder="Search...">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </form>
                </form>
            </div>
        </div>

        <div id="content">
            @if(session()->has('message'))
                <div class="alert alert-{{ session()->get('alert-type') }} alert-dismissible fade show" role="alert" id="alert-message">
                    {{ session()->get('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-body">
                <table id="checkout_table" class="table table-bordered table-striped table-hover datatable datatable-booking" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Xəstə adi</th>
                            <th>Xəstə soyadi</th>
                            <th>Otaq</th>
                            <th>Mütəxəssis</th>
                            <th>Giymət</th>
                            <th>Rezervasiya tarixi</th>
                            <th>Telefon</th>
                            <th>Ödəniş növü</th>
                            <th>Paket</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                            <tr data-entry-id="{{ $patient->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $patient->name }}</td>
                                <td>{{ $patient->surname }}</td>
                                <?php
                                    $room = DB::table('rooms')->where('id', $patient->room_id)->first();
                                ?>
                                <td>{{ $room->number }}</td>
                                <?php
                                    $doctor = DB::table('doctors')->where('id', $patient->doctor_id)->first();
                                ?>
                                <td>{{ $doctor->name }}</td>
                                <td>{{ $patient->price }}</td>
                                <td>{{ $patient->date }}</td>
                                <td>{{ $patient->phone }}</td>
                                <?php
                                    $bill = DB::table('bills')->where('id', $patient->bill_id)->first();
                                ?>
                                <td>{{ $bill->bill_name }}</td>
                                <?php $packet = DB::table('packets')->where('id', $patient->packet_id)->first();
                                ?>
                                @if($patient->packet_id == $packet_id)
                                    <td>Yoxdur</td>
                                @else
                                    <td>{{ $packet->name }}</td>
                                @endif
                                <td>
                                    <a href="{{ backpack_url('patient/'.$patient->id.'/edit') }}" class="btn btn-sm btn-primary">Redaktə et</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">{{ __('İnformasiya yoxdur') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Xəstə adi</th>
                            <th>Xəstə soyadi</th>
                            <th>Otaq</th>
                            <th>Mütəxəssis</th>
                            <th>Giymət</th>
                            <th>Rezervasiya tarixi</th>
                            <th>Ödəniş növü</th>
                            <th>Paket</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
</body>


</html>
@endsection
