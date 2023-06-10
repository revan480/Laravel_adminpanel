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
<body>
    <div id="total-price" style="background: linear-gradient(to right, #43cea2, #185a9d); color: white; width: 100%; max-width: 1800px; font-size: 32px; text-align: center; padding: 15px; padding-left: 10px; margin-top: 20px; border-radius: 5px; display: flex; justify-content: center; margin-left: auto; margin-right: auto;"></div>
<div class="container" style="margin-top: 10px;">
  <div class="row">
    <div class="col-md-12">
      <form action="{{route("page.bill.checkout")}}" method="POST" enctype="multipart/form-data">
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
            <input type="datetime-local" id="fromDate" name="fromDate">
            <label for="untilDate">-dan</label>
            <input type="datetime-local" id="untilDate" name="untilDate">
            <label for="untilDate">-dək</label>
        </div>
        <div class="form-group">
            <label for="card">Ödəniş növü:</label>
            <select name="card" id="card-select">
                <option value="">-</option>
                <option value="Nəğd">Nəğd</option>
                <option value="Kart">Kart</option>
                <option value="Borc">Borc</option>
                <?php
                // foreach ($bills as $bill) {
                //     echo '<option value="' . $bill->bill_name . '">' . $bill->bill_name . '</option>';
                // }
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

        <!-- Begin Page Content -->
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
                <td>{{ $patient->date}}</td>
                <?php
                    if($patient->bill_id == $bill_id)
                        echo "<td>Nəğd</td>";
                    elseif ($patient->bill_id == 34) {
                        echo "<td>Borc</td>";
                    }
                    else
                        echo "<td>Kart</td>";
                ?>
                <?php
                    $packet = DB::table('packets')->where('id', $patient->packet_id)->first();
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

        <!-- /.container-fluid -->
    </div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js" defer="defer"></script>
