<?php
// fungsi untuk memulai session
session_start();

if( isset($_SESSION["username"])){
    header("Location: index.php");
    exit;
}

// variabel kosong untuk menyimpan pesan error
$form_error = '';

// cek apakah tombol sumit sudah di klik atau belum
if(isset($_POST['submit'])){

    // menyimpan data yang dikirim dari metode POST ke masing-masing variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    // validasi login benar atau salah
    if($username == 'dew' AND $password == 'dew'){

        // jika login benar maka username akan disimpan ke session kemudian akan di redirect ke halaman profil
        $_SESSION['username'] = $username;
        header('Location: index.php');
    }else{

        // jika login salah maka variabel form_error diisi value seperti dibawah
        // nilai variabel ini akan ditampilkan di halaman login jika salah
        $form_error = '<p>Password atau username yang kamu masukkan salah</p>';
    }
}

?>

<!DOCTYPE html>
<head>
<meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
     <!-- <link rel="stylesheet" href="css/style.css"> -->
     <title>Dew Azure Web</title>
     <style>
        .login {
        margin: auto;
        width: 60%;
        border: 3px solid #73AD21;
        padding: 10px;
        text-align: center;
        margin-top: 10%;
        background: #dfe6e9;
        }

        .form{
            padding-top: 20px;
            text-align: center;
        }

     </style>
</head>
<body>
<div class="login">

    <h3>Silakan Login</h3>

    <form method="POST" action="">
        Username(dew) : <input type="text" name="username"><br>
        Password(dew) : <input type="password" name="password"><br>
        <?php echo $form_error; ?>
        <input type="submit" name="submit" value="Login">
    </form>
</div>
</body>
</html>