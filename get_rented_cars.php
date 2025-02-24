<?php
require_once 'Db_connect.php';

if (isset($_POST['delete'])) {
    $type = $_POST['type'];
    $id = $_POST['id'];

    if ($type === 'rental') {
        $stmt = $conn->prepare("DELETE FROM rent WHERE RentNo = ?");
        $stmt->bind_param("i", $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
    }
    $stmt->close();
    header("Location: admin.php"); 
    exit; 
}

$companyID = isset($_GET['company_id']) ? $_GET['company_id'] : null;

$query = "SELECT 
            rent.RentNo, 
            rent.EID, 
            rent.CID, 
            rent.CompanyID, 
            cn.Name AS CompanyName, 
            vehicle.PlateNo, 
            vehicle.GearType, 
            vehicle.Color, 
            vehicle.Year, 
            vehicle.CarType, 
            rent.RentDateFrom, 
            rent.RentDateTo, 
            rent.RentPeriod, 
            rent.Amount, 
            rent.PayMethod, 
            rent.PayDate, 
            rent.RentDate 
        FROM rent 
        JOIN vehicle ON rent.PlateNo = vehicle.PlateNo 
        JOIN company cn ON rent.CompanyID = cn.CompanyID";

if ($companyID) {
    $query .= " WHERE rent.CompanyID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $companyID);
} else {
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

while ($rent = $result->fetch_assoc()) {
    echo "<tr>
        <td>{$rent['RentNo']}</td>
        <td>{$rent['CID']}</td>
        <td>{$rent['PlateNo']}</td>
        <td>{$rent['CompanyName']}</td>
        <td>{$rent['CarType']}</td>
        <td>{$rent['GearType']}</td>
        <td>{$rent['Color']}</td>
        <td>{$rent['Year']}</td>
        <td>{$rent['RentDateFrom']}</td>
        <td>{$rent['RentDateTo']}</td>
        <td>{$rent['RentPeriod']}</td>
        <td>{$rent['Amount']}</td>
        <td>{$rent['PayMethod']}</td>
        <td>{$rent['PayDate']}</td>
        <td>{$rent['RentDate']}</td>
        <td>
            <form method='POST' action=''>
                <input type='hidden' name='type' value='rental'>
                <input type='hidden' name='id' value='{$rent['RentNo']}'>
                <input class='buttons' type='submit' name='delete' value='Delete'>
            </form>
        </td>
    </tr>";
}

$stmt->close();
$conn->close();
?>
