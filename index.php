<!-- 
  Anggota Kelompok
  1. Yehezkiel David Setiawan (2172003) - Membuat halaman cover edit
  2. Laurentius Gusti Ontoseno Panata Yudha (2172028) -  mengintegrasikan edit cover ketika buku baru ingin mengubah cover dan mendelete cover

  Karena kami telah menyelesaikan cover edit pada akhir kelas, jadi kami hanya menambahkan beberapa syarat yang diperlukan saja.

-->

<?php
  session_start();
  if(!isset($_SESSION['registered_user'])){
    $_SESSION['registered_user'] = false;
  }
  include_once 'db_util/util_function.php';
  // include_once 'db_util/genre_function.php';
  include_once 'db_util/book_function.php';
  // include_once 'db_util/user_function.php';
  include_once 'dao/PDOUtil.php';
  include_once 'dao/UserDao.php';
  include_once 'dao/BookDao.php';
  include_once 'dao/GenreDao.php';
  include_once 'entity/Book.php';
  include_once 'entity/Genre.php';
  include_once 'entity/User.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="author" content="Kelompok">
    <title>BookStudio</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap5.min.css">
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
      integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <section class="backg text-white">
      <?php 
        if ($_SESSION['registered_user']){

        
      ?>
      <div class="container">
        <div class="row d-flex justify-content-center align-items-center">
          <div class="col-md-2">
            <img src="img/bookstudio.png" class="logo" alt="" />
          </div>
          <div class="col-md-4">
            <h2>BookStudio</h2>
            <h5>Universitas Kristen Maranatha</h5>
            <h5>Bandung</h5>
          </div>
          <div class="col-md-6"></div>
        </div>
      </div>
      <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid me-0">
          <button class="navbar-toggler mx-auto py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> 
                <span class="navbar-toggler-icon"></span> 
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto my-auto" style="padding-left:5rem">
              <li class="nav-item">
                <a class="nav-link" href="?menu=home"><h5>Home</h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?menu=genre"><h5>Genre</h5></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="?menu=book"><h5>Book</h5></a>
              </li>
            </ul>
            <a class="nav-link btn btn-danger btn-lg p-2" href="?menu=logout"><h5 >Logout</h5></a>
          </div>
        </div>
      </nav>

    </section>
    <main>
        <?php
        $navigation = filter_input(INPUT_GET, 'menu');
        switch ($navigation) {
            case 'home':
                include_once 'pages/home.php';
                break;
            case 'genre':
                include_once 'pages/genre.php';
                break;
            case 'book':
                include_once 'pages/book.php';
                break;
            case 'genre_update':
                include_once 'pages/genre_edit.php';
                break;
            case 'book_update':
                include_once 'pages/book_edit.php';
                break;
            case 'cover_update':
                include_once 'pages/cover_edit.php';
                break;
            case 'logout':
                session_unset();
                session_destroy();
                header('location:index.php');
                break;
            default:
                include_once 'pages/home.php';
                break;
        }
        ?>
    </main>
    <?php 
    }else{
      include_once('pages/login.php');

    }
    ?>
    <footer class="bg-light text-center text-lg-start " >
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2023 Copyright:
        <a class="text-dark" href="https://mdbootstrap.com/">BookStudio.com</a>
      </div>
      <!-- Copyright -->
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#book').DataTable();
            $('#genre').DataTable();
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/darkmode-js@1.5.7/lib/darkmode-js.min.js"></script>
    <script>
      function addDarkmodeWidget() {
        const options = {
          bottom: '64px', 
          right: '32px', 
          left: 'unset', 
          time: '1s', 
          mixColor: '#fff', 
          backgroundColor: '#fff',
          buttonColorDark: '#100f2c', 
          buttonColorLight: '#fff', 
          saveInCookies: false, 
          label: '⚪', 
          autoMatchOsTheme: true, 
        };

        const darkmode = new Darkmode(options);
        darkmode.showWidget();
      }

      window.addEventListener('load', addDarkmodeWidget);
    </script> 
  </body>
</html>