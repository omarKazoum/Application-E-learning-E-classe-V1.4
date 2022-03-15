<?php
require_once 'include/DBContract.php';
require_once 'include/AccountManager.php';
require_once 'include/DBManager.php';
require_once 'include/InputValidator.php';
require_once 'include/utils.php';
$am=AccountManager::getInstance();
$db_manager=DBManager::getInstance();
//processing submitted data
//TODO:: validate emails and passwords match with their second attempt plus that they meet the criteria
if (    AreAllStudentSignUpFieldsSet()
        AND InputValidator::validateEmailsMatch($_POST[DBContract::$Students_Col_Email],$_POST[DBContract::$Students_Col_Email2])
        AND InputValidator::validatePasswordsMatch($_POST[DBContract::$Students_Col_Password],$_POST[DBContract::$Students_Col_Password2])
        AND InputValidator::validatePhone($_POST[DBContract::$Students_Col_Phone])
    ) {
            $path=upload_profile_image();
            $db_manager->insertStudent(array(
                DBContract::$Students_Col_Name=>$_POST[DBContract::$Students_Col_Name],
                DBContract::$Students_Col_Image=>empty($path) ?'':$path,
                DBContract::$Students_Col_Email=>$_POST[DBContract::$Students_Col_Email],
                DBContract::$Students_Col_Phone=>$_POST[DBContract::$Students_Col_Phone],
                DBContract::$Students_Col_EnrollNbr=>uniqid(),
                DBContract::$Students_Col_DateAdmission=>date('Y-m-d'),
                DBContract::$Students_Col_PasswordHash=>password_hash($_POST[DBContract::$Students_Col_Password],PASSWORD_DEFAULT)
            ));
            redirectWithMessage('index.php',MESSAGE_TYPE_SUCCESS,'Account createed succesfully.</br>please login to use your account');
    } else{
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
                        Fill this form to create a student account
                    </p>
                    <form action="student_signup.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="<?= DBContract::$Students_Col_Name ?>">Full Name*</label>
                            <input
                                    data-validate="1" data-validate-pattern="^\w+( \w+)+$" data-validate-message="you must submit your first and last name"
                                    type="text" class="form-control value="<?= $_POST[DBContract::$Students_Col_Name]??'' ?>" id="<?= DBContract::$Students_Col_Name ?>" name="<?= DBContract::$Students_Col_Name ?>" placeholder="Enter your User name ">
                        </div>
                        <div class="form-group">
                            <label for="<?= DBContract::$Students_Col_Email ?>">Email*</label>
                            <?php if(InputValidator::error(InputValidator::EMAIL_ERROR_KEY)){?>
                                <div class="error">
                                    <?= InputValidator::error(InputValidator::EMAIL_ERROR_KEY) ?>
                                </div>
                            <?php }?>
                            <input type="email"
                                   class="form-control <?= InputValidator::error(InputValidator::EMAIL_ERROR_KEY)?'border-danger border':'' ?> "
                                   value="<?= $_POST[DBContract::$Students_Col_Email]??'' ?>"
                                   id="<?= DBContract::$Students_Col_Email ?>"
                                   name="<?= DBContract::$Students_Col_Email ?>"
                                   data-validate="1"
                                   data-validate-pattern="\w+@\w+(\.\w+){1,3}"
                                   data-validate-message="must be a valid email"
                                   placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <label for="<?= DBContract::$Students_Col_Email2 ?>">Repeat Email*</label>

                            <input type="email"
                                   class="form-control <?= InputValidator::error(InputValidator::EMAIL_ERROR_KEY)?'border-danger border':'' ?> "
                                   id="<?= DBContract::$Students_Col_Email2 ?>"
                                   name="<?= DBContract::$Students_Col_Email2 ?>"
                                   value="<?= $_POST[DBContract::$Students_Col_Email2]??'' ?>"
                                   data-validate-match="<?= DBContract::$Students_Col_Email ?>"
                                   data-validate="1" data-validate-pattern="\w+@\w+(\.\w+){1,3}" data-validate-message="emails must match"
                                   placeholder="Enter your email one more time">
                        </div>
                        <div class="form-group">
                            <label for="<?= DBContract::$Students_Col_Image;?>">Profile image:</label>
                            <input type="file"
                                   placeholder="JPG/PNG"
                                   class="form-control-file"
                                   name="<?= DBContract::$Students_Col_Image ?>"
                            >
                        </div>
                        <div class="form-group justify-content-between">
                            <label for="<?= DBContract::$Students_Col_Phone ;?>">Student Phone Number</label>
                            <?php if(InputValidator::error(InputValidator::PHONE_ERROR_KEY)){?>
                                <div class="error">
                                    <?= InputValidator::error(InputValidator::PHONE_ERROR_KEY) ?>
                                </div>
                            <?php }?>
                            <input type="phone" class="form-control" name="<?= DBContract::$Students_Col_Phone ;?>"
                                   data-validate="1"
                                   data-validate-pattern="<?= str_replace( "/", "",InputValidator::PHONE_PATTERN)  ?>"
                                   data-validate-message="Invalide phone number"
                            >
                        </div>
                        <div class="form-group">
                            <label for="<?= DBContract::$Students_Col_Password ?>">Password*</label>
                            <?php if(InputValidator::error(InputValidator::PASSWORD_ERROR_KEY)){?>
                                <div class="error">
                                    <?= InputValidator::error(InputValidator::PASSWORD_ERROR_KEY) ?>
                                </div>
                            <?php }?>
                            <input type="password"
                                   class="<?= InputValidator::error(InputValidator::PASSWORD_ERROR_KEY)?'border-danger border':'' ?> form-control"
                                   value="<?= $_POST[DBContract::$Students_Col_Password]??'' ?>"
                                   name="<?= DBContract::$Students_Col_Password ?>"
                                   id="<?= DBContract::$Students_Col_Password ?>"
                                   placeholder="Enter your password"
                                   data-validate="1"
                                   data-validate-pattern="<?= str_replace( "/", "",InputValidator::PASSWORD_PATTERN)  ?>"
                                   data-validate-message="Password must contain at least 8 charachters"
                            >
                        </div>
                        <div class="form-group">
                            <label for="<?= DBContract::$Students_Col_Password2 ?>">Repeat Password*</label>
                            <input type="password"
                                   class="<?= InputValidator::error(InputValidator::PASSWORD_ERROR_KEY)?'border-danger border':'' ?> form-control"
                                   value="<?= $_POST[DBContract::$Students_Col_Password2]??'' ?>"
                                   name="<?= DBContract::$Students_Col_Password2 ?>"
                                   id="<?= DBContract::$Students_Col_Password2 ?>"
                                   placeholder="Tap your password again"
                                   data-validate="1"
                                   data-validate-match="<?= DBContract::$Students_Col_Password ?>"
                                   data-validate-pattern="<?= str_replace( "/", "",InputValidator::PASSWORD_PATTERN)  ?>"
                                   data-validate-message="passwords must match"
                            >
                        </div>
                        <input type="submit" class="form-control btn bg-primary text-light py-2" value="SIGN UP">
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
<script src="js/validator.js"></script>
<script type="text/javascript">
    bindFormValidator();
</script>
<?php include 'footer.php'?></body>
</html>
<?php }?>


