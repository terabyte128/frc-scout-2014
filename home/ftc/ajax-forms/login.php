<?php require_once '../../includes/setup-session.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title> Team 7476 - Scouting </title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="ftc.css">
        <?php include '../../includes/headers.php'; ?>
    </head>
    <body>
        <h2 align="center"> FTC Scout App </h2>
        <p align="center"> You are logged in as <code> USERNAME </code> </p>
        <p align="center"> for team <code> TEAM_NUMBER </code> </p>
        <br> 
        <div class="container" align="center">
            <a class="btn btn-large btn-success full" type="button" href="scout_page_2_prematch.html" > Scout a Team </a>
            <br><br><a class="btn btn-large btn-primary full" type="button" href="scout_subpage_1_teamstats.html" > See Team Stats </a>
            <br><br><a class="btn btn-large btn-primary full" type="button" href="scout_subpage_2_matchresults.html"> See Match Results </a>
            <br><br><a class="btn btn-large btn-danger full" type="button" href="scout_subpage_3_logout.html"> Log Out </a>
        </div>

    </body>
</html>
