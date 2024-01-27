<?php
//menyertakan file program koneksi.php pada register
require('config.php');
//inisialisasi session
session_start();

$error = '';
$validate = '';

//mengecek apakah sesssion username tersedia atau tidak jika tersedia maka akan diredirect ke halaman index
if( isset($_SESSION['username']) ) header('Location: indexlogin.php');

//mengecek apakah form disubmit atau tidak
if( isset($_POST['login']) ){
        
        // menghilangkan backshlases
        $username = stripslashes($_POST['username']);
        //cara sederhana mengamankan dari sql injection
        $username = mysqli_real_escape_string($conn, $username);
         // menghilangkan backshlases
        $password = stripslashes($_POST['password']);
         //cara sederhana mengamankan dari sql injection
        $password = mysqli_real_escape_string($conn, $password);
       
        //cek apakah nilai yang diinputkan pada form ada yang kosong atau tidak
        if(!empty(trim($username)) && !empty(trim($password))){

            //select data berdasarkan username dari database
            $query      = "SELECT * FROM tb_user WHERE username = '$username'";
            $result     = mysqli_query($conn, $query);
            $rows       = mysqli_num_rows($result);

            if ($rows != 0) {
                $hash   = mysqli_fetch_assoc($result)['password'];
                if(password_verify($password, $hash)){
                    $_SESSION['username'] = $username;
               
                    header('Location: indexlogin.php');
                }
                            
            //jika gagal maka akan menampilkan pesan error
            } else {
                $error =  'Login Gagal !!';
            }
            
        }else {
            $error =  'Data tidak boleh kosong !!';
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
      <img src="img/logo.webp" class="h-14 mr-3">
  </a>
  <div class="flex md:order-2">
      <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" type="button" class="text-white bg-black hover:bg-white hover:border hover:border-black hover:text-black hover:duration-200 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Daftar Sekarang</button>
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
        <a href="#home" class="block py-2 pl-3 pr-4 text-white bg-black rounded md:bg-transparent md:text-black md:p-0 md:dark:text-black" aria-current="page">Home</a>
      </li>
      <li>
        <a href="#services" class="block py-2 pl-3 pr-4 text-gray-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-black md:p-0 md:dark:hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
      </li>
      <li>
        <a href="#about" class="block py-2 pl-3 pr-4 text-gray-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-black md:p-0 md:dark:hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
      </li>
      <li>
        <a href="#location" class="block py-2 pl-3 pr-4 text-gray-500 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-black md:p-0 md:dark:hover:text-black dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Location</a>
      </li>
    </ul>
  </div>
  </div>
</nav>


<section class="bg-center bg-[url('img/bg.jpg')] bg-gray-700 bg-blend-multiply">
  <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
      <h1 class="mb-10 tracking-wide mt-14 text-3xl font-extrabold leading-none text-white md:text-5xl lg:text-6xl">Pilihan Terbaik untuk Perawatan Barang Kesayangan Anda</h1>
      <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
          <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-black rounded-lg bg-white hover:bg-gray-300 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
              Pesan Sekarang
              <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
              </svg>
          </button>
          <a href="#about" class="inline-flex justify-center hover:text-gray-900 duration-200 items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
              Cari Tau Kami
          </a>  
      </div>
  </div>
</section>

<section id="home" class="w-full h-72 sm:h-96">
  <h3 class="mb-10 text-center mx-5 mt-10 text-lg font-extrabold leading-none md:text-5xl lg:text-6xl">Kami Telah Melayani Pelanggan Hampir Ke Seluruh Kota Di Indonesia</h3>
  <div class="flex justify-center mx-3">
  <div class="w-60 h-32 text-lg sm:text-4xl">
    <div class="flex">
    <div id="counter" class="font-bold text-2xl"></div><span class="text-2xl">+</span>
    </div>
    <p class="sm:text-2xl text-lg">tersedia hampir diseluruh Indonesia</p>
  </div>
  <div class="w-60 h-32 text-lg sm:text-4xl">
    <div class="flex">
      <div id="counter2" class="font-bold text-2xl"></div><span class="text-2xl">+</span>
      </div>
    <p class="sm:text-2xl text-lg">pasang sepatu telah ditangani</p>
  </div>
  <div class="w-60 h-32 text-lg sm:text-4xl">
    <div class="flex">
      <div id="counter3" class="font-bold text-2xl"></div><span class="text-2xl">+</span>
    </div>
    <p class="sm:text-2xl text-lg">pelanggan puas dengan layanan Kami</p>
  </div>
  </div>
</section>

<section id="services" class="w-full h-[80vh] bg-black">
  <h3 class="mb-10 text-center mx-5 pt-10 text-lg font-extrabold leading-none md:text-5xl text-white lg:text-6xl">Tentang Kami</h3>
  <p class="text-white text-center px-3 sm:text-3xl font-thin">"Shoes and Care" adalah tempat yang mengkhususkan diri dalam produk dan layanan perawatan sepatu. Di toko ini, Anda dapat menemukan berbagai macam produk yang berkaitan dengan perawatan sepatu, seperti produk pembersih, pelumas, semprotan perlindungan, serta aksesori seperti tali sepatu dan sol dalam.

    Selain produk-produk perawatan sepatu, toko ini juga mungkin menawarkan layanan seperti pembersihan, perbaikan, dan pengecatan ulang sepatu. Layanan ini bertujuan untuk memperpanjang umur sepatu Anda, menjaga penampilan mereka tetap bagus, dan melindungi mereka dari kerusakan akibat penggunaan sehari-hari atau elemen lingkungan.
    
    Toko "Shoes and Care" bisa menjadi tempat yang bermanfaat bagi mereka yang peduli dengan perawatan sepatu mereka, baik untuk menjaga tampilan estetis maupun untuk memastikan kenyamanan dan daya tahan sepatu dalam jangka panjang. Dengan berbagai produk dan layanan yang ditawarkan, toko ini dapat menjadi solusi yang praktis bagi mereka yang ingin menjaga investasi dalam sepatu berkualitas.</p>
</section>

<section id="about" class="w-full h-[150vh] sm:h-[55vh] bg-white px-5">
  <h3 class="mb-10 text-center mx-5 mt-10 text-lg font-extrabold leading-none md:text-5xl lg:text-6xl">Layanan Kami</h3>
  <div class="hidden sm:block">
    <div class=" flex justify-center gap-3">
    <div class="">
    <img src="img/imgone.jpg" alt="" class="h-44 w-full object-cover">
    <h3 class="text-3xl font-extrabold text-center mt-3">Fast Cleaning</h3>
    <p class="font-semibold text-center mt-3 text-black">Fast cleaning merupakan pencucian instan pada bagian upper dan midsole yang bisa di tunggu selama 15-30 menit.</p>
    </div>
    <div class="">
    <img src="img/imgtwo.jpg" alt="" class="h-44 w-full object-cover">
    <h3 class="text-3xl font-extrabold text-center mt-3">Deep Cleaning</h3>
    <p class="font-semibold text-center mt-3 text-black">Perawatan pembersihan sepatu secara detail dan menyeluruh pada seluruh bagian.</p>
    </div>
    <div class="">
    <img src="img/imgthree.png" alt="" class="h-44 w-full object-cover">
    <h3 class="text-3xl font-extrabold text-center mt-3">Premium Treatment</h3>
    <p class="font-semibold text-center mt-3 text-black">Perawatan yang ditujukan untuk material-material khusus dalam pengerjaanya serta menggunakan bahan khusus dalam setiap produknya.</p>
  </div>
  </div>
  </div>
  
  <div class="sm:hidden">
  <div class="w-full h-96 mb-8">
    <div class="flex justify-center">
    <img src="img/imgone.jpg" alt="" class="w-96 rounded-lg md:px-64">
    </div>
    <h3 class="text-3xl font-extrabold text-center mt-3">Fast Cleaning</h3>
    <p class="font-semibold text-center mt-3 text-black">Fast cleaning merupakan pencucian instan pada bagian upper dan midsole yang bisa di tunggu selama 15-30 menit.</p>
  </div>

  <div class="w-full h-96 mb-8 md:px-64">
    <div class="flex justify-center">
    <img src="img/imgtwo.jpg" alt="" class="w-96 rounded-lg">
    </div>
    <h3 class="text-3xl font-extrabold text-center mt-3">Deep Cleaning</h3>
    <p class="font-semibold text-center mt-3 text-black">Perawatan pembersihan sepatu secara detail dan menyeluruh pada seluruh bagian.</p>
  </div>

  <div class="w-full h-96 md:px-64">
    <div class="flex justify-center">
    <img src="img/imgthree.png" alt="" class="w-96 rounded-lg">
    </div>
    <h3 class="text-3xl font-extrabold text-center mt-3">Premium Treatment</h3>
    <p class="font-semibold text-center mt-3 text-black">Perawatan yang ditujukan untuk material-material khusus dalam pengerjaanya serta menggunakan bahan khusus dalam setiap produknya.</p>
  </div>
  </div>
  
</section>

<section id="location" class="w-full h-[73vh] sm:h-[90vh] bg-black px-5">
  <h3 class="mb-10 text-center mx-5 pt-10 text-lg font-extrabold leading-none md:text-5xl text-white lg:text-6xl">Lokasi Kami</h3>
  <div class="flex justify-center">
  <iframe class="sm:w-full" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.3009391861497!2d106.84485407509653!3d-6.355076093634862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ec38d9837a99%3A0x69a68bc8771d0dc8!2sShoes%20And%20Care%20Depok!5e0!3m2!1sid!2sid!4v1693209221330!5m2!1sid!2sid" width="350" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <p class="text-white text-center mt-5">Temukan Toko Kami Di Sekitar Anda</p>
</section>


<footer class="bg-white dark:bg-gray-900 m-4 flex justify-center">
      <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="" class="hover:underline">Shoes And Care IT™</a>. All Rights Reserved.</span>
</footer>

<div id="authentication-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
  <div class="relative w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
          <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="authentication-modal">
              <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
              </svg>
              <span class="sr-only">Close modal</span>
          </button>
          <div class="px-6 py-6 lg:px-8">
              <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Masukan Akun</h3>
              <form class="space-y-6" action="#" method="post">
                  <?php if($error != ''){ ?>
                        <div class="text-red-600" role="alert"><?= $error; ?></div>
                  <?php } ?>
                  <div>
                      <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Username</label>
                      <input type="username" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Mamank Olive" required>
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukan Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                  </div>
                  <div class="flex justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                              <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required>
                          </div>
                          <label for="remember" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Ingat Aku</label>
                      </div>
                  </div>
                  <button name="login" type="submit" class="w-full text-white bg-black hover:bg-white hover:border hover:text-black duration-300 hover:border-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Masuk</button>
                  <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                      Gak Punya Akun? <a href="register.php" class="text-black hover:underline dark:text-black">Buat Sekarang</a>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div> 




<script>
  let counts = setInterval(updated);
  let counts2 = setInterval(updated2);
  let counts3 = setInterval(updated3);
  let upto = 0;
  function updated() {
      let count = document.getElementById("counter");
      count.innerHTML = ++upto;
      if (upto === 20) {
          clearInterval(counts);
      }
  }
  
  function updated2() {
      let count = document.getElementById("counter2");
      count.innerHTML = ++upto;
      if (upto === 1000) {
          clearInterval(counts2);
      }
  }
  function updated3() {
      let count = document.getElementById("counter3");
      count.innerHTML = ++upto;
      if (upto === 5000) {
          clearInterval(counts3);
      }
  }
</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
</body>
</html>