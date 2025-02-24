<?php
if (isset($_POST['CompanyID'], $_POST['Phone'], $_POST['Email'], $_POST['Addres'])) {
    $companyID = $_POST['CompanyID'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $address = $_POST['Addres'];

    require_once 'Db_connect.php';

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "UPDATE company SET Phone = ?, Email = ?, Addres = ? WHERE CompanyID = ?";
    $stmt = $conn->prepare($sql);

    
    $stmt->bind_param("ssss", $phone, $email, $address, $companyID);

    if ($stmt->execute()) {
        echo "Success"; 
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
