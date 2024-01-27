<?php
//inisialisasi session
session_start();

//mengecek username pada session
if( !isset($_SESSION['username']) ){
  $_SESSION['msg'] = 'anda harus login untuk mengakses halaman ini';
  header('Location: index.php');
}

?>

<?php
// Menghubungkan ke database
include 'config.php';



// Mengambil data dari form
$sql = "SELECT * FROM tb_user WHERE username = '$_SESSION[username]'";
$result = $conn -> query($sql);

$sql2 = "SELECT * FROM tb_order ORDER BY id_order DESC LIMIT 1;";
$result2 = $conn -> query($sql2);


if(isset($_POST['pay'])){

$id_user = $_POST['id_user'];
$id_order = $_POST['id_order'];

    

    $sql = "INSERT INTO tb_transaction (id_user,id_order) VALUES ('$id_user','$id_order')";
    if (mysqli_query($conn, $sql)) {
            echo "Gambar berhasil diunggah dan disimpan ke dalam database.";
            header("Location: success.php");
            mysqli_close($conn);
    } else {
            echo "Terjadi kesalahan saat menyimpan data ke dalam database: " . mysqli_error($conn);
    }
}
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
    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
      <li>
        <a href="index.php" class="block py-2 pl-3 pr-4 text-white bg-black rounded md:bg-transparent md:text-black md:p-0 md:dark:text-black" aria-current="page">Home</a>
      </li>
      <li>
        <a href="index.php" class="block py-2 pl-3 pr-4 text-gray-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-black md:p-0 md:dark:hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
      </li>
      <li>
        <a href="index.php" class="block py-2 pl-3 pr-4 text-gray-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-black md:p-0 md:dark:hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
      </li>
      <li>
        <a href="index.php" class="block py-2 pl-3 pr-4 text-gray-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-black md:p-0 md:dark:hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Location</a>
      </li>
    </ul>
  </div>
  </div>
</nav>

<section class="w-full h-screen flex justify-center items-center">
<div class="z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0  max-h-full flex justify-center">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
            </button>
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Bayar Pesanan Anda!</h3>
                <form class="space-y-6" action="" method="post">
                <?php while($row = $result->fetch_assoc()): while($row2 = $result2->fetch_assoc()):  ?>
                <input type="text" name="id_user" id="id_user" value="<?php echo $row['id_user'] ?>" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Mamank Olive" required>
                <input type="text" name="id_order" id="id_order" value="<?php echo $row2['id_order'] ?>" class="hidden bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Mamank Olive" required>
                    <button name="pay" type="submit" class="w-full text-white bg-green-600 hover:bg-white hover:border hover:text-black duration-300 hover:border-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Pay</button>
                </form>
                <?php endwhile; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
  </div> 
</section>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>