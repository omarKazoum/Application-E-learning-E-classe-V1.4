<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<main class="container-fluid">
    <div class="row">
        <?php include_once 'sidebar.php';?>
        <div class="col content">
            <?php include_once 'header.php';?>
            <div class="main-content row p-2 d-flex align-items-center">
                <article class="col-12 col-md-6 col-lg-3 pb-1">
                    <div class="card">
                        <div class="card-body d-flex flex-column card-students">
                            <img src="images/ic-big-students.svg" alt="" class="card-image w-50">
                            <p class="card-text">
                                Students
                            </p>
                            <h2 class="card-title align-self-end h1">
                                243
                            </h2>
                        </div>
                    </div>
                </article>
                <article class="col-12 col-md-6 col-lg-3 pb-1">
                    <div class="card">
                        <div class="card-body d-flex flex-column card-course">
                            <img src="images/ic-big-course.svg" alt="" class="card-image w-50">
                            <p class="card-text">
                                Course
                            </p>
                            <h2 class="card-title align-self-end h1">
                                13
                            </h2>
                        </div>
                    </div>
                </article>
                <article class="col-12 col-md-6 col-lg-3 pb-1">
                    <div class="card">
                        <div class="card-body d-flex flex-column card-payments">
                            <img src="images/ic-big-payments.svg" alt="" class="card-image w-50">
                            <p class="card-text">
                                Payments
                            </p>
                            <h2 class="card-title align-self-end h1">
                                DHS 556,000
                            </h2>
                        </div>
                    </div>
                </article>
                <article class="col-12 col-md-6 col-lg-3 pb-1">
                    <div class="card">
                        <div class="card-body d-flex flex-column card-users">
                            <img src="images/ic-big-users.svg" alt="" class="card-image w-50">
                            <p class="card-text" style="color:white">
                                Users
                            </p>
                            <h2 class="card-title align-self-end h1">
                                3
                            </h2>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'?>
</body>
</html>