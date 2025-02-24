<?php
if (isset($_POST['CID'])) {
    $cid = $_POST['CID'];

    require_once 'Db_connect.php';

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM customer WHERE CID = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $cid);

    if ($stmt->execute()) {
        echo "Profile deleted successfully."; 
        header("Location: Home.php");
    } else {
        echo "Error: " . $stmt->error; 
    }

    $stmt->close();
    $conn->close();
} else {
    echo "CID not provided.";
}
?>
