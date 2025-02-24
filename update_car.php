<?php
if (isset($_POST['PlateNo'], $_POST['DailyPrice'], $_POST['Color'], $_POST['Available'])) {
    $plateNo = $_POST['PlateNo'];
    $dailyPrice = $_POST['DailyPrice'];
    $color = $_POST['Color'];
    $available=$_POST['Available'];

    require_once 'Db_connect.php';


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE vehicle SET DailyPrice = ?, Color = ?, Available = ? WHERE PlateNo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("dsss", $dailyPrice, $color,$available, $plateNo);

    if ($stmt->execute()) {
        echo "Success"; 
    } else {
        echo "Error: " . $stmt->error; 
    }

    $stmt->close();
    $conn->close();
}
?>
