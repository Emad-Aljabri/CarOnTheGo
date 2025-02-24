<?php
if (isset($_POST['CID'], $_POST['FName'], $_POST['LName'], $_POST['Phone'], $_POST['Email'], $_POST['City'], $_POST['Street'], $_POST['BirthDate'])) {
    $cid = $_POST['CID'];
    $fname = $_POST['FName'];
    $lname = $_POST['LName'];
    $phone = $_POST['Phone'];
    $email = $_POST['Email'];
    $city = $_POST['City'];
    $street = $_POST['Street'];
    $birthDate = $_POST['BirthDate'];

    require_once 'Db_connect.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE customer SET FName = ?, LName = ?, Phone = ?, Email = ?, City = ?, Street = ?, BirthDate = ? WHERE CID = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ssssssss", $fname, $lname, $phone, $email, $city, $street, $birthDate, $cid);

    if ($stmt->execute()) {
        echo "Profile updated successfully."; 
    } else {
        echo "Error: " . $stmt->error; 
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Incomplete data provided.";
}
?>
