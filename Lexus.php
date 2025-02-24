<?php
require_once 'Db_connect.php';



$sql = "
    SELECT 
        v.PlateNo, v.GearType, v.DailyPrice, v.Color, v.Year, v.CompanyID, 
        v.CarType, v.ComCode, v.MCode, cm.MName
    FROM 
        vehicle v
    INNER JOIN 
        carmodel cm ON v.MCode = cm.MCode AND v.ComCode = cm.ComCode
    WHERE 
        v.ComCode = 05 AND Available = 1
";

$result = $conn->query($sql);
if (!$result) {
    die("Error in executing query:" . $conn->error);
}

$carsByType = [
    'Sedans' => [],
    'SUV' => [],
    'Sports' => []
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['carImage'] = $row['MName'] . ".png";
        
        if($row['CompanyID']==1010){
          $row['CompanyImage']= "yelo.png";
        }
        elseif($row['CompanyID']==2020){
          $row['CompanyImage']= "rotana.png";          
        }

        $carsByType[$row['CarType']][] = $row;
    }
}
session_start();

if (isset($_SESSION['username'])) {
    $redirectUrl = "ClientProfile.php"; 
} else {
    $redirectUrl = "Login.php"; 
}
$conn->close();
?>



<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Work+Sans%3Awght%40400%3B500%3B700%3B900"
    />
    <title>CarOnTheGo</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style>
  .div1, .div2, .div3 { 
    text-align: center;
    padding: 50px;
    background: linear-gradient(135deg, #5a4444, #4a4c7e);
    border-radius: 15px;
    box-shadow: 0 4px 30px rgba(236, 17, 17, 0.1);
    display: flex;
    flex-wrap: wrap; 
    gap: 20px;
    justify-content: center;
    width: 1000px;
  }

    .car-item {
      width:fit-content(33.33% - 20px); 
      max-width: 300000000px; 
      background-color: white;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }
    .company-image {
      width: 50px;
      height: 50px;
      background-repeat: no-repeat;
      background-size: cover;
      border-radius: 8px; 
      margin: 10px auto; 
    }
    .toggle-btn {
      background-color: #000000;
      color: white;
      border: none;
      padding: 10px 15px;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
  
    .toggle-btn:hover {
      background-color: #333333;
    }
  </style>

  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-[#FFFFFF] group/design-root overflow-x-hidden" style='font-family: "Work Sans", "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#EEEEEE] px-10 py-3">
          <div class="flex items-center gap-4 text-black">
            <h2 class="text-black text-lg font-bold leading-tight tracking-[-0.015em]">Lexus</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-black text-sm font-medium leading-normal" href="Home.php">Home</a>
              <a class="text-black text-sm font-medium leading-normal" href="Home.php#Who-we-are">Who we are</a>
              <a class="text-black text-sm font-medium leading-normal" href="Home.php#Our-Partners">Our Partners</a>
              <a class="text-black text-sm font-medium leading-normal" href="Home.php#Contact-us">Contact us</a>
            </div>
            <a href="<?php echo $redirectUrl; ?>">
              <div
                  class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                  style='background-image: url("fues-user.png");'
              ></div>
          </a>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
            <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
              <div class="@container">
                <div class="@[480px]:p-4">
                  <div
                    class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-start justify-end px-4 pb-10 @[480px]:px-10"
                    style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.4) 100%), url("https://cdn.usegalileo.ai/sdxl10/0345e644-2697-4bb3-9a3d-b3facf668f05.png");'
                  >
                    <div class="flex flex-col gap-2 text-left">
                      <h1
                        class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em]"
                      >
                        Welcome to Lexus
                      </h1>
                      <h2 class="text-white text-sm font-normal leading-normal @[480px]:text-base @[480px]:font-normal @[480px]:leading-normal">Explore our car collection</h2>
                    </div>
                   </div>
                </div>
              </div>
              <div class="flex items-center gap-9">
                <a class="toggle-btn" href="#Sedans">Sedans</a>
                <a class="toggle-btn" href="#SUV">SUV</a>
                <a class="toggle-btn" href="#Sports">Sports</a>
            </div>
              <div class="px-40 flex flex-1 justify-center py-5">
              <div class="layout-content-container flex flex-col max-w-[960px] flex-1">        
                  <!-- قسم Sedans -->
                  <h2 id="Sedans" class="text-black text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Sedans</h2>
                  <div class="div1 car-item" id="SedansContainer">
                      <?php foreach ($carsByType['Sedans'] as $car): ?>
                          <div class="car-item p-3 bg-white rounded shadow-md flex flex-col items-center">
                          <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl" style="background-image: url('<?= $car['carImage'] ?>'); height: 150px;"></div>
                              <p class="text-black text-base font-medium leading-normal">Car Name: <?= $car['MName'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Plate Number: <?= $car['PlateNo'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Gear Type: <?= $car['GearType'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Daily Price: <?= $car['DailyPrice'] ?> S.R/Day</p>
                              <p class="text-black text-base font-medium leading-normal">Car Color: <?= $car['Color'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Year Of Manufacture: <?= $car['Year'] ?></p>
                              <div class="company-image" style="background-image: url('<?= $car['CompanyImage'] ?>')"></div>
                              <button class="toggle-btn" onclick="addToCart('<?= $car['MName'] ?>',  '<?= $car['PlateNo'] ?>',  '<?= $car['GearType'] ?>',  '<?= $car['Year'] ?>',   <?= $car['DailyPrice'] ?>, '<?= $car['carImage'] ?>', '<?= $car['CompanyID'] ?>')">Rent</button>
                              </div>
                      <?php endforeach; ?>
                  </div>
      
                  <!-- قسم SUV -->
                  <h2 id="SUV" class="text-black text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">SUV</h2>
                  <div class="div2 car-item" id="SUVContainer">
                      <?php foreach ($carsByType['SUV'] as $car): ?>
                        <div class="car-item p-3 bg-white rounded shadow-md flex flex-col items-center">
                              <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl" style="background-image: url('<?= $car['carImage'] ?>'); height: 150px;"></div>
                              <p class="text-black text-base font-medium leading-normal">Car Name: <?= $car['MName'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Plate Number: <?= $car['PlateNo'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Gear Type: <?= $car['GearType'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Daily Price: <?= $car['DailyPrice'] ?> S.R/Day</p>
                              <p class="text-black text-base font-medium leading-normal">Car Color: <?= $car['Color'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Year Of Manufacture: <?= $car['Year'] ?></p>
                              <div class="company-image" style="background-image: url('<?= $car['CompanyImage'] ?>')"></div>
                              <button class="toggle-btn" onclick="addToCart('<?= $car['MName'] ?>',  '<?= $car['PlateNo'] ?>',  '<?= $car['GearType'] ?>',  '<?= $car['Year'] ?>',   <?= $car['DailyPrice'] ?>, '<?= $car['carImage'] ?>', '<?= $car['CompanyID'] ?>')">Rent</button>
                              </div>
                      <?php endforeach; ?>
                  </div>
      
                  <!-- قسم Sports -->
                  <h2 id="Sports" class="text-black text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Sports</h2>
                  <div class="div3 car-item" id="SportsContainer">
                      <?php foreach ($carsByType['Sports'] as $car): ?>
                        <div class="car-item p-3 bg-white rounded shadow-md flex flex-col items-center">
                              <div class="w-full bg-center bg-no-repeat aspect-video bg-cover rounded-xl" style="background-image: url('<?= $car['carImage'] ?>'); height: 150px;"></div>
                              <p class="text-black text-base font-medium leading-normal">Car Name: <?= $car['MName'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Plate Number: <?= $car['PlateNo'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Gear Type: <?= $car['GearType'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Daily Price: <?= $car['DailyPrice'] ?> S.R/Day</p>
                              <p class="text-black text-base font-medium leading-normal">Car Color: <?= $car['Color'] ?></p>
                              <p class="text-black text-base font-medium leading-normal">Year Of Manufacture: <?= $car['Year'] ?></p>
                              <div class="company-image" style="background-image: url('<?= $car['CompanyImage'] ?>')"></div>
                              <button class="toggle-btn" onclick="addToCart('<?= $car['MName'] ?>',  '<?= $car['PlateNo'] ?>',  '<?= $car['GearType'] ?>',  '<?= $car['Year'] ?>',   <?= $car['DailyPrice'] ?>, '<?= $car['carImage'] ?>', '<?= $car['CompanyID'] ?>')">Rent</button>
                              </div>
                      <?php endforeach; ?>
                  </div>
              </div>
          </div>
      
          <script>
              function addToCart(carName, plateNo, gearType, year, dailyPrice, carImage, companyID) {
              const form = document.createElement('form');
              form.method = 'POST';
              form.action = 'cart.php';

               const fields = {
               carName,
               plateNo,
               gearType,
               year,
              dailyPrice,
              carImage,
              companyID
              };

              for (const key in fields) {
              const input = document.createElement('input');
              input.type = 'hidden';
              input.name = key;
              input.value = fields[key];
              form.appendChild(input);
             }

             document.body.appendChild(form);
             form.submit();
             }

            </script>
      </body>
</html>
