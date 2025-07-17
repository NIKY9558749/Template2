<?php
session_start();
if (empty($_SESSION['logged_in'])) {
    header('Location: index.php');
    exit;
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/logo.png" type="image/png">

    <title>Profile - LearnTogether</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body id="top section_1">

    <?php include("includes/navbar.php"); ?>

    <main>
        <section id="section_1" class="section-padding section-bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-12 mx-auto">

                        <div class="custom-text-box text-center">
                            <img src="images/avatar/portrait-beautiful-young-woman-standing-grey-wall.jpg" class="avatar-image mb-3" alt="User Avatar">
                            <h2 class="mb-2">Hi, <?php echo htmlspecialchars($_SESSION['user_email']); ?>!</h2>
                            <p class="mb-4">Welcome to your personal area. Here you can manage your data, view your tutoring requests, and update your information.</p>
                            
                            <ul class="custom-list mt-2 mb-4 text-start d-inline-block">
                                <li class="custom-list-item d-flex">
                                    <i class="bi-person custom-text-box-icon me-2"></i>
                                    Name: Mario Rossi
                                </li>
                                <li class="custom-list-item d-flex">
                                    <i class="bi-envelope custom-text-box-icon me-2"></i>
                                    Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?>
                                </li>
                                <li class="custom-list-item d-flex">
                                    <i class="bi-book custom-text-box-icon me-2"></i>
                                    Role: Student
                                </li>
                            </ul>
                            <a href="logout.php" class="custom-btn btn mt-3">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include("includes/footer.php"); ?>
    <script src="js/click-scroll.js"></script>

</body>

</html>