<?php
require_once 'include/utils.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payments</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/payments.css">
</head>
<body>
<main class="container-fluid bg-gray">
    <div class="row">
        <?php include 'sidebar.php';?>
        <div class="col content">
            <?php include 'header.php';?>
            <div class="main-content row p-2 d-flex align-items-center">
                <div class="col-12 main-content-toolbar d-flex pb-2 justify-content-between align-items-center border-bottom-light">
                    <h1 class="h4 fw-bold">Payment Details</h1>
                    <div class="toolbar-left-part">
                        <a class="sort ic ic-sort btn btn-sort" title="sort button"></a>
                    </div>
                </div>
            </div>
            <div class="table-header d-none d-lg-flex row mb-2 ps-2">
                <span class="col-1 text-start ps-3">
                    Name
                </span>
                <span class="col-2 text-start">
                    Payment Schedule
                </span>
                <span class="col-2 text-start">
                    Bill Number
                </span>
                <span class="col-2 text-start">
                   Amount Paid
                </span>
                <span class="col-2 text-start">
                    Balance amount
                </span>
                <span class="col-2 text-start">
                    Date
                </span>
            </div>
            <div class="col-12 cards">
                <?php
                    // let's fill the array with the payments data
                    $payments=getPaymentsData();
                    // now let's print the data
                    foreach($payments as $payment){
                ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body row d-flex flex-column flex-lg-row">
                            <span class="col-lg-1 text-start">
                                <?php echo $payment['name'];?>
                            </span>
                            <span class="col-lg-2 text-start">
                               <?php echo $payment['paymentSchudule'];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo $payment['billNumber'];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo 'DHS '.$payment['amountPaid'];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                <?php echo 'DHS '.$payment['balanceAmount'];?>
                            </span>
                            <span class="col-lg-2 text-start">
                                 <?php echo $payment['date'];?>
                            </span>
                            <span class="col-lg-1 btns">
                                <a class="ic ic-eye btn btn-details" title="details button">
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'?>
</body>
</html>