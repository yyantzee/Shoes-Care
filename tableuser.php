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

  if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM tb_user WHERE id_user='$id'");
    header("location: tableuser.php");
  }

  if (isset($_POST['update'])) {
    $id = $_POST['id_user'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    
    // Query untuk melakukan update data ke dalam tabel
    $query = "UPDATE tb_user SET email = '$email', username = '$username' WHERE id_user = $id";
    
    // Eksekusi query update
    $result = mysqli_query($conn, $query);
    
    // Cek apakah update berhasil
    if ($result) {
        // Jika berhasil, tampilkan pesan sukses
        header("Location: tableuser.php");
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
  }

  if (isset($_GET['cari'])) {
    $cari = $_GET['cari'];
    $sql = " SELECT * FROM tb_user WHERE id_user LIKE '%$cari%' OR email LIKE '%$cari%' OR username LIKE '%$cari%'";

    $result = $conn->query($sql);
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
<section class="w-full h-32 mt-28">
<h3 class="text-center font-extrabold text-4xl mb-10">TABEL USER</h3>

<form class="mb-5 mx-2">   
    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
        </div>
        <input name="cari" type="search" id="default-search" class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Cari Data" required>
        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-black hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
    </div>
</form>

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
  <?php if ($result -> num_rows > 0): ?>
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    NO
                </th>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    EMAIL
                </th>
                <th scope="col" class="px-6 py-3">
                    USERNAME
                </th>
                <th scope="col" class="px-6 py-3">
                    ACTION
                </th>
            </tr>
        </thead>
        <tbody>
          <?php $nomor = 1; while($rows = $result->fetch_assoc()): ?>
            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <?php echo $nomor ?>
                </th>
                <td class="px-6 py-4">
                <?php echo $rows['id_user'] ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $rows['email'] ?>
                </td>
                <td class="px-6 py-4">
                <?php echo $rows['username'] ?>
                </td>
                <td class="px-6 py-4">
                <button data-modal-target="authentication-modal<?php echo $nomor?>" data-modal-toggle="authentication-modal<?php echo $nomor?>" class="text-blue-600 hover:underline font-bold mr-3">EDIT</button><button data-modal-target="popup-modal<?php echo $nomor?>" data-modal-toggle="popup-modal<?php echo $nomor?>" class="text-red-600 hover:underline font-bold">BANNED</button>
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
                      <input type="text" name="id" value="<?php echo $rows['id_user'] ?>" hidden>
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

            <div id="authentication-modal<?php echo $nomor?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
              <div class="relative w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                  <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal<?php echo $nomor?>">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                  </button>
                    <div class="px-6 py-6 lg:px-8">
                      <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Edit User</h3>
                      <form class="space-y-6" action="#" method="post">
                      <input type="text" name="id_user" value="<?php echo $rows['id_user'] ?>" hidden>
                      <div>
                          <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Email</label>
                          <input type="email" name="email" id="email" value="<?php echo $rows['email']?>" class="bg-gray-50 mb-5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="cipeng@gmail.com" required>
                      </div>
                      <div>
                          <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Username</label>
                          <input type="username" name="username" id="username" value="<?php echo $rows['username']?>" placeholder="Cipenk" class="bg-gray-50 mb-5 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                      </div>
                      <button type="submit" name="update" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mt-5">Edit</button>
                  </form>
              </div>
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
<div class="relative overflow-x-auto shadow-md sm:rounded-lg"> 
</div>
</section>



  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>