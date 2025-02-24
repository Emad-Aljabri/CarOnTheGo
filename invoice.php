<?php
session_start();
require_once 'Db_connect.php'; 

if (!isset($_SESSION['lastRent'])) {
    die("No rental data found.");
}

$rentalData = $_SESSION['lastRent'];
$companyName = "N/A";

if (isset($rentalData['CompanyID'])) {
    $companyID = $rentalData['CompanyID'];
    $query = "SELECT Name FROM company WHERE CompanyID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $companyID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $company = $result->fetch_assoc();
        $companyName = $company['Name'];
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .invoice-container {
            width: 90%;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .company-info, .car-details, .total-section {
            margin-bottom: 20px;
        }
        .company-info h1 {
            color: #333;
        }
        
        .car-details p, .total-section p {
            margin: 8px 0;
            color: #555;
        }
        .total-price, .total-duration {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }
        .option {
        width: 48%;
        cursor: pointer;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border: none;
        margin-top: 20px;
        border-radius: 12px; 
        height: 40px; 
        padding-left: 16px; 
        padding-right: 16px;
        background-color: #615f5f7a;
        color: black;
        font-size: 16px; 
        font-weight: bold;
        line-height: normal; 
        letter-spacing: 0.015em; 
        transition: background-color 0.3s, color 0.3s; 
    }

    .option.active {
        background-color: black;
        color: white;
    }

    .option:hover {
        background-color: black; 
        color: white; 
    }

    .buttons {
            width: 96%;
            padding: 10px;
            background-color: #000000;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="company-info">
            <h1>CarOnTheGo</h1>
            <p>Your trusted car rental service</p>
        </div>
        <div class="invoice-container">
            <h1>Invoice</h1>
            <p>Car Name: <?php echo htmlspecialchars($rentalData['carName']); ?></p>
            <p>Car Plate Number: <?php echo htmlspecialchars($rentalData['PlateNo']); ?></p>
            <p>Rental Company: <?php echo htmlspecialchars($companyName); ?></p>
            <p>Rental Start Date: <?php echo htmlspecialchars($rentalData['RentDateFrom']); ?></p>
            <p>Rental End Date: <?php echo htmlspecialchars($rentalData['RentDateTo']); ?></p>
            <p>Rental Duration: <?php echo htmlspecialchars($rentalData['RentPeriod']); ?> days</p>
            <p>Payment Method: <?php echo htmlspecialchars($rentalData['PayMethod']); ?></p>
            <p class='total-price'>Total Amount: <?php echo htmlspecialchars($rentalData['Amount']); ?> S.R</p>
        </div>  
        <div class="buttonss">
            <div> 
              <button class="option" onclick="window.location.href='Home.php'">Home</button>
              <button class="option" onclick="window.location.href='ClientProfile.php'">Profile</button>
          </div>
        </div>      
    </div>
</body>
</html>
