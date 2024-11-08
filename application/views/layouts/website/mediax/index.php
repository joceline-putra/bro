<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php $title = isset($title) ? $title : "Welcome"; echo $title; ?></title>

    <meta name="keywords" content="<?php echo strip_tags($keywords); ?>"/>
    <meta name="description" content="<?php echo strip_tags($description); ?>">
    <meta name="author" content="<?php echo strip_tags($author); ?>">
    <meta name="robots" content="INDEX,FOLLOW">

    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $asset; ?>assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $asset; ?>assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $asset; ?>assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $asset; ?>assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $asset; ?>assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $asset; ?>assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $asset; ?>assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&amp;family=Outfit:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <?php include 'link_css.php'; ?>
    <script src="<?php echo $asset; ?>assets/js/jquery-2.1.4.min.js"></script>
</head>
<body>
    <?php 
    include "header.php"; 
    if (!empty($_content)) {
        $this->load->view($_content);
    }
    if (!empty($_js)) {
        $this->load->view($_js);
    }
    include "footer.php";    
    include 'link_js.php';       
    ?>    
    <div class="scroll-top"><svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path></svg></div>
    <?php   
    // if (!empty($_js)) {
    //     $this->load->view($_js);
    // }
    ?>   
</body>

</html>