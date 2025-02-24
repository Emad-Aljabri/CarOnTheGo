<?php
session_start();
require_once 'Db_connect.php';

if (isset($_SESSION['username'])) {
    $redirectUrl = "ClientProfile.php"; 
} else {
    $redirectUrl = "Login.php"; 
}
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

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <style>
      .company-card {
    text-align: center;
    padding: 20px;
    background-color: #f5f5f5;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.company-card:hover {
    transform: translateY(-5px);
}

.company-logo {
    width: 100px;
    height: 100px;
    margin: 0 auto 10px;
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
}

.company-name {
    font-size: 16px;
    font-weight: 600;
    color: #333;
} 


    </style>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-[#FFFFFF] group/design-root overflow-x-hidden" style='font-family: "Work Sans", "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#EEEEEE] px-10 py-3">
          <div class="flex items-center gap-4 text-black">
            <div class="size-4">
            </div>
            <h2 class="text-black text-lg font-bold leading-tight tracking-[-0.015em]">CarOnTheGo</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-black text-sm font-medium leading-normal" href="Home.php">Home</a>
              <a class="text-black text-sm font-medium leading-normal" href="#Who-we-are">Who we are</a>
              <a class="text-black text-sm font-medium leading-normal" href="#Our-Partners">Our Partners</a>
              <a class="text-black text-sm font-medium leading-normal" href="#Contact-us">Contact us</a>
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
          <h3 class="text-black text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Companies Available for Rent</h3>
          <div class="grid grid-cols-3 gap-6 p-4">
            <div class="company-card">
              <a href="Lexus.php">
                <div class="company-logo" style="background-image: url('Lexus-logo.png');"></div>
              </a>
              <p class="company-name text-center">Lexus</p>
            </div>
            <div class="company-card">
              <a href="Toyota.php">
                <div class="company-logo" style="background-image: url('Toyota-logo.png');"></div>
              </a>
              <p class="company-name text-center">Toyota</p>
            </div>
            <div class="company-card">
              <a href="Nissan.php">
                <div class="company-logo" style="background-image: url('Nissan-logo.png');"></div>
              </a>
              <p class="company-name text-center">Nissan</p>
            </div>
            <div class="company-card">
              <a href="Ford.php">
                <div class="company-logo" style="background-image: url('Ford-logo.png');"></div>
              </a>
              <p class="company-name text-center">Ford</p>
            </div>
            <div class="company-card">
              <a href="Mercedes.php">
                <div class="company-logo" style="background-image: url('Mercedes-logo.png');"></div>
              </a>
              <p class="company-name text-center">Mercedes</p>
            </div>
            <div class="company-card">
              <a href="Mazda.php">
                <div class="company-logo" style="background-image: url('mazda.png');"></div>
              </a>
              <p class="company-name text-center">Mazda</p>
              </div>
            </div>
            <h3 id="Our-Partners" class="text-black text-lg font-bold leading-tight ">Our Partners</h3>
            <div class="grid grid-cols-[repeat(auto-fit,minmax(158px,1fr))] gap-3 p-4">
              <div class="flex flex-col gap-3 pb-3">
                <a href="https://rotanacars.com.sa/">
                <div
                  class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl"
                  style='background-image: url("rotana.png");'
                ></div>
                </a>
                <p class="company-name text-center">Rotana</p>
              </div>
              <div class="flex flex-col gap-3 pb-3">
                <a href="https://www.iyelo.com/ar/home/index">
                <div
                  class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl"
                  style='background-image: url("yelo.png");'
                ></div>
                </a>
                <p class="company-name text-center">Yelo</p>
              </div>
            </div>
            <h3 id="Who-we-are" class="text-black text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Who we are</h3>
            <p class="text-black text-base font-normal leading-normal pb-3 pt-1 px-4">
              We're an intermediary, working with leading car rental companies to offer you a wide range of vehicles at the best prices. Our partners include both well-known brands
              and local specialists, so you can choose the perfect car for your trip. Whether you're planning a city break or a cross-country adventure, we've got you covered.
            </p>
            <h3 id="Contact-us" class="text-black text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Contact Us</h3>

<form method="POST" action="process_contact.php">
  <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
    <label class="flex flex-col min-w-40 flex-1">
      <p class="text-black text-base font-medium leading-normal pb-2">Name</p>
      <input
        name="name"
        placeholder="Your Name"
        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-black focus:outline-0 focus:ring-0 border-none bg-[#EEEEEE] focus:border-none h-14 placeholder:text-[#6B6B6B] p-4 text-base font-normal leading-normal"
        required
      />
    </label>
  </div>
  
  <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
    <label class="flex flex-col min-w-40 flex-1">
      <p class="text-black text-base font-medium leading-normal pb-2">Email</p>
      <input
        name="email"
        placeholder="Your Email"
        type="email"
        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-black focus:outline-0 focus:ring-0 border-none bg-[#EEEEEE] focus:border-none h-14 placeholder:text-[#6B6B6B] p-4 text-base font-normal leading-normal"
        required
      />
    </label>
  </div>
  
  <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
    <label class="flex flex-col min-w-40 flex-1">
      <p class="text-black text-base font-medium leading-normal pb-2">Subject</p>
      <input
        name="subject"
        placeholder="Subject"
        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-black focus:outline-0 focus:ring-0 border-none bg-[#EEEEEE] focus:border-none h-14 placeholder:text-[#6B6B6B] p-4 text-base font-normal leading-normal"
        required
      />
    </label>
  </div>
  
  <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
    <label class="flex flex-col min-w-40 flex-1">
      <p class="text-black text-base font-medium leading-normal pb-2">Message</p>
      <textarea
        name="message"
        placeholder="Your Message"
        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-black focus:outline-0 focus:ring-0 border-none bg-[#EEEEEE] focus:border-none min-h-36 placeholder:text-[#6B6B6B] p-4 text-base font-normal leading-normal"
        required
      ></textarea>
    </label>
  </div>
  
  <div class="flex px-4 py-3 justify-start">
    <button
      type="submit"
      class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-black text-[#FFFFFF] text-sm font-bold leading-normal tracking-[0.015em]"
    >
      <span class="truncate">Send</span>
    </button>
  </div>
  </form>
</div>
 </div>
</div>
</div>
</body>
</html>

