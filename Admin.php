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
    if ($userData['UsType'] != 1) {
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: Login.php");
    exit;
}

if (isset($_POST['delete'])) {
    $type = $_POST['type'];
    $id = $_POST['id'];

    if ($type === 'user') {
        $stmt = $conn->prepare("DELETE FROM customer WHERE CID = ?");
        $stmt->bind_param("i", $id);
    } elseif ($type === 'rental') {
        $stmt = $conn->prepare("DELETE FROM rent WHERE RentNo = ?");
        $stmt->bind_param("i", $id);
    }
    
    
    $stmt->execute();
    $stmt->close();
    header("Location: admin.php"); 
}


$usersResult = $conn->query("SELECT * FROM customer");
$companiesResult = $conn->query("SELECT * FROM company");
$contactUs = $conn->query("SELECT * FROM contactus");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
        <h1 class="h1">Welcome Admin</h1>
        <div class="buttonss">
            <div> 
              <button class="option" onclick="showForm('client', this)">Customer</button>
              <button class="option" onclick="showForm('company', this)">company</button>
              <button class="option" onclick="showForm('cars-not-rent', this)">cars not rent</button>
              <button class="option" onclick="showForm('rents', this)">rents</button>
              <button class="option" onclick="showForm('contactUs', this)">Contact Us</button>
          </div>
        </div>
        <br>
        <div id="contactUs-form" class="hidden">
            <table name="contactUs" >
                <tr>
                    <th>Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                </tr>
                <?php while ($CoUs = $contactUs->fetch_assoc()): ?>
                <tr>
                <td><?php echo $CoUs['CoNo']; ?></td>
                <td><?php echo $CoUs['Name']; ?></td>
                <td><?php echo $CoUs['Email']; ?></td>
                <td><?php echo $CoUs['Subject']; ?></td>
                <td><?php echo $CoUs['Message']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <div id="client-form" class="hidden">
            <table name="Customer" >
                <tr>
                    <th>Frist name</th>
                    <th>Lest name</th>
                    <th>User name</th>
                    <th>Customer ID</th>
                    <th>Licenes ID</th>
                    <th>BirthDate</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>City</th>
                    <th>Street</th>
                    <th>Actions</th>
                </tr>
                <?php while ($user = $usersResult->fetch_assoc()): ?>
                <tr>
                <td><?php echo $user['FName']; ?></td>
                <td><?php echo $user['LName']; ?></td>
                <td><?php echo $user['UsName']; ?></td>
                <td><?php echo $user['CID']; ?></td>
                <td><?php echo $user['LicenesID']; ?></td>
                <td><?php echo $user['BirthDate']; ?></td>
                <td><?php echo $user['Phone']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['City']; ?></td>
                <td><?php echo $user['Street']; ?></td>
                <td>
                    <form method="POST">
                        <input type="hidden" name="type" value="user">
                        <input type="hidden" name="id" value="<?php echo $user['CID']; ?>">
                        <input class="buttons" type="submit" name="delete" value="Delete">
                    </form>
                </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <div id="company-form" class="hidden">
            <table name="Company">
                <tr>
                    <th>Company Name</th>
                    <th>CompanyID</th>
                    <th>user name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Addres</th>
                </tr>
                <?php while ($company = $companiesResult->fetch_assoc()): ?>
                <tr>
                <td><?php echo $company['Name']; ?></td>
                <td><?php echo $company['CompanyID']; ?></td>
                <td><?php echo $company['UsName']; ?></td>
                <td><?php echo $company['Phone']; ?></td>
                <td><?php echo $company['Email']; ?></td>
                <td><?php echo $company['Addres']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    <div id="cars-not-rent-form" class="hidden">
    <table>
        <thead>
            <tr>
                <th>PlateNo</th>
                <th>
                    <label for="company_id_cars">Select Company:</label>
                    <select name="company_id" id="company_id_cars">
                        <option value="">All Companies</option>
                        <?php
                        $companiesResult = $conn->query("SELECT * FROM company");
                        while ($company = $companiesResult->fetch_assoc()) {
                            echo '<option value="' . $company['CompanyID'] . '">' . $company['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </th>
                <th>Company Name</th>
                <th>Model Name</th>
                <th>Gear Type</th>
                <th>Car Type</th>
                <th>Daily Price</th>
                <th>Color</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody id="carData">
            <!-- سيتم تحميل البيانات هنا باستخدام AJAX -->
        </tbody>
    </table>
</div>

<div id="rents-form" class="hidden">
    <table name="rent" border="1">
        <thead>
            <tr>
                <th>RentNo</th>
                <th>Customer ID</th>
                <th>PlateNo</th>
                <th>
                    <label for="company_id_rents">Select Company:</label>
                    <select name="company_id" id="company_id_rents">
                        <option value="">All Companies</option>
                        <?php
                        $companiesResult = $conn->query("SELECT * FROM company");
                        while ($company = $companiesResult->fetch_assoc()) {
                            echo '<option value="' . $company['CompanyID'] . '">' . $company['Name'] . '</option>';
                        }
                        ?>
                    </select>
                </th>
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
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="rentData">
            <!-- سيتم تحميل البيانات هنا باستخدام AJAX -->
        </tbody>
        
    </table>
</div>

    <form action="logout.php" method="post">
        <button class="buttons" type="submit">logout</button>
    </form>
</body>
<script>
    function showForm(userType, clickedButton) {
        document.getElementById('client-form').classList.add('hidden');
        document.getElementById('company-form').classList.add('hidden');
        document.getElementById('cars-not-rent-form').classList.add('hidden');
        document.getElementById('rents-form').classList.add('hidden');
        document.getElementById('contactUs-form').classList.add('hidden');

        if (userType === 'client') {
            document.getElementById('client-form').classList.remove('hidden');
        }  
        else if (userType === 'company') {
            document.getElementById('company-form').classList.remove('hidden');
        } 
        else if (userType === 'cars-not-rent') {
            document.getElementById('cars-not-rent-form').classList.remove('hidden');
        } 
        else if (userType === 'rents') {
            document.getElementById('rents-form').classList.remove('hidden');
        }
        else if (userType === 'contactUs') {
            document.getElementById('contactUs-form').classList.remove('hidden');
        }

        document.querySelectorAll('.option').forEach(button => button.classList.remove('active'));
        clickedButton.classList.add('active');
    }
    document.getElementById('company_id_cars').addEventListener('change', function() {
        var companyId = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_available_cars.php?company_id=' + companyId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('carData').innerHTML = xhr.responseText;
            }
    };
    xhr.send();
});

document.getElementById('company_id_rents').addEventListener('change', function() {
    var companyId = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_rented_cars.php?company_id=' + companyId, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById('rentData').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
});
</script>
</html>