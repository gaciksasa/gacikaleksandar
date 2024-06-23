<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!doctype html>
<html lang="sr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard - Gacik Aleksandar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" type="../image/x-icon" href="../images/favicon.png">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/fontawesome.css">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include Navigation -->
            <?php include 'navigation.php'; ?>

            <!-- Main Content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                <div id="main-content">
                    <!-- Add your main content here -->
                    <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
                    <p>Select an option from the sidebar to manage your content.</p>
                </div>
            </main>
            <!-- Main Content End -->
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#sidebar .nav-link').on('click', function() {
                var $el = $(this);
                var $collapse = $el.next('.collapse');
                if ($collapse.length) {
                    $collapse.collapse('toggle');
                }
            });
        });
    </script>
</body>

</html>