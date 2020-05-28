<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
        <?php
        foreach ($css as $file) {
            echo "\n";
            echo '<link href="' . $file . '?v=0.0.1" rel="stylesheet" type="text/css" />';
        } echo "\n";
        ?>
    </head>

    <body class="x-hidden">
        <div id="loading">
            <div class="ripple ripple1"></div>
            <div class="ripple ripple2"></div>
            <div class="ripple ripple3"></div>
            <div class="ripple ripple4"></div>
        </div>
        <header class="navbar">
            <div class="container-fluid">
                <a href="#" class="logo">
                </a>
            </div>
        </header>
        <main class="content">
            <?php echo "$output"; ?>
        </main>
        <?php
        foreach ($js as $file) {
            echo "\n    ";
            echo '<script src="' . $file . '?v=0.0.1"></script>';
        } echo "\n"
        ?>
    </body>

</html>