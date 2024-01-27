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

$sql = "SELECT tb_transaction.id,tb_user.username,tb_order.id_order,tb_order.type_shoes,tb_order.quantity,tb_order.payment FROM tb_transaction INNER JOIN tb_user ON tb_user.id_user=tb_transaction.id_user INNER JOIN tb_order ON tb_order.id_order=tb_transaction.id_order WHERE username = '$_SESSION[username]' ";
$result = $conn -> query($sql);

if (isset($_POST['delete'])) {
  $id_transaction = $_POST['id_deletetransaction'];
  $id_order = $_POST['id_deleteorder'];
  mysqli_query($conn, "DELETE FROM tb_transaction WHERE id='$id_transaction'");
  mysqli_query($conn, "DELETE FROM tb_order WHERE id_order='$id_order'");
  header("location: historylogin.php");
}

mysqli_close($conn);
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

<section class="w-full h-32 mt-28">
  <h3 class="text-center font-extrabold text-4xl">HISTORY PESANAN MU</h3>
  <h3 class="text-center font-semibold text-2xl mt-3 text-yellow-500 mb-10">** TUNJUKAN ID SAAT DI TOKO **</h3>
  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <?php if ($result -> num_rows > 0): ?>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    NO
                </th>
                <th scope="col" class="px-6 py-3">
                    ID PEMBELIAN
                </th>
                <th scope="col" class="px-6 py-3">
                    TIPE SEPATU
                </th>
                <th scope="col" class="px-6 py-3">
                    JUMLAH
                </th>
                <th scope="col" class="px-6 py-3">
                    PEMBAYARAN
                </th>
                <th scope="col" class="px-6 py-3">
                    ACTION
                </th>
            </tr>
        </thead>
        <?php $nomor = 1; while($row = $result->fetch_assoc()): ?>
        <tbody>
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $nomor?>
                </th>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $row['id']?>
                </th>
                <td class="px-6 py-4">
                <?php echo $row['type_shoes'] ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $row['quantity'] ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $row['payment'] ?>
                </td>
                <td class="px-6 py-4">
                <button name="senddata" data-modal-target="popup-modal<?php echo $nomor?>" data-modal-toggle="popup-modal<?php echo $nomor?>" class="text-red-600 hover:underline font-bold">DELETE</button>
                </td>
            </tr>

            <div id="popup-modal<?php echo $nomor?>" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal<?php echo $nomor?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                  <form action="" method="post">
                    <div class="p-6 text-center">
                      <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                      </svg>
                      <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Apakah kamu yakin ingin menghapus pesanan mu?</h3>
                      <form action="" method="post">
                      <input type="text" name="id_deletetransaction" value="<?php echo $row['id'] ?>" hidden>
                      <input type="text" name="id_deleteorder" value="<?php echo $row['id_order'] ?>" hidden>
                      <button name="delete" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                      Yakin, Saya Yakin
                      </button>
                      </form>
                      <button data-modal-hide="popup-modal<?php echo $nomor?>" name="delete" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tidak</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            <?php $nomor++; endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Tidak Ada Data</p>
    <?php endif; ?>
</div>
</section>
    





  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>