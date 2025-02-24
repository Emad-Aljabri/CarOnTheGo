<?php
if (isset($_POST['CompanyID'])) {
    $companyID = $_POST['CompanyID'];

    require_once 'Db_connect.php'; 

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM company WHERE CompanyID = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $companyID); 

    if ($stmt->execute()) {
        echo "Account deleted successfully."; 
        header("Location: Home.php");
    } else {
        echo "Error: " . $stmt->error; 
    }

    $stmt->close();
    $conn->close();
} else {
    echo "CompanyID not provided."; 
}
?>
