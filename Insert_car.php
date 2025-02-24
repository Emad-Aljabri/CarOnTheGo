<?php
require_once 'Db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



if (isset($_POST['MName'], $_POST['CarType'], $_POST['PlateNo'], $_POST['ComCode'], $_POST['MCode'], $_POST['GearType'], $_POST['DailyPrice'], $_POST['Color'], $_POST['Year'], $_POST['CompanyID'])) {

    $carName = $_POST['MName'];
    $carType = $_POST['CarType'];
    $plateNumber = $_POST['PlateNo'];
    $comCode = $_POST['ComCode'];
    $modelCode = $_POST['MCode'];
    $gearType = $_POST['GearType'];
    $dailyPrice = $_POST['DailyPrice'];
    $carColor = $_POST['Color'];
    $yearOfManufacture = $_POST['Year'];
    $companyID = $_POST['CompanyID'];

    $conn->begin_transaction();

    try {
        $sql1 = "INSERT INTO carmodel (MName, ComCode, MCode) VALUES (?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        if ($stmt1 === false) {
            die("Error in the preparation of the first order: " . $conn->error);
        }
        $stmt1->bind_param("sss", $carName, $comCode, $modelCode);

        if (!$stmt1->execute()) {
            die("Error in the execution of the first request: " . $stmt1->error);
        }

        $sql2 = "INSERT INTO vehicle (CarType, PlateNo, ComCode, MCode, GearType, DailyPrice, Color, Year, CompanyID, Available) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
        ";
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2 === false) {
            die("Error in the preparation of the second application: " . $conn->error);
        }
        $stmt2->bind_param("sssssdsss", $carType, $plateNumber, $comCode, $modelCode, $gearType, $dailyPrice, $carColor, $yearOfManufacture, $companyID);

        if (!$stmt2->execute()) {
            die("Error in execution of second request: " . $stmt2->error);
        }

        $conn->commit();
        header("Location: Company.php");
    } catch (Exception $e) {
        $conn->rollback();
        echo "The additionality process failed: " . $e->getMessage();
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();

} else {
    die("Error: Not all required values are sent.");
}
?>
