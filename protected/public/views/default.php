<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo "{$title}"; ?></title>
    <?php
    foreach ($css as $file) {
        echo "\n";
        echo '<link href="' . $file . '?v=0.0.2" rel="stylesheet" type="text/css" />';
    }
    echo "\n";
    ?>
    <script type="text/javascript" src="<?php echo site_url('assets/js/language/' . settings('language') . '.js'); ?>"></script>
    <script type="text/javascript">
        var site_url = '<?php echo site_url(); ?>';
        var current_url = '<?php echo current_url(); ?>';
    </script>
</head>

<body>

    <div class="page-content">
        <div class="content-wrapper">
            <?php echo $output; ?>
        </div>
    </div>
    <?php
    foreach ($js as $file) {
        echo "\n    ";
        echo '<script src="' . $file . '?v=0.0.1"></script>';
    }
    echo "\n"
    ?>
    <script>
        <?php
        if ($this->session->flashdata('form_response_status')) {
            echo $this->session->flashdata('form_response_status') . '_message("' . $this->session->flashdata('form_response_message') . '");';
        }
        ?>
    </script>
</body>

</html>