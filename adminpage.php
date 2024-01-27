<?php
//inisialisasi session

session_start();

//mengecek username pada session
if( !isset($_SESSION['username_admin']) ){
  $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
  header('Location: adminlogin.php');
}

?>

<?php
// Menghubungkan ke database
include 'config.php';
$sql = "SELECT * FROM tb_user";
$result = $conn -> query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoes And Care</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
  <style>
    html{
      scroll-behavior: smooth;
    }
  </style>
</head>
<body>
  
<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
  <a href="index.php" class="flex items-center">
      <img src="img/logo.webp" class="h-14 mr-3" alt="Flowbite Logo">
  </a>
  <div class="flex md:order-2">
      <a href="logout.php"><button type="button" class="text-white bg-black hover:bg-white hover:border hover:border-black hover:text-black hover:duration-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Log Out</button></a>
      <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>
  </div>
  <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
    <h3 class="text-2xl font-extrabold">CONTROL PANEL</h3>
  </div>
  </div>
</nav>

<section class="w-full h-32">
<iframe src="tableuser.php" width="100%" height="400"></iframe>
<iframe src="tabletransaction.php" width="100%" height="400"></iframe>
</section>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>