<?php
require_once 'Db_connect.php';

$companyID = isset($_GET['company_id']) ? $_GET['company_id'] : null;

$query = "SELECT 
            v.PlateNo, 
            v.ComCode, 
            v.MCode, 
            v.CompanyID, 
            v.GearType, 
            v.CarType, 
            v.DailyPrice, 
            v.Color, 
            v.Year,
            c.ComName,
            m.MName,
            cn.Name
          FROM 
            vehicle v
          JOIN 
            carcompany c 
          ON 
            v.ComCode = c.ComCode
          JOIN 
            carmodel m 
          ON 
            v.MCode = m.MCode
          JOIN
            company cn
          ON
            v.CompanyID = cn.CompanyID    
          WHERE 
            v.Available = 1";

if ($companyID) {
    $query .= " AND v.CompanyID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $companyID);
} else {
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();

while ($car = $result->fetch_assoc()):
?>
<tr>
    <td><?php echo $car['PlateNo']; ?></td>
    <td><?php echo $car['Name']; ?></td>
    <td><?php echo $car['ComName']; ?></td>
    <td><?php echo $car['MName']; ?></td>
    <td><?php echo $car['GearType']; ?></td>
    <td><?php echo $car['CarType']; ?></td>
    <td><?php echo $car['DailyPrice']; ?></td>
    <td><?php echo $car['Color']; ?></td>
    <td><?php echo $car['Year']; ?></td>
</tr>
<?php endwhile; ?>
