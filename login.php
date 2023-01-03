<?php
include 'template.php';
include 'navbar.php';
?>
<?php
session_start();
$host_db    = "localhost";
$user_db    = "root";
$pass_db    = "";
$nama_db    = "login";
$koneksi    = mysqli_connect($host_db, $user_db, $pass_db, $nama_db);
$err        = "";
$username   = "";

if (isset($_COOKIE['cookie_username'])) {
    $cookie_username = $_COOKIE['cookie_username'];
    $cookie_password = $_COOKIE['cookie_password'];

    $sql1 = "select * from login where username = '$cookie_username'";
    $q1   = mysqli_query($koneksi, $sql1);
    $r1   = mysqli_fetch_array($q1);
    if ($r1['password'] == $cookie_password) {
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
    }
}

if (isset($_SESSION['session_username'])) {
    header("location:halaman_admin");
    exit();
}

if (isset($_POST['login'])) {
    $username   = $_POST['username'];
    $password   = $_POST['password'];

    if ($username == '' or $password == '') {
        $err .= "<center>Silakan masukkan username dan juga password.</center>";
    } else {
        $sql1 = "select * from login where username = '$username'";
        $q1   = mysqli_query($koneksi, $sql1);
        $r1   = mysqli_fetch_array($q1);

        if ($r1['username'] == '') {
            $err .= "<center>Username <b>$username</b> tidak tersedia.</center>";
        } elseif ($r1['password'] != md5($password)) {
            $err .= "<center>Password yang dimasukkan salah.</center>";
        }

        if (empty($err)) {
            $_SESSION['session_username'] = $username;
            $_SESSION['session_password'] = md5($password);

            if ($ingataku == 1) {
                $cookie_name = "cookie_username";
                $cookie_value = $username;
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name, $cookie_value, $cookie_time, "/");

                $cookie_name = "cookie_password";
                $cookie_value = md5($password);
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name, $cookie_value, $cookie_time, "/");
            }
            header("location:halaman_admin.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <link rel="shortcut icon" href="assets/icon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body>
    <?php if ($err) { ?>
        <div id="login-alert" class="alert alert-danger col-sm-12">
            <ul><?php echo $err ?></ul>
        </div>
    <?php } ?>
    <form id="loginform" class="form-horizontal" action="" method="post" role="form">
        <section class="vh-100" style="background-color: #508bfc;">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                            <div class="card-body p-5 text-center">
                                <h2 class="mb-5">Selamat Datang Admin</h2>
                                <hr class="my-4">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typeEmailX-2">Username</label>
                                    <input id="login-username" type="text" name="username" value="<?php echo $username ?>" class="form-control form-control-lg" placeholder="" />
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typePasswordX-2">Password</label>
                                    <input id="login-password" type="password" name="password" class="form-control form-control-lg" />
                                </div>
                                <input type="reset" class="btn btn-danger btn-lg btn-block" value="Batal" />
                                <button class="btn btn-primary btn-lg btn-block" type="submit" name="login" value="Login">Login</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
