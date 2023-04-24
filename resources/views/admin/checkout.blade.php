@extends(backpack_view('blank'))

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css -->
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

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

/* Main content styles */
.main-content {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
  display: flex;
  flex-wrap: wrap;
}


.sidebar h2 {
  margin-top: 0;
}

/* Calendar styles */
.calendar {
  margin-bottom: 20px;
}

.calendar label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

.calendar select {
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  margin-bottom: 10px;
}

/* Room boxes styles */
.room-boxes {
  display: flex;
  flex-wrap: wrap;
}

.room-box {
  width: calc(50% - 10px);
  margin-right: 10px;
  margin-bottom: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  cursor: pointer;
}

.room-box:nth-child(even) {
  margin-right: 0;
}

.room-box:hover {
  background-color: #f5f5f5;
}

/* Room box labels styles */
.room-box-label {
  font-weight: bold;
  margin-bottom: 5px;
}

/* Customer info modal styles */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: none;
}

.modal-content {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 400px;
  background-color: #fff;
  border-radius: 5px;
  padding: 20px;
}

.modal-header {
  margin-top: 0;
}

.modal-close {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
}

/* Form styles */
.form-input {
  display: block;
  margin-bottom: 10px;
}

.form-input label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

.form-input input[type="text"],
.form-input input[type="tel"] {
  padding: 5px;
  border-radius: 5px;
  border: 1px solid #ccc;
  width: 100%;
}

.form-submit {
  text-align: right;
  margin-top: 20px;
}

.form-submit input[type="submit"] {
  background-color: #333;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
    cursor: pointer;
}

