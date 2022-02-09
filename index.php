<?php
require_once 'include/DBContract.php';
require_once 'include/AccountManager.php';
require_once 'include/DBManager.php';
$am=AccountManager::getInstance();
if($am->isLoggedIn()):
    header('location:Dashboard.php');
elseif($_SERVER['REQUEST_METHOD']=='POST'):
    //let's process submitted info
      $db_manager->getUserbyEmail();
else:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<main class="container-lg w-100 h-100 d-flex justify-content-center align-items-center">
    <div class="row w-100">
        <div class="card offset-md-3 col-md-6 shadow">
            <div class="card-body p-5">
                <h1 class="card-title border-start border-primary mb-4 text-left font-weight-bold ps-3">E-classe</h1>
                <div class="card-text">
                <h2 class="text-center">SIGN IN</h2>
                <p class="text-center text-gray">
                    Enter your credentials to access your account
                </p>
                <form action="index.php" method="POST">
                    <div class="form-group">
                        <label for="<?= DBContract::$Users_Col_Email ?>">Email</label>
                        <input type="email" class="form-control" id="<?= DBContract::$Users_Col_Email ?>" name="<?= DBContract::$Users_Col_Email ?>" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="<?= DBContract::$Users_Col_Password ?>">Password</label>
                        <input type="password" class="form-control" name="<?= DBContract::$Users_Col_Password ?>" id="<?= DBContract::$Users_Col_Password ?>" placeholder="Enter your password">
                    </div>
                    <input type="submit" class="form-control btn bg-primary text-light py-2" value="SIGN IN">
                </form>
                <p class="text-gray mt-3 mb-0 text-center">
                    Forgot your password? <a href="#" class="text-color-primary text-decoration-none"> Reset Password</a>
                </p>
                </div>
            </div>
        </div>
    </div>

</main>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php include 'footer.php'?></body>
</html>
<?php endif;?>
