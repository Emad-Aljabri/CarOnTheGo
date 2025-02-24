<!DOCTYPE html>
<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Work+Sans%3Awght%40400%3B500%3B700%3B900"
    />
    <style>
       body {
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
        text-align: center;

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
    .form-group input{
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
        width: 100%;
        padding: 10px;
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        margin-top: 20px;
    }
    .buttonss {
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
        width: 100%;
            display: flex;
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
            background-color: #EEEEEE;
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
    </style>
    <title>CarOnTheGo</title>
  </head>
  <body>
    <div>


<?php
require_once 'Db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $UsType = $_POST['UsType'];


    $stmt = $conn->prepare("SELECT * FROM users WHERE UsName = ? AND Password = ? AND UsType = ?");
    $stmt->bind_param("sss", $username, $password, $UsType);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['username'] = $username;

        if ($UsType == "1") {
          header("Location: Admin.php");
          exit;
      } elseif ($UsType == "3") {
          header("Location: home.php");
          exit;
      } elseif ($UsType == "2") {
          header("Location: company.php");
          exit;
      }
      
    } 
    else {
        echo "Invalid login credentials";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
</head>
<body>
    <div>
        <h1 class="h1">Select your role</h1>
        <div class="buttons">
            <button class="option" onclick="showForm('client', this)">Customer</button>
            <button class="option" onclick="showForm('company', this)">Company</button>
            <button class="option" onclick="showForm('admin', this)">Admin</button>
        </div>

        <br>


        <form method="POST" id="client-form" class="form-grid hidden">
            <input type="hidden" name="UsType" value="3">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <button class="buttonss" type="submit">Login as Customer</button>
        </form>

        <form method="POST" id="company-form" class="form-grid hidden">
            <input type="hidden" name="UsType" value="2">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <button class="buttonss" type="submit">Login as Company</button>
        </form>

        <form method="POST" id="admin-form" class="form-grid hidden">
            <input type="hidden" name="UsType" value="1">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <button class="buttonss" type="submit">Login as Admin</button>
        </form>

        <div class="signup-link">
            <p>Don't have an account? <a href="Sign-up.html">Create one</a></p>
        </div> 
    </div>

    <script>
      function showForm(userType, clickedButton) {
          document.getElementById('client-form').classList.add('hidden');
          document.getElementById('company-form').classList.add('hidden');
          document.getElementById('admin-form').classList.add('hidden');

          if (userType === 'client') {
              document.getElementById('client-form').classList.remove('hidden');
          } else if (userType === 'company') {
              document.getElementById('company-form').classList.remove('hidden');
          } else if (userType === 'admin') {
              document.getElementById('admin-form').classList.remove('hidden');
          }
        document.querySelectorAll('.option').forEach(button => button.classList.remove('active'));
        clickedButton.classList.add('active');
      }
    </script>
  </body>
</html>