.form-submit input[type="submit"]:hover {
  background-color: #555;
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
.column {
    border: 1px solid black;
    padding: 10px;
    display: inline-block;
    margin: 10px;
    cursor: pointer;
}
.hidden {
    display: none;
}
.container {
  height: 790px; /* set the height of the container as needed */
  overflow-y: scroll; /* add a vertical scroll to the container */
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
}
</style>
<body>
    <div id="total-price" style="background: linear-gradient(to right, #43cea2, #185a9d); color: white; width: 100%; max-width: 1800px; font-size: 32px; text-align: center; padding: 15px; padding-left: 10px; margin-top: 20px; border-radius: 5px; display: flex; justify-content: center; margin-left: auto; margin-right: auto;">Cəmi: {{$total_bill}} AZN</div>
<?php
    // dd($bills);
    ?>
<div class="container" style="margin-top: 10px;">
  <div class="row">
    <div class="col-md-12">
      <form action="{{route("page.bill.checkout")}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="room-selector">
          <label for="room-select">Otaq:</label>
          <select id="room-select" name="room_selector">
              <option value="-">-</option>
              <?php
                foreach ($rooms as $room) {
                    echo '<option value="' . $room->id . '">' . $room->number . '</option>';
                }
                ?>
            </select>
        </div>
        {{-- Doctor name --}}
        <div class="doctor-selector">
            <label for="doctor-name">Həkim adı:</label>
            <select id="doctor-name" name="doctor_name">
              <option value="-">-</option>
              <?php
                foreach ($doctors as $doctor) {
                    echo '<option value="' . $doctor->id . '">' . $doctor->name . '</option>';
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
                <option value="-">-</option>
                <option value="1">Nəğd</option>
                <?php
                foreach ($bills as $bill) {
                    if($bill->type!='Nəğd')
                        echo '<option value="' . $bill->id . '">' . $bill->name . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="packet">Paket:</label>
            <select name="packet" id="card-select">
                <option value="-">-</option>
                <?php
                foreach ($packets as $packet) {
                    echo '<option value="' .$packet->id. '">' . $packet->name . '</option>';
                }
                ?>
            </select>
        </div>
        {{-- Create a button for submiton --}}
        <div class="form-group">
          <input type="submit" value="Search" class="btn btn-primary">
        </div>

      </form>
  </div>
</div>

<div class="my-cards">
    <div id="accordion" style="max-width: 1600px; margin-left: auto; margin-right: auto; margin-top: 60px;">
    {{-- Foreach patient create a card --}}
    <?php $i = 1; ?>
    @foreach ($patients as $patient)
        <div class="card room{{$i}}">
            <div class="card-header" id="heading{{$i}}">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false" aria-controls="collapse{{$i}}">
                        Ad:{{ $patient->name }}| Telefon: {{ $patient->phone }}| Qiymət:{{ $patient->price }}|
                        <?php
                            if($patient->date == null){
                                echo "Tarix: -";
                            }
                            else{
                                echo "Tarix: " . $patient->date;
                            }
                        ?>
                    </button>
                </h5>
            </div>
            <div id="collapse{{$i}}" class="collapse" aria-labelledby="heading{{$i}}" data-parent="#accordion">
                <div class="card-body">
                {{-- Create a list --}}
                <ul>
                    <li>Ad: {{ $patient->name }}</li>
                    <li>Soyad: {{ $patient->surname }}</li>
                    <?php
                        $room = DB::table('rooms')->where('id', $patient->room_id)->first();
                        $doctor = DB::table('doctors')->where('id', $patient->doctor_id)->first();
                        $packet = DB::table('packets')->where('id', $patient->packet_id)->first();
                    ?>
                    <li>Otaq: {{ $room->number }}</li>
                    <li>Mütəxəssis: {{ $doctor->name }}</li>
                    @if($patient->date == null)
                        <li>Tarix: -</li>
                    @else
                        <li>Tarix: {{ $patient->date }}</li>
                    @endif
                    <li>Qiymət: {{ $patient->price }}AZN</li>
                    @if($patient->bill_id == $bill_id)
                        <li>Ödəniş növü: Nəğd </li>
                    @else
                        <li>Ödəniş növü: Kart</li>
                    @endif
                    <li>Telefon: {{ $patient->phone }}</li>
                    @if($patient->packet_id == $packet_id)
                        <li>Paket: Yoxdur</li>
                    @else
                        <li>Paket: {{ $packet->name }}</li>
                    @endif
                </ul>
                </div>
            </div>
        </div>
        <?php $i++; ?>
        @endforeach
    </div>
</div>





</body>
<script>
    // Get all the cards
    const cards = document.querySelectorAll('.card');

    // Loop through each card
    cards.forEach(function(card) {
      // If the selected room is "all" or matches the room class of the card, show the card
      if (selectedRoom === 'all' || card.classList.contains(selectedRoom)) {
        card.style.display = 'block';
      } else {
        card.style.display = 'none'; // Otherwise, hide the card
      }
    });
    $('.collapse').collapse()
    $('#myCollapsible').collapse({
      toggle: false
    })

    $('#myCollapsible').on('hidden.bs.collapse', function () {
    })

    const sumOfMoney = document.getElementById("sum-of-money");
    const roomBoxes = document.querySelectorAll(".room-box");
    function showInfo(column) {
          var info = column.querySelector('ul');
          info.classList.toggle('hidden');
        }
    // set initial sum of money
    let currentSum = 0;
    sumOfMoney.textContent = currentSum.toFixed(2);

    // add click event listeners to room boxes
    roomBoxes.forEach(roomBox => {
      roomBox.addEventListener("click", () => {
        // update sum of money
        const roomPrice = parseFloat(roomBox.dataset.price);
        currentSum += roomPrice;
        sumOfMoney.textContent = currentSum.toFixed(2);

        // display customer information
        const customerName = roomBox.dataset.name;
        const customerSurname = roomBox.dataset.surname;
        const customerPhone = roomBox.dataset.phone;
        const customerInfo = `Name: ${customerName}\nSurname: ${customerSurname}\nPhone: ${customerPhone}`;
        alert(customerInfo);
      });
    });

  // Get references to the card container and pagination element
  const cardContainer = document.getElementById('card-container');
  const pagination = document.getElementById('pagination');

  // Set the number of cards to display per page
  const cardsPerPage = 3;

  // Get the total number of pages based on the number of cards and cards per page
  const totalPages = Math.ceil(cardContainer.children.length / cardsPerPage);

  // Loop through the cards and set the display style for each one based on the current page
  function showPage(pageNumber) {
    // Calculate the index of the first and last card to display
    const startIndex = (pageNumber - 1) * cardsPerPage;
    const endIndex = startIndex + cardsPerPage - 1;

    // Loop through the cards and set the display style for each one
    for (let i = 0; i < cardContainer.children.length; i++) {
      if (i >= startIndex && i <= endIndex) {
        card = cardContainer.children[i];
        card.style.display = 'block';
      } else {
        card = cardContainer.children[i];
        card.style.display = 'none';
      }
    }
  }

  // Create the pagination links
  function createPagination() {
    // Loop through the number of pages and create a link for each one
    for (let i = 1; i <= totalPages; i++) {
      const link = document.createElement('a');
      link.href = '#';
      link.textContent = i;
      link.classList.add('pagination-link');
      pagination.appendChild(link);
    }
  }

  // Add click event listeners to the pagination links
  function addPaginationEventListeners() {
    const links = document.querySelectorAll('.pagination-link');
    links.forEach(link => {
      link.addEventListener('click', (event) => {
        // Get the page number from the link
        const pageNumber = parseInt(event.target.textContent);
        // Show the page
        showPage(pageNumber);
      });
    });
  }

  // Show the first page
  showPage(1);


  </script>
</body>
</html>
@endsection
