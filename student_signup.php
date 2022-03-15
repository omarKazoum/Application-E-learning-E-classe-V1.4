<?php
require_once 'include/DBContract.php';
require_once 'include/AccountManager.php';
require_once 'include/DBManager.php';
require_once 'include/InputValidator.php';
require_once 'include/utils.php';
$am=AccountManager::getInstance();
$db_manager=DBManager::getInstance();
if($am->isLoggedIn()){
    header('location:dashboard.php');
}
if($_SERVER['REQUEST_METHOD']=='POST' AND isset($_POST[DBContract::$Users_Col_Email]) AND isset($_POST[DBContract::$Users_Password])){
    //let's process submitted info
    $email = $_POST[DBContract::$Users_Col_Email];
    $pass = $_POST[DBContract::$Users_Password];
    $user = null;
    if (InputValidator::validateEmail($email) and InputValidator::validatePassword($pass) ) {
        if($user = $db_manager->getUserByEmail($email) AND password_verify($pass,$user->getPasswordHash())){
            if(isset($_POST[DBContract::$Users_RememberMe]))
                saveLoginDataInACookie();
            else
                deleteLoginDataInCookie();
            $am->login($user->getId());
            header('location:dashboard.php');
            $redirect=1;
        }else{
            $user_error=1;
        }
    }
}
loadLoggingDataFromACookie();
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
                    <form action="student_signup.php" method="POST">
                        <?php if(InputValidator::error(InputValidator::EMAIL_ERROR_KEY)):?>
                            <div class="alert alert-danger">
                                <?=InputValidator::error(InputValidator::EMAIL_ERROR_KEY) ?>
                            </div>
                        <?php endif;?>
                        <div class="form-group">
                            <label for="<?= DBContract::$Users_Col_Email ?>">Email</label>
                            <input type="email" class="form-control <?= InputValidator::error(InputValidator::EMAIL_ERROR_KEY)?'border-danger border':'' ?> " value="<?= $_POST[DBContract::$Users_Col_Email]??$GLOBALS[DBContract::$Users_RememberMe_Email]??'' ?>" id="<?= DBContract::$Users_Col_Email ?>" name="<?= DBContract::$Users_Col_Email ?>" placeholder="Enter your email">
                        </div>
                        <?php if(InputValidator::error(InputValidator::PASSWORD_ERROR_KEY)):?>
                            <div class="alert alert-danger">
                                <?=InputValidator::error(InputValidator::PASSWORD_ERROR_KEY) ?>
                            </div>
                        <?php endif;?>
                        <div class="form-group">
                            <label for="<?= DBContract::$Users_Password ?>">Password</label>
                            <input type="password" class="<?= InputValidator::error(InputValidator::PASSWORD_ERROR_KEY)?'border-danger border':'' ?> form-control" value="<?= $_POST[DBContract::$Users_Password]??$GLOBALS[DBContract::$Users_RememberMe_Pass]??'' ?>" name="<?= DBContract::$Users_Password ?>" id="<?= DBContract::$Users_Password ?>" placeholder="Enter your password">
                        </div>
                        <div class="form-check">
                            <label for="<?= AccountManager::IS_ADMIN_KEY ?>" class="form-check-label">Admin</label>
                            <input type="checkbox" class="form-check-input" <?= isset($_POST[ AccountManager::IS_ADMIN_KEY ]) OR isset($GLOBALS[ AccountManager::IS_ADMIN_KEY ]) ? 'checked':'' ?> id="<?=  AccountManager::IS_ADMIN_KEY  ?>" name="<?= AccountManager::IS_ADMIN_KEY ?>" >
                        </div>
                        <div class="form-check">
                            <label for="<?= DBContract::$Users_RememberMe ?>" class="form-check-label">Remember me</label>
                            <input type="checkbox" class="form-check-input" <?= (isset($_POST[DBContract::$Users_RememberMe]) OR $GLOBALS[DBContract::$Users_RememberMe]) ?'checked':'' ?> name="<?= DBContract::$Users_RememberMe ?>" id="<?= DBContract::$Users_RememberMe ?>">
                        </div>
                        <input type="submit" class="form-control btn bg-primary text-light py-2" value="SIGN IN">
                        <a class="btn bg-primary text-light py-2 form-control mt-1" href="student_signup.php">SIGN UP</a>
                    </form>
                    <p class="text-gray mt-3 mb-0 text-center">
                        Forgot your password? <a href="#" class="text-color-primary text-decoration-none"> Reset Password</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</main>
<?php if(isset($redirect)) redirect_with_js('dashboard.php');?>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<?php include 'footer.php'?></body>
</html>
