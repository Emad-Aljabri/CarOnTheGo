<?php
session_start();
require_once 'Db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit;
}

$username = $_SESSION['username'];

$stmtUserType = $conn->prepare("SELECT UsType FROM users WHERE UsName = ?");
$stmtUserType->bind_param("s", $username);
$stmtUserType->execute();
$resultUserType = $stmtUserType->get_result();

if ($resultUserType->num_rows > 0) {
    $userData = $resultUserType->fetch_assoc();
    if ($userData['UsType'] != 2) {
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: Login.php");
    exit;
}



$query = "SELECT CompanyID, UsName, Name, Phone, Email, Addres FROM company WHERE UsName = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $profileData = $result->fetch_assoc();
    $companyID = $profileData['CompanyID']; 
} else {
    echo "No data found for the logged-in user.";
    exit;
}

$query2 = "
    SELECT 
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
        v.Available
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
    WHERE 
        v.CompanyID = ? AND
        v.Available = 1";
$stmt2 = $conn->prepare($query2);

if ($stmt2 === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt2->bind_param('i', $companyID);
$stmt2->execute();
$carsResult = $stmt2->get_result();

$query4 = "
    SELECT 
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
        v.Available
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
    WHERE 
        v.CompanyID = ? AND
        v.Available = 0";
$stmt4 = $conn->prepare($query4);

if ($stmt4 === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt4->bind_param('i', $companyID);
$stmt4->execute();
$Re_display= $stmt4->get_result();

$query3 = "SELECT 
        rent.RentNo, 
        rent.CID, 
        rent.CompanyID, 
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
    WHERE rent.CompanyID = ?";

$stmt3 = $conn->prepare($query3);

if ($stmt3 === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt3->bind_param('i', $companyID);
$stmt3->execute();
$rentedCarsResult = $stmt3->get_result();

$stmt->close();
$stmt2->close();
$stmt3->close();
$stmt4->close();
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    <style>
        .buttons {
            width: 100%;
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
            width: 19.5%;
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
    <h1 class="h1">Welcome <?php echo $profileData['Name']?></h1>
        <div class="buttonss">
            <div> 
              <button class="option" onclick="showForm('cars-not-rent', this)">cars not rent</button>
              <button class="option" onclick="showForm('rented-cars', this)">rented cars</button>
              <button class="option" onclick="window.location.href='AddCar.php'">Add Car</button>
              <button class="option" onclick="showForm('Re-display-in-store', this)">Re-display in store</button>
              <button class="option" onclick="showForm('my-account', this)">my account</button>
          </div>
        </div>
        <br>
        <div id="cars-not-rent-form" class="hidden">
            <table>
                <tr>
                    <th>PlateNo</th>
                    <th>Company Name</th>
                    <th>Model Name</th>
                    <th>Gear Type</th>
                    <th>Car Type</th>
                    <th>Daily Price</th>
                    <th>Color</th>
                    <th>Year</th>
                    <th>Actions</th>
                </tr>
            <?php while ($car = $carsResult->fetch_assoc()): ?>
                <tr id="car-<?php echo $car['PlateNo']; ?>">
                   <td class="plate-no" contenteditable="false"><?php echo $car['PlateNo']; ?></td>
                   <td class="company-code" contenteditable="false"><?php echo $car['ComName']; ?></td>
                   <td class="model-code" contenteditable="false"><?php echo $car['MName']; ?></td>
                   <td class="gear-type" contenteditable="false"><?php echo $car['GearType']; ?></td>
                   <td class="car-type" contenteditable="false"><?php echo $car['CarType']; ?></td>
                   <td class="daily-price" contenteditable="true"><?php echo $car['DailyPrice']; ?></td>
                   <td class="car-color" contenteditable="true"><?php echo $car['Color']; ?></td>
                   <td class="year" contenteditable="false"><?php echo $car['Year']; ?></td>
                    <td>
                       <button class="buttons" onclick="updateCar('<?php echo $car['PlateNo']; ?>')">Update</button>
                       <button class="buttons" onclick="deleteCar('<?php echo $car['PlateNo']; ?>')">Delete</button>
                   </td>
              
               </tr>
        <?php endwhile; ?>
    </table>
        </div>
        <div id="Re-display-in-store-form" class="hidden">
            <table>
                <tr>
                    <th>PlateNo</th>
                    <th>Company Name</th>
                    <th>Model Name</th>
                    <th>Gear Type</th>
                    <th>Car Type</th>
                    <th>Daily Price</th>
                    <th>Color</th>
                    <th>Year</th>
                    <th>Available</th>
                    <th>Actions</th>
                </tr>
            <?php while ($car = $Re_display->fetch_assoc()): ?>
                <tr id="car-<?php echo $car['PlateNo']; ?>">
                   <td class="plate-no" contenteditable="false"><?php echo $car['PlateNo']; ?></td>
                   <td class="company-code" contenteditable="false"><?php echo $car['ComName']; ?></td>
                   <td class="model-code" contenteditable="false"><?php echo $car['MName']; ?></td>
                   <td class="gear-type" contenteditable="false"><?php echo $car['GearType']; ?></td>
                   <td class="car-type" contenteditable="false"><?php echo $car['CarType']; ?></td>
                   <td class="daily-price" contenteditable="true"><?php echo $car['DailyPrice']; ?></td>
                   <td class="car-color" contenteditable="true"><?php echo $car['Color']; ?></td>
                   <td class="year" contenteditable="false"><?php echo $car['Year']; ?></td>
                   <td class="available" contenteditable="true"><?php echo $car['Available']; ?></td>
                    <td>
                       <button class="buttons" onclick="updateCar('<?php echo $car['PlateNo']; ?>')">Update</button>
                   </td>
               </tr>
        <?php endwhile; ?>
        </table>
        </div>
        <div id="my-account-form" class="hidden">
            <table>
                <tr>
                    <th>Company ID</th>
                    <th>user name</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Addres</th>
                    <th>Actions</th>

                </tr>
                <tr id="profile-<?php echo $profileData['CompanyID']; ?>">
                    <td class="company-id" contenteditable="false"><?php echo $profileData['CompanyID']; ?></td>
                    <td class="user-name" contenteditable="false"><?php echo $profileData['UsName']; ?></td>
                    <td class="name" contenteditable="false"><?php echo $profileData['Name']; ?></td>
                    <td class="phone" contenteditable="true"><?php echo $profileData['Phone']; ?></td>
                    <td class="email" contenteditable="true"><?php echo $profileData['Email']; ?></td>                    
                    <td class="address" contenteditable="true"><?php echo $profileData['Addres']; ?></td>                    
                    <td>
                        <button class="buttons" onclick="updateProfile('<?php echo $profileData['CompanyID']; ?>')">Update</button>
                        <button class="buttons" onclick="deleteProfile('<?php echo $profileData['CompanyID']; ?>')">Delete</button>
                    </td>             
                </tr>
            </table>
        </div>
        <div id="rented-cars-form" class="hidden">
            <table>
            <tr>
                <th>RentNo</th> 
                <th>Customer ID</th>
                <th>PlateNo</th>
                <th>Car Type</th> 
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
                <?php while ($rental = $rentedCarsResult->fetch_assoc()): ?>
                <tr>
                <td><?php echo $rental['RentNo']; ?></td>
                <td><?php echo $rental['CID']; ?></td>
                <td><?php echo $rental['PlateNo']; ?></td>
                <td><?php echo $rental['CarType']; ?></td>
                <td><?php echo $rental['GearType']; ?></td>
                <td><?php echo $rental['Color']; ?></td>
                <td><?php echo $rental['Year']; ?></td>
                <td><?php echo $rental['RentDateFrom']; ?></td>
                <td><?php echo $rental['RentDateTo']; ?></td>
                <td><?php echo $rental['RentPeriod']; ?></td>
                <td><?php echo $rental['RentDate']; ?></td>
                <td><?php echo $rental['Amount']; ?></td>
                <td><?php echo $rental['PayMethod']; ?></td>
                <td><?php echo $rental['PayDate']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
    <form action="logout.php" method="post">
        <button class="buttons" type="submit">logout</button>
    </form>
</body>
<script>
    function showForm(userType, clickedButton) {
        document.getElementById('cars-not-rent-form').classList.add('hidden');
        document.getElementById('rented-cars-form').classList.add('hidden');
        document.getElementById('my-account-form').classList.add('hidden');
        document.getElementById('Re-display-in-store-form').classList.add('hidden');

        if (userType === 'cars-not-rent') {
            document.getElementById('cars-not-rent-form').classList.remove('hidden');
        }  
        else if (userType === 'rented-cars') {
            document.getElementById('rented-cars-form').classList.remove('hidden');
        }
        else if (userType === 'Re-display-in-store') {
            document.getElementById('Re-display-in-store-form').classList.remove('hidden');
        }
        else if (userType === 'my-account') {
            document.getElementById('my-account-form').classList.remove('hidden');
        } 

        document.querySelectorAll('.option').forEach(button => button.classList.remove('active'));
        clickedButton.classList.add('active');
    }

function updateCar(plateNo) {
    const row = document.querySelector(`#car-${plateNo}`);
    
    const newDailyPrice = row.querySelector(".daily-price").innerText;
    const newColor = row.querySelector(".car-color").innerText;
    const newAvailable = row.querySelector(".available").innerText;

    if (newDailyPrice && newColor && newAvailable) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_car.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send(`PlateNo=${plateNo}&DailyPrice=${newDailyPrice}&Color=${newColor}&Available=${newAvailable}`);

        xhr.onload = function () {
            if (xhr.status == 200) {
                const response = xhr.responseText;

                if (response === "Success") {
                    alert("Car updated successfully!");
                    row.querySelector(".daily-price").innerText = newDailyPrice;
                    row.querySelector(".car-color").innerText = newColor;
                    row.querySelector(".available").innerText = newAvailable;
                } else {
                    alert("Error: " + response); 
                }
            } else {
                alert("Error: " + xhr.statusText);
            }
        };
    } else {
        alert("Please enter valid data.");
    }
}


function deleteCar(plateNo) {
    fetch('delete_car.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `PlateNo=${plateNo}`
    })
    .then(response => response.text())
    .then(data => {
        alert('Car deleted successfully!');
        location.reload(); 
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting car');
    });
}

function updateProfile(companyID) {
    const row = document.querySelector(`#profile-${companyID}`);
    
    const newPhone = row.querySelector(".phone").innerText;
    const newEmail = row.querySelector(".email").innerText;
    const newAddress = row.querySelector(".address").innerText;

    if (newPhone && newEmail && newAddress) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_profile_company.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send(`CompanyID=${companyID}&Phone=${newPhone}&Email=${newEmail}&Addres=${newAddress}`);

        xhr.onload = function () {
            if (xhr.status == 200) {
                const response = xhr.responseText;

                if (response === "Success") {
                    alert("Profile updated successfully!");
                    row.querySelector(".phone").innerText = newPhone;
                    row.querySelector(".email").innerText = newEmail;
                    row.querySelector(".address").innerText = newAddress;
                } else {
                    alert("Error: " + response); 
                }
            } else {
                alert("Error: " + xhr.statusText);
            }
        };
    } else {
        alert("Please enter valid data.");
    }
}

function deleteProfile(companyID) {
    fetch('delete_profile_company.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `CompanyID=${companyID}`
    })
    .then(response => response.text())
    .then(data => {
        alert('Profile deleted successfully!');
        location.reload(); 
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting profile');
    });
}
    

</script>
</html>