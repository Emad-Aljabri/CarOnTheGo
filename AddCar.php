<?php
require_once 'Db_connect.php';

session_start();

$username = $_SESSION['username']; 

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}


$sql = "SELECT CompanyID FROM company WHERE UsName = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($CompanyID);
$stmt->fetch();
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Car New</title>
</head>
<style>
    body {
        margin: 0;
        padding: 0;
        display:ruby ;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: linear-gradient(135deg, #4a4c7e, #4a4c7e);
        font-family: 'Arial', sans-serif;
        color: white;
    }
    div {
        text-align: center;
        padding: 50px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }
    h1 {
        font-size: 36px;
        margin-bottom: 20px;
    }
    .form-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .form-group {
        flex: 1 1 calc(33.333% - 20px); 
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: none;
        background-color: #EEEEEE;
        color: black;
        font-size: 16px;
        margin-top: 5px;
    }
    .buttons {
        width: 48%;
        padding: 10px;
        background-color: #000000;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 20px;
    }
</style>


<body>
    <div>
        <h1>Add Car New</h1>
        <form id="carForm" method="post" action="Insert_car.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="CarName">Car Name</label>
                    <input type="text" id="CarName" name="MName" placeholder="Car Name" required />
                </div>
                <div class="form-group">
                <label for="company">Select Company:</label>
                <select id="company" name="company"  required>
                    <option value="" disabled selected>choose an option</option>
                    <option value="Toyota">Toyota</option>
                    <option value="Mercedes">Mercedes</option>
                    <option value="Ford">Ford</option>
                    <option value="Mazda">Mazda</option>
                    <option value="Lexus">Lexus</option>
                    <option value="Nissan">Nissan</option>
                </select>
                </div>
                <div class="form-group">
                <label for="CarType">Car Type:</label>
                <select id="CarType" name="CarType" required>
                    <option value="" disabled selected>choose an option</option>
                    <option value="Sedans">Sedans</option>
                    <option value="SUV">SUV</option>
                    <option value="Sports">Sports</option>
                </select>
                </div>
                <div class="form-group">
                    <label for="PlateNumber">Plate number</label>
                    <input type="text" id="PlateNumber" name="PlateNo" placeholder="Plate number" required />
                </div>

                    <input type="hidden" id="ComCode" name="ComCode" placeholder="Company code" required readonly  />


                <div class="form-group">
                    <label for="ModelCode">Model code</label>
                    <input type="text" id="ModelCode" name="MCode" placeholder="Model code" required />
                </div>
                <div class="form-group">
                    <label for="GearType">Gear Type</label>
                    <select id="GearType" name="GearType" required>
                        <option value="" disabled selected>choose an option</option>
                        <option value="Tamatek Qir">Tamatek Qir</option>
                        <option value="Ordinary Qir">Ordinary Qir</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="DailyPrice">Daily Price</label>
                    <input type="number" id="DailyPrice" name="DailyPrice" placeholder="Daily Price" required />
                </div>
                <div class="form-group">
                    <label for="CarColor">Car Color</label>
                    <input type="text" id="CarColor" name="Color" placeholder="Car Color" required />
                </div>
                <div class="form-group">
                    <label for="YearOfManufacture">Year of Manufacture</label>
                    <input type="number" id="YearOfManufacture" name="Year" placeholder="Year of Manufacture" required />
                </div>
                <div class="form-group">
                    <label for="CompanyID">Company ID</label>
                    <input type="text" id="CompanyID" name="CompanyID" placeholder="Company ID" value="<?php echo $CompanyID; ?>" required readonly />
                    </div>
            </div>
            <button class="buttons" type="submit">Add Car</button>
            <button class="buttons" type="button" onclick="window.location.href='Company.php'">Cancel</button>
        </form>
    </div>

</body>
<script>
    const companySelect = document.getElementById('company');
    const comCodeInput = document.getElementById('ComCode');

    companySelect.addEventListener('change', function() {
        let comCodeValue = '';

        switch (companySelect.value) {
            case 'Toyota':
                comCodeValue = '01';
                break;
            case 'Mercedes':
                comCodeValue = '02';
                break;
            case 'Ford':
                comCodeValue = '03';
                break;
            case 'Mazda':
                comCodeValue = '04';
                break;
            case 'Lexus':
                comCodeValue = '05';
                break;
            case 'Nissan':
                comCodeValue = '06';
                break;
            default:
                comCodeValue = ''; 
        }

        comCodeInput.value = comCodeValue;
    });
</script>
</html>
