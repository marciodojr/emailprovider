<!DOCTYPE html>
<html class="w-100 h-100">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php require_once 'views/partial/layout-header-config.php'; ?>
        <link type="text/css" rel="stylesheet" href="/css/app.min.css" />

        <?php foreach ($this->stylesheets as $href): ?>
            <link href="<?php echo $href; ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>

        <link href="https://fonts.googleapis.com/css?family=Ubuntu+Mono|Raleway:500" rel="stylesheet">
    </head>
    <body class="w-100 h-100 d-flex flex-column justify-content-between bg-light">
        <header class="pt-2">
            <div class="container">
                <p>Email Provider</p>
            </div>
        </header>
        <main class="d-flex justify-content-center">
            <?php require_once 'views/template/' . $page . '.php'; ?>
        </main>

        <footer class="pt-3 pb-5">
            <div class="container">
                <p class="small">© <?php echo (new \DateTime())->format('Y') ?> - Incluir Tecnologia LTDA ME.</p>
            </div>
        </footer>

        <script type='text/javascript' src="/js/app.min.js"></script>
        <?php foreach ($this->scripts as $path): ?>
        <script type='text/javascript' src="<?php echo $path; ?>"></script>
        <?php endforeach; ?>
    </body>
</html>
