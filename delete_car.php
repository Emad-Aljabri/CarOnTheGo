<?php
require_once 'Db_connect.php'; 

if (isset($_POST['PlateNo'])) {
    $plateNo = $_POST['PlateNo'];

    $sql = "DELETE FROM vehicle WHERE PlateNo = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("s", $plateNo);

    if ($stmt->execute()) {
        echo "Car deleted successfully!";
    } else {
        echo "Error deleting car: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Missing PlateNo.";
}
?>
