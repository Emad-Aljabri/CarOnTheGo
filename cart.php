<?php
session_start();

require_once 'Db_connect.php';

if (!isset($_SESSION['username'])) {
  header("Location: login-Client.php");
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['carName'], $_POST['plateNo'], $_POST['gearType'], $_POST['year'], $_POST['dailyPrice'], $_POST['carImage'], $_POST['companyID'])) {
  $cartItem = [
      'carName' => $_POST['carName'],
      'plateNumber' => $_POST['plateNo'],
      'gearType' => $_POST['gearType'],
      'year' => $_POST['year'],
      'dailyPrice' => $_POST['dailyPrice'],
      'carImage' => $_POST['carImage'],
      'companyID' => $_POST['companyID'],
  ];

  if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = [];
  }

  $_SESSION['cart'][] = $cartItem;

  header('Location: cart.php');
  exit;
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
?>



<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental basket</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Work+Sans%3Awght%40400%3B500%3B700%3B900" />
    <style>
        body {
            font-family: 'Work Sans', 'Noto Sans', sans-serif;
            background-color: #F9F9F9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .cart-container {
            width: 100%;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .car-item {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding: 15px ;
        }
        .car-image {
            width: 200px;
            height: 100px;
            border-radius: 8px;
            background-size: cover;
            background-position: center;
            margin-right: 30px;
        }
        .car-details {
            flex: 1;
        }
        .car-price {
            font-weight: bold;
        }

        .total-price {
            font-size: 1.2em;
            color: #333;
            margin-top: 15px;
            font-weight: bold;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }
        .btn {
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            border: none;
            color: #fff;
            transition: background-color 0.3s;
        }
        .btn-confirm {
            background-color: #419b1dd0;
        }
        .btn-cancel {
            background-color: #d9534f;
        }
        .btn-confirm:hover {
            background-color: #45a049;
        }
        .btn-cancel:hover {
            background-color: #c9302c;
        }
        .company-image {
            width: 50px;
            height: 50px;
            background-repeat: no-repeat;
            background-size: cover;
            border-radius: 8px;
        }
        .payment-details, .city-select {
            display: none;
            margin-top: 10px;
        }
        section{
            display: none;
            margin-top: 10px;
        }
        
.form {
  background: #0c0f14;
  box-shadow: 0px 187px 75px rgba(0, 0, 0, 0.01),
    0px 105px 63px rgba(0, 0, 0, 0.05), 0px 47px 47px rgba(0, 0, 0, 0.09),
    0px 12px 26px rgba(0, 0, 0, 0.1), 0px 0px 0px rgba(0, 0, 0, 0.1);
  width: 93%;
  display: flex;
  flex-direction: column;
  gap: 15px;
  padding: 20px;
  position: relative;
  border-radius: 25px;
}
.form .label {
  display: flex;
  flex-direction: column;
  gap: 5px;
  height: -moz-fit-content;
  height: fit-content;
}
.form .label:has(input:focus) .title {
  top: 0;
  left: 0;
  color: #d17842;
}
.form .label .title {
  padding: 0 10px;
  transition: all 300ms;
  font-size: 12px;
  color: #8b8e98;
  font-weight: 600;
  width: -moz-fit-content;
  width: fit-content;
  top: 14px;
  position: relative;
  left: 15px;
  background: #0c0f14;
}
.form .input-field {
  width: auto;
  height: 50px;
  text-indent: 15px;
  border-radius: 15px;
  outline: none;
  background-color: transparent;
  border: 1px solid #21262e;
  transition: all 0.3s;
  caret-color: #d17842;
  color: #aeaeae;
}

.form .input-field:hover {
  border-color: rgba(209, 121, 66, 0.5);
}

.form .input-field:focus {
  border-color: #d17842;
}
.form .split {
  display: flex;
  flex-direction: row;
  justify-content: space-between;
  width: 100%;
  gap: 15px;
}
.form .split label {
  width: 130px;
}
.form .checkout-btn {
  margin-top: 20px;
  padding: 20px 0;
  border-radius: 25px;
  font-weight: 700;
  transition: all 0.3s cubic-bezier(0.15, 0.83, 0.66, 1);
  cursor: pointer;
  font-size: 20px;
  font-weight: 500;
  display: flex;
  align-items: center;
  border: none;
  justify-content: center;
  fill: #fff;
  color: #fff;
  border: 2px solid transparent;
  background: #42d161;
  transition: all 200ms;
}
.form .checkout-btn:active {
  scale: 0.95;
}

.form .checkout-btn:hover {
  color: #d17842;
  border: 2px solid #d17842;
  background: transparent;
}
.radio-inputs {
  position: relative;
  display: flex;
  flex-wrap: wrap;
  border-radius: 0.5rem;
  background-color: #EEE;
  box-sizing: border-box;
  box-shadow: 0 0 0px 1px rgba(0, 0, 0, 0.06);
  padding: 0.25rem;
  width: 300px;
  font-size: 14px;
}

.radio-inputs .radio {
  flex: 1 1 auto;
  text-align: center;
}

.radio-inputs .radio input {
  display: none;
}

.radio-inputs .radio .name {
  display: flex;
  cursor: pointer;
  align-items: center;
  justify-content: center;
  border-radius: 0.5rem;
  border: none;
  padding: .5rem 0;
  color: rgba(51, 65, 85, 1);
  transition: all .15s ease-in-out;
}

.radio-inputs .radio input:checked + .name {
  background-color: #00000028;
  font-weight: 600;
}

.dateInput {
  margin-left: auto;
  margin-right: auto;
  height: 2.5em;
  width: 12.5em;
  border-radius: 2.5em;
  border: none;
  background-color: rgba(0, 0, 0, 0.144);
  -webkit-filter: drop-shadow(1px 1px 10px #000);
  filter: drop-shadow(7px 7px 10px #00000059);
  font-family: Arial, Helvetica, sans-serif;
  color: rgb(77, 77, 77);
  text-align: center;
  font-size: 14px;
  outline: 2px solid rgba(0, 0, 0, 0);
  transition: outline-offset 0.5s ease, outline-color 0.5s ease,
    height 0.5s ease, width 0.5s ease, filter 0.5s ease;
}

.dateInput:focus {
  outline-offset: 0.5em;
  outline-color: rgba(0, 0, 0, 0.228);
  transition: 0.2s;
  height: 3em;
  width: 13em;
  -webkit-filter: drop-shadow(1px 1px 10px #000);
  filter: drop-shadow(-7px 7px 10px #00000059);
}

.dateInput::placeholder {
  padding-left: 0.8em;
  font-family: Arial, Helvetica, sans-serif;
  font-weight: 500;
  letter-spacing: 1px;
  transform: translateX(-6px);
  transition: transform 0.5s ease;
}

.dateInput:focus::placeholder {
  transform: translateX(-85px);
  transition: 0.5s;
}

    </style>
</head>



<body>
  <form method="POST" action="rent_car.php">
    <div class="cart-container">
      <h2>Rental Basket</h2>
      <div id="cartItems">
        <?php if (empty($cart)): ?>
          <p>Your cart is empty. Please add cars to the basket.</p>
        <?php else: ?>
          <?php foreach ($cart as $item): ?>
            <div class="car-item">
              <img class="car-image" src="<?= htmlspecialchars($item['carImage']) ?>" alt="Car Image">
              <div class="car-details">
                <p>Car Name: <?= htmlspecialchars($item['carName']) ?></p>
                <p>Plate Number: <?= htmlspecialchars($item['plateNumber']) ?></p>
                <p>Gear Type: <?= htmlspecialchars($item['gearType']) ?></p>
                <p>Year: <?= htmlspecialchars($item['year']) ?></p>
                <p>Daily Price: <?= htmlspecialchars($item['dailyPrice']) ?> S.R</p>
              </div>

              <input type="hidden" name="PlateNo" value="<?= htmlspecialchars($item['plateNumber']) ?>" />
              <input type="hidden" name="carName" value="<?= htmlspecialchars($item['carName']) ?>" />
              <input type="hidden" name="CompanyID" value="<?= htmlspecialchars($item['companyID']) ?>" />
              <input type="hidden" name="Amount" value="<?= htmlspecialchars($item['dailyPrice']) ?>" />
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <br>

      <div>
        <label for="start-date">Start Date:</label>
        <input type="date" class="dateInput" id="start-date" name="RentDateFrom" onchange="calculateTotalPrice()" required />
        <label for="end-date">End Date:</label>
        <input type="date" class="dateInput" id="end-date" name="RentDateTo" onchange="calculateTotalPrice()" required />
      </div>
      <p class="total-price" id="rental-duration">Rental duration: 0 days</p>
      <p class="total-price" id="total-price">Total: 0 S.R</p>

      <div class="radio-inputs">
        <label class="radio">Method Of Payment:</label>
        <label class="radio">
          <input type="radio" name="PayMethod" value="cash" onclick="togglePaymentOptions()" required />
          <span class="name">Cash</span>
        </label>
        <label class="radio">
          <input type="radio" name="PayMethod" value="card" onclick="togglePaymentOptions()" />
          <span class="name">Card</span>
        </label>
      </div>

      <div class="actions">
        <button class="btn btn-confirm" type="submit">Rent Confirmation</button>
        <button class="btn btn-cancel" type="button" onclick="cancelRental()">Cancel</button>
        <button class="btn btn-cancel" type="button" onclick="clearCart()">Empty Basket</button>
      </div>
    </div>
  </form>


  <script>
    function calculateTotalPrice() {
      const startDate = document.getElementById('start-date').value;
      const endDate = document.getElementById('end-date').value;
      const rentalDurationElement = document.getElementById('rental-duration');
      const totalPriceElement = document.getElementById('total-price');

      if (startDate && endDate) {
        const start = new Date(startDate);
        const end = new Date(endDate);

        if (end >= start) {
          const days = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
          let total = 0;

          <?php foreach ($cart as $item): ?>
          total += <?= $item['dailyPrice'] ?> * days;
          <?php endforeach; ?>

          rentalDurationElement.textContent = `Rental duration: ${days} days`;
          totalPriceElement.textContent = `Total: ${total} S.R`;
        } else {
          rentalDurationElement.textContent = 'Invalid date range';
          totalPriceElement.textContent = 'Total: 0 S.R';
        }
      } else {
        rentalDurationElement.textContent = 'Rental duration: 0 days';
        totalPriceElement.textContent = 'Total: 0 S.R';
      }
    }

    function cancelRental() {
      if (confirm("Are you sure about rent cancellation?")) {
        <?php unset($_SESSION['cart']); ?>
        window.location.href = 'Home.php';
      }
    }
    
        function clearCart() {
            if (confirm("Are you sure to empty the basket?")) {
                localStorage.removeItem('cart');
                window.location.href = 'cart.php';
                document.getElementById('total-price').textContent = 'Total: 0 S.R';
                document.getElementById('rental-duration').textContent = 'Rental duration: 0 days';
            }
        }
  </script>
</body>
</html>