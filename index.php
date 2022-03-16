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
            //this is for admins
            if(isset($_POST[AccountManager::IS_ADMIN_KEY]))
                $user=$db_manager->getUserByEmail($email);
            else
                $user =$db_manager->getStudentByEmail($email);
            if($user AND password_verify($pass,$user->getPasswordHash())){
                if(isset($_POST[DBContract::$Users_RememberMe]))
                    saveLoginDataInACookie();
                else
                    deleteLoginDataInCookie();
                    $am->login($user->getId(),$user->isAdmin() );
                    header(!$user->isAdmin() ? 'location:courses.php':'location:dashboard.php');
                }else{
                $user_error=1;
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
                    <?php printMessageIfexists();?>
                    <?php if(isset($user_error)){ ?>
                        <div class="alert alert-danger">
                            Invalid credentials check your spelling and try again !
                        </div>
                    <?php }?>
                <form action="index.php" method="POST" id="login_form">
                       <div class="form-group">
                        <label for="<?= DBContract::$Users_Col_Email ?>">Email</label>
                        <input data-validate="1" data-validate-pattern="\w+@\w+(\.\w+){1,3}" data-validate-message="must be a valide email" type="email" class="form-control <?= isset($user_error)?'border-danger border':'' ?> " value="<?= $_POST[DBContract::$Users_Col_Email]??$GLOBALS[DBContract::$Users_RememberMe_Email]??'' ?>" id="<?= DBContract::$Users_Col_Email ?>" name="<?= DBContract::$Users_Col_Email ?>" placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <label for="<?= DBContract::$Users_Password ?>">Password</label>
                        <input  data-validate='1' data-validate-pattern='.{8,}' data-validate-message="must contain at least eight charachters" type="password" class="<?= isset($user_error)?'border-danger border':'' ?> form-control" value="<?= $_POST[DBContract::$Users_Password]??$GLOBALS[DBContract::$Users_RememberMe_Pass]??'' ?>" name="<?= DBContract::$Users_Password ?>" id="<?= DBContract::$Users_Password ?>" placeholder="Enter your password">
                    </div>
                    <div class="form-check">
                        <label for="<?= AccountManager::IS_ADMIN_KEY ?>" class="form-check-label">Admin</label>
                        <input type="checkbox"   <?= (isset($_POST[AccountManager::IS_ADMIN_KEY]) OR $GLOBALS[AccountManager::IS_ADMIN_KEY]) ?'checked':'' ?> class="form-check-input" <?= isset($_POST[ AccountManager::IS_ADMIN_KEY ]) OR isset($GLOBALS[ AccountManager::IS_ADMIN_KEY ]) ? 'checked':'' ?> id="<?=  AccountManager::IS_ADMIN_KEY  ?>" name="<?= AccountManager::IS_ADMIN_KEY ?>" >
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
<script src="js/validator.js"></script>
<script type="text/javascript">
    const callback=(form)=>{
        form.submit();
    }
    bindFormValidator(callback);

</script>
<?php include 'footer.php'?></body>
</html>