<script>
    $(document).ready(function () {
    $('#checkout_table').DataTable({
        // Save the state
        "stateSave": true,
        // No "show number of entries" field
        "lengthChange": false,
        // No text under the table
        "info": false,
        // No pagination
        "paging": false,
        initComplete: function () {
            var column3 = this.api().column(3); // Specify the index of the column you want to work with (zero-based index)
            var column4 = this.api().column(4); // Specify the index of the column you want to work with (zero-based index)
            var column5 = this.api().column(5); // Specify the index of the column you want to work with (zero-based index)
            var column6 = this.api().column(6); // Specify the index of the column you want to work with (zero-based index)
            var column7 = this.api().column(7); // Specify the index of the column you want to work with (zero-based index)
            var column8 = this.api().column(8); // Specify the index of the column you want to work with (zero-based index)

            // Room
            var select_room = $("#room-select").on("change", function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column3.search(val).draw();
            });

            column3.data().unique().sort()

            // Doctor
            var select_doctor = $("#doctor-name").on("change", function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column4.search(val).draw();
            });

            column4.data().unique().sort()

            // Bill
            var select_bill = $("#card-select").on("change", function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column7.search(val).draw();
            });

            column7.data().unique().sort();

            // Packet
            var select_packet = $("#packet-select").on("change", function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column8.search(val).draw();
            });

            column8.data().unique().sort()


            // Date
            var fromDate = $("#fromDate, #untilDate").on("change", function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());

                column6.data().each(function (value, index) {
                    // If the value is more than value of the datepicker
                    // Hide all rows that does not satisfy to this condition

                    var datetimeFromLocalValue = document.getElementById("fromDate").value;
                    var datetimeUntilLocalValue = document.getElementById("untilDate").value;
                    var dateFromObj = new Date(datetimeFromLocalValue);
                    var dateUntilObj = new Date(datetimeUntilLocalValue);

                    var formattedUntilDate =
                        dateUntilObj.getFullYear() +
                        "-" +
                        padZero(dateUntilObj.getMonth() + 1) +
                        "-" +
                        padZero(dateUntilObj.getDate()) +
                        " " +
                        padZero(dateUntilObj.getHours()) +
                        ":" +
                        padZero(dateUntilObj.getMinutes()) +
                        ":" +
                        padZero(dateUntilObj.getSeconds());

                    var formattedFromDate =
                        dateFromObj.getFullYear() +
                        "-" +
                        padZero(dateFromObj.getMonth() + 1) +
                        "-" +
                        padZero(dateFromObj.getDate()) +
                        " " +
                        padZero(dateFromObj.getHours()) +
                        ":" +
                        padZero(dateFromObj.getMinutes()) +
                        ":" +
                        padZero(dateFromObj.getSeconds());

                    function padZero(num) {
                        return num < 10 ? "0" + num : num;
                    }
                    $(column6.nodes()[index]).parent().show();

                    // If the value is between from and until times and from and until value are not null show all the rows that satisfy this condition
                    if (datetimeFromLocalValue != "" && datetimeUntilLocalValue != "") {
                        if (value < formattedFromDate || value > formattedUntilDate) {
                            $(column6.nodes()[index]).parent().hide();
                            // write the total bill
                            $("#total-price").html("Cəmi: " + calculateTotalBill() + " AZN");
                        }
                    }
                    // If the value of datepicker until is null but from is not then show all rows that more than from (do not consider the until datepicker)
                    else if (datetimeUntilLocalValue == "" && datetimeFromLocalValue != "") {
                        if (value <= formattedFromDate) {
                            $(column6.nodes()[index]).parent().hide();
                            $("#total-price").html("Cəmi: " + calculateTotalBill() + " AZN");
                        }
                    }
                    // // If the value of datepicker from is null but until is not then show all rows that less than until (do not consider the from datepicker)
                    else if (datetimeFromLocalValue == "" && datetimeUntilLocalValue != "") {
                        if (value >= formattedUntilDate) {
                            $(column6.nodes()[index]).parent().hide();
                            $("#total-price").html("Cəmi: " + calculateTotalBill() + " AZN");

                        }
                    }
                    // // If the value of datepicker from and until are null then show all rows
                    else if (datetimeFromLocalValue == "" && datetimeUntilLocalValue == "") {
                        $(column6.nodes()[index]).parent().show();
                        $("#total-price").html("Cəmi: " + calculateTotalBill() + " AZN");
                    }
                });
            });

            var total_bill = 0;

            // Function to calculate the total bill
            function calculateTotalBill() {
                total_bill = 0;

                // Iterate over the visible rows
                $('#checkout_table tbody tr:visible').each(function () {
                    var row = $(this);
                    var price = parseInt(row.find('td:nth-child(6)').text());
                    total_bill += price;
                });

                // If the value is 0 or Nan write 0
                if (isNaN(total_bill) || total_bill === 0) {
                    total_bill = 0;
                }
                $("#total-price").html("Cəmi: " + total_bill + " AZN");

                return total_bill;
            }

            // Call the calculateTotalBill function initially
            calculateTotalBill();

            // Event listener for table redraw
            $('#checkout_table').on('draw.dt', function () {
                calculateTotalBill();
            });

            var overall_bill = {!! json_encode($total_bill) !!};
            var checkout_show = document.getElementById("total-price");
            // onclick change the value from total_bill to overall_bill and vice versa
            checkout_show.addEventListener("click", function() {
                if(checkout_show.innerHTML == "Ümumi məbləğ: " + overall_bill + " AZN"){
                    checkout_show.innerHTML = "Cəmi: " + calculateTotalBill() + " AZN";
                }
                else{
                    checkout_show.innerHTML = "Ümumi məbləğ: " + overall_bill + " AZN";
                }
            });
        },
    });
});


// Create a variable for all selectors with their ids
var room_select = document.getElementById("room-select");
var doctor_select = document.getElementById("doctor-name");
var card_select = document.getElementById("card-select");
var packet_select = document.getElementById("packet-select");

room_select.addEventListener("change", function() {
  var selectedValue = room_select.value;
  localStorage.setItem("selectedValueRoom", selectedValue);
});

var storedValueRoom = localStorage.getItem("selectedValueRoom");

if(storedValueRoom){
    room_select.value = storedValueRoom;
}


doctor_select.addEventListener("change", function() {
  var selectedValue = doctor_select.value;
  localStorage.setItem("selectedValueDoctor", selectedValue);
});

var storedValueDoctor = localStorage.getItem("selectedValueDoctor");

if(storedValueDoctor){
    doctor_select.value = storedValueDoctor;
}


card_select.addEventListener("change", function() {
  var selectedValue = card_select.value;
  localStorage.setItem("selectedValueCard", selectedValue);
});

var storedValueCard = localStorage.getItem("selectedValueCard");

if(storedValueCard){
    card_select.value = storedValueCard;
}


packet_select.addEventListener("change", function() {
  var selectedValue = packet_select.value;
  localStorage.setItem("selectedValuePacket", selectedValue);
});

var storedValuePacket = localStorage.getItem("selectedValuePacket");

if(storedValuePacket){
    packet_select.value = storedValuePacket;
}

</script>
</html>
@endsection
