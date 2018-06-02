<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php require_once 'app/views/partial/layout-header-config.php'; ?>
    <link type="text/css" rel="stylesheet" href="/css/app.min.css" />
    <?php foreach ($this->stylesheets as $href): ?>
    <link href="<?php echo $href; ?>" rel="stylesheet" type="text/css">
    <?php endforeach; ?>

    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab|PT+Sans|Fira+Mono" rel="stylesheet">
</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-custom navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="/">PHP Start</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="#services">Services</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <header>
        <div class="container">
            <div class="intro-text">
                <div class="intro-lead-in">Bem-vindo ao PhpStart</div>
                <div class="intro-heading">Acesse documentação</div>
                <a href="/docs" class="page-scroll btn btn-danger btn-lg">Documentação</a>
            </div>
        </div>
    </header>
    <?php require_once 'app/views/template/' . $page . '.php'; ?>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Your Website 2016</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <li>
                            <a href="#">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline quicklinks">
                        <li>
                            <a href="#">Privacy Policy</a>
                        </li>
                        <li>
                            <a href="#">Terms of Use</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script type='text/javascript' src="/js/app.min.js"></script>
    <?php foreach ($this->scripts as $path): ?>
        <script type='text/javascript' src="<?php echo $path; ?>"></script>
    <?php endforeach; ?>
</body>

</html>
