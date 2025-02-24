<?php
session_start();
require_once 'Db_connect.php'; 

if (!isset($_SESSION['username'])) {
    die("You must be logged in to perform this action.");
}

$username = $_SESSION['username']; 

$query = "SELECT CID FROM customer WHERE UsName = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $customer = $result->fetch_assoc();
    $CID = $customer['CID']; 
} else {
    die("User not found in customer table.");
}

$requiredFields = ['PlateNo', 'CompanyID', 'RentDateFrom', 'RentDateTo', 'Amount', 'PayMethod'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || empty($_POST[$field])) {
        die("Error: Missing or empty field: $field");
    }
}

$EID = 1;
$PlateNo = $_POST['PlateNo'];
$CompanyID = $_POST['CompanyID'];
$carName = $_POST['carName'];

$RentDateFrom = $_POST['RentDateFrom'];
$RentDateTo = $_POST['RentDateTo'];

if (empty($RentDateFrom) || empty($RentDateTo)) {
    die("Error: Missing RentDateFrom or RentDateTo.");
}

$RentDateFrom = date('Y-m-d', strtotime($RentDateFrom));
$RentDateTo = date('Y-m-d', strtotime($RentDateTo));

$RentPeriod = (strtotime($RentDateTo) - strtotime($RentDateFrom)) / (60 * 60 * 24) + 1;
$RentDate = date('Y-m-d'); 
$Totel = $_POST['Amount'];
$Amount = $Totel * $RentPeriod;
$PayMethod = $_POST['PayMethod'];
$PayDate = date('Y-m-d');

$insertQuery = "
    INSERT INTO rent (EID, CID, PlateNo, CompanyID, RentDateFrom, RentDateTo, RentPeriod, RentDate, Amount, PayMethod, PayDate)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
";

$insertStmt = $conn->prepare($insertQuery);
$insertStmt->bind_param(
    "sssssssssss",
    $EID,
    $CID,
    $PlateNo,
    $CompanyID,
    $RentDateFrom,
    $RentDateTo,
    $RentPeriod,
    $RentDate,
    $Amount,
    $PayMethod,
    $PayDate
);

if ($insertStmt->execute()) {
    $updateQuery = "UPDATE vehicle SET Available = 0 WHERE PlateNo = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("s", $PlateNo);

    if ($updateStmt->execute()) {
        $_SESSION['lastRent'] = [
            'PlateNo' => $PlateNo,
            'CompanyID' => $CompanyID,
            'RentDateFrom' => $RentDateFrom,
            'carName' => $carName,
            'RentDateTo' => $RentDateTo,
            'RentPeriod' => $RentPeriod,
            'Amount' => $Amount,
            'PayMethod' => $PayMethod
        ];
        header("Location: invoice.php");
        exit();
    } else {
        echo "Error updating vehicle availability: " . $conn->error;
    }
} else {
    echo "Error: " . $conn->error;
}

$insertStmt->close();
if (isset($updateStmt)) {
    $updateStmt->close();
}
$conn->close();
?>
