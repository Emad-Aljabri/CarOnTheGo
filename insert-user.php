<?php
require_once 'Db_connect.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$UserType = $_POST['UserType'];
if($UserType=="customer"){

    if (isset($_POST['FName'], $_POST['LName'], $_POST['CID'], $_POST['LicenesID'], $_POST['Phone'], $_POST['email'], $_POST['UsName'], $_POST['Password'], $_POST['BirthDate'], $_POST['City'], $_POST['Street'])) {

    $FName = $_POST['FName'];
    $LName = $_POST['LName'];
    $CID = $_POST['CID'];
    $LicenesID = $_POST['LicenesID'];
    $Phone = $_POST['Phone'];
    $email = $_POST['email'];
    $UsName = $_POST['UsName'];
    $Password = $_POST['Password'];
    $BirthDate = $_POST['BirthDate'];
    $City = $_POST['City'];
    $Street = $_POST['Street'];
    $DateCreat=date('Y-m-d');
    $UsType="3";
    $Status="A";

    $conn->begin_transaction();

    try {
        $sql1 = "INSERT INTO users (UsName, Password,DateCreat ,UsType ,Status ) VALUES (?, ?, ?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        if ($stmt1 === false) {
            die("Error in the preparation of the first order: " . $conn->error);
        }
        $stmt1->bind_param("sssss", $UsName, $Password, $DateCreat, $UsType, $Status);

        if (!$stmt1->execute()) {
            die("Error in the execution of the first request: " . $stmt1->error);
        }

        $sql2 = "INSERT INTO customer (CID,FName , LName, LicenesID, Phone, email, BirthDate, City, Street,UsName) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
        $stmt2 = $conn->prepare($sql2);
        if ($stmt2 === false) {
            die("Error in the preparation of the second application: " . $conn->error);
        }
        $stmt2->bind_param("ssssssssss", $CID, $FName, $LName, $LicenesID, $Phone, $email, $BirthDate, $City, $Street,$UsName);

        if (!$stmt2->execute()) {
            die("Error in execution of second request: " . $stmt2->error);
        }

        $conn->commit();
        header("Location: Login.php");
    } catch (Exception $e) {
        $conn->rollback();
        echo "The additionality process failed:" . $e->getMessage();
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();

} else {
    die("Error: Not all required values are sent.");
}
}
elseif($UserType=="Company"){
      if (isset($_POST['Name'], $_POST['CompanyID'], $_POST['Phone'], $_POST['Email'], $_POST['UsName'], $_POST['Password'], $_POST['Addres'])) {
    
        $Name = $_POST['Name'];
        $CompanyID = $_POST['CompanyID'];
        $Phone = $_POST['Phone'];
        $email = $_POST['Email'];
        $UsName = $_POST['UsName'];
        $Password = $_POST['Password'];
        $Addres = $_POST['Addres'];
        $DateCreat=date('Y-m-d');
        $UsType="2";
        $Status="A";
    
        $conn->begin_transaction();
    
        try {
            $sql1 = "INSERT INTO users (UsName, Password,DateCreat ,UsType ,Status ) VALUES (?, ?, ?, ?, ?)";
            $stmt1 = $conn->prepare($sql1);
            if ($stmt1 === false) {
                die("Error in the preparation of the first order: " . $conn->error);
            }
            $stmt1->bind_param("sssss", $UsName, $Password, $DateCreat, $UsType, $Status);
    
            if (!$stmt1->execute()) {
                die("Error in the execution of the first request: " . $stmt1->error);
            }
    
            $sql2 = "INSERT INTO company (CompanyID,Name , Phone, Email, Addres ,UsName) 
                     VALUES (?, ?, ?, ?, ?, ?)";
            $stmt2 = $conn->prepare($sql2);
            if ($stmt2 === false) {
                die("Error in the preparation of the second application: " . $conn->error);
            }
            $stmt2->bind_param("ssssss", $CompanyID, $Name, $Phone, $email, $Addres,$UsName);
    
            if (!$stmt2->execute()) {
                die("Error in execution of second request: " . $stmt2->error);
            }
    
            $conn->commit();
            header("Location: Login.php");
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
    }
?>
