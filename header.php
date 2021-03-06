<?php
/**
 *		header
 *		Name: Reynald Maala
 *		Date: March 30, 2022
 *		Description: The header for every page. */ 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">    
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <title>WEBD Project</title>
</head>
<body>
<header>
        <nav>
            <h1><a href="dashboard.php">Reynald Lawncare and Snow Removal</a></h1>
            <a href="create_request.php">Create Request</a>
            <a href="create_user.php">Register</a>
        </nav>
    </header>

    <script>
        if (<?= isset($_SESSION['id']) ?>) {
            if (<?= $_SESSION['admin'] ?>) {
            var userLink = document.createElement('a');
            userLink.innerHTML = "Users";
            userLink.href = "users.php";

            document.getElementsByTagName("nav")[0].appendChild(userLink);
            }
            if (typeof <?= $_SESSION['id']; ?> != 'undefined') {
                var userLink = document.createElement('a');
                userLink.innerHTML = "Logout";
                userLink.href = "logout.php";

                document.getElementsByTagName("nav")[0].appendChild(userLink);
            }
        }
    </script>

    <?php get_message(); ?>