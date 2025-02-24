<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

require_once 'Db_connect.php';

$username = $_SESSION['username'];

$stmtUserType = $conn->prepare("SELECT UsType FROM users WHERE UsName = ?");
$stmtUserType->bind_param("s", $username);
$stmtUserType->execute();
$resultUserType = $stmtUserType->get_result();

if ($resultUserType->num_rows > 0) {
    $userData = $resultUserType->fetch_assoc();
    if ($userData['UsType'] != 3) {
        header("Location: login.php");
        exit;
    }
} else {
    
    header("Location: Login.php");
    exit;
}

$stmtProfile = $conn->prepare("
    SELECT FName, LName, UsName, CID, LicenesID, BirthDate, Phone, email, City, Street 
    FROM customer 
    WHERE UsName = ?
");
$stmtProfile->bind_param("s", $username);
$stmtProfile->execute();
$profileResult = $stmtProfile->get_result();
$profileData = $profileResult->fetch_assoc();

$stmtRentedCars = $conn->prepare("SELECT 
    rent.RentNo, 
    rent.EID, 
    rent.CID, 
    rent.CompanyID,
    cn.Name, 
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
JOIN company cn ON rent.CompanyID = cn.CompanyID
WHERE rent.CID = ?");
$stmtRentedCars->bind_param("i", $profileData['CID']);
$stmtRentedCars->execute();
$rentedCarsResult = $stmtRentedCars->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Profile</title>
    <style>
        .buttons {
            width: 96%;
            padding: 10px;
            background-color: #000000;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            margin-top: 20px;
        }
        .option {
            width: 48%;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: none;
            margin-top: 20px;
            border-radius: 12px; 
            height: 40px; 
            padding-left: 16px; 
            padding-right: 16px;
            background-color: #615f5f7a;
            color: black;
            font-size: 16px; 
            font-weight: bold;
            line-height: normal; 
            letter-spacing: 0.015em; 
            }
          .option.active{
          background-color: black;
          color: white;
          }
          .option button:hover {
          background-color: #5757572d;
         }
         .hidden {
            display: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #615f5f7a;
        }
    </style>
</head>
<body>
    <div>
    <h1 class="h1">Welcome <?php echo $profileData['FName'] . ' ' . $profileData['LName']; ?></h1>
    <div>
            <div> 
              <button class="option" onclick="showForm('rented-cars', this)">rented cars</button>
              <button class="option" onclick="showForm('Profile', this)">Profile</button>
          </div>
        </div>
        <br>
        <div id="rented-cars-form" class="hidden">
        <table border="1">
                <tr>
                    <th>Plate No</th>
                    <th>Company Name</th>
                    <th>Gear Type</th>
                    <th>Color</th>
                    <th>Year</th>
                    <th>Rent Date From</th>
                    <th>Rent Date To</th>
                    <th>Rent Period</th>
                    <th>Rent Date</th>
                    <th>Amount</th>
                    <th>Pay Method</th>
                    <th>Pay Date</th>
                </tr>
                <?php while ($car = $rentedCarsResult->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $car['PlateNo']; ?></td>
                    <td><?php echo $car['Name']; ?></td>
                    <td><?php echo $car['GearType']; ?></td>
                    <td><?php echo $car['Color']; ?></td>
                    <td><?php echo $car['Year']; ?></td>
                    <td><?php echo $car['RentDateFrom']; ?></td>
                    <td><?php echo $car['RentDateTo']; ?></td>
                    <td><?php echo $car['RentPeriod']; ?></td>
                    <td><?php echo $car['RentDate']; ?></td>
                    <td><?php echo $car['Amount']; ?></td>
                    <td><?php echo $car['PayMethod']; ?></td>
                    <td><?php echo $car['PayDate']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <div id="Profile-form" class="hidden">
            <table border="1">
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>User Name</th>
                    <th>Customer ID</th>
                    <th>License ID</th>
                    <th>Birth Date</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td contenteditable="true"><?php echo $profileData['FName']; ?></td>
                    <td contenteditable="true"><?php echo $profileData['LName']; ?></td>
                    <td><?php echo $profileData['UsName']; ?></td>
                    <td><?php echo $profileData['CID']; ?></td>
                    <td><?php echo $profileData['LicenesID']; ?></td>
                    <td contenteditable="true"><?php echo $profileData['BirthDate']; ?></td>
                    <td contenteditable="true"><?php echo $profileData['Phone']; ?></td>
                    <td contenteditable="true"><?php echo $profileData['email']; ?></td>
                    <td contenteditable="true"><?php echo $profileData['City']; ?></td>
                    <td contenteditable="true"><?php echo $profileData['Street']; ?></td>
                    <td>
                        <button class="buttons" onclick="updateProfile(<?php echo $profileData['CID']; ?>)">Update</button>
                        <button class="buttons" onclick="deleteProfile(<?php echo $profileData['CID']; ?>)">Delete</button>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <button class="buttons" type="submit" onclick="window.location.href='Home.php'">Cancel</button>
    <form action="logout.php" method="post">
        <button class="buttons" type="submit">logout</button>
    </form>
</body>
<script>
    function showForm(userType, clickedButton) {
        // إخفاء جميع النماذج
        document.getElementById('rented-cars-form').classList.add('hidden');
        document.getElementById('Profile-form').classList.add('hidden');

        if (userType === 'rented-cars') {
            document.getElementById('rented-cars-form').classList.remove('hidden');
        }  
        else if (userType === 'Profile') {
            document.getElementById('Profile-form').classList.remove('hidden');
        } 

        
        document.querySelectorAll('.option').forEach(button => button.classList.remove('active'));
        clickedButton.classList.add('active');
    }

    function updateProfile(cid) {
    let row = event.target.closest('tr');
    let fname = row.cells[0].textContent;
    let lname = row.cells[1].textContent;
    let phone = row.cells[6].textContent;
    let email = row.cells[7].textContent;
    let city = row.cells[8].textContent;
    let street = row.cells[9].textContent;
    let birthDate = row.cells[5].textContent;

    let data = new FormData();
    data.append('CID', cid);
    data.append('FName', fname);
    data.append('LName', lname);
    data.append('Phone', phone);
    data.append('Email', email);
    data.append('City', city);
    data.append('Street', street);
    data.append('BirthDate', birthDate);

    fetch('update_profile_Customer.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.text())
    .then(result => alert(result))
    .catch(error => console.error('Error:', error));
}

function deleteProfile(cid) {
    if (confirm("Are you sure you want to delete this profile?")) {
        let data = new FormData();
        data.append('CID', cid);

        fetch('delete_profile_Customer.php', {
            method: 'POST',
            body: data
        })
        .then(response => response.text())
        .then(result => {
            alert(result);
            if (result === "Profile deleted successfully.") {
                let row = event.target.closest('tr');
                row.remove(); 
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

</script>
</html>