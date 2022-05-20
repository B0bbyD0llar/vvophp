<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>VVOphp API-Testing-GUI</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <!-- fontawsome -->
    <script defer src="js/fa6free/all.min.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="https://github.com/B0bbyD0llar/vvophp" target="_blank"><img src="img/logo.png" class="img-fluid" style="width: 24px;" alt="VVOphp"/> VVOphp v<?php echo \Composer\InstalledVersions::getPrettyVersion('bitartist/vvophp'); ?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><i class="fas fa-home"></i> start</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="find.php"><i class="fas fa-search"></i> find station</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="monitor.php"><i class="fas fa-desktop"></i> department monitor</a>
            </li>
        </ul>
    </div>
</nav>

<main role="main" class="container" style="padding: 5rem 1.5rem;">