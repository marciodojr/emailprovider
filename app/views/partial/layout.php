<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="keywords" content="<?php echo $this->metaKeywords; ?>"/>
        <meta name="description" content="<?php echo $this->metaDescription; ?>"/>
        <meta name="author" content="<?php echo $this->metaAuthor; ?>">

        <!-- Facebook -->
        <meta prefix="og: http://ogp.me/ns#" property="og:title" content="<?php echo $this->metaOgDataArray['name']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:image:width" content="450"/>
        <meta prefix="og: http://ogp.me/ns#" property="og:image:height" content="300"/>
        <meta prefix="og: http://ogp.me/ns#" property="og:image" content="<?php echo $this->metaOgDataArray['photo_url']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:url" content="<?php echo $this->metaOgDataArray['url']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:site_name" content="<?php echo $this->metaOgDataArray['name']; ?>"/>
        <meta prefix="og: http://ogp.me/ns#" property="og:description" content="<?php echo $this->metaOgDataArray['description']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:type" content="website"/>

        <!-- Twitter -->
        <meta name="twitter:card" content="<?php echo $this->metaOgDataArray['description']; ?>">
        <meta name="twitter:url" content="<?php echo $this->metaOgDataArray['url']; ?>">
        <meta name="twitter:title" content="<?php echo $this->metaOgDataArray['name']; ?>">
        <meta name="twitter:description" content="<?php echo $this->metaOgDataArray['description']; ?>">
        <meta name="twitter:image" content="<?php echo $this->metaOgDataArray['photo_url']; ?>">

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="theme-color" content="#ffffff">

        <link type="text/css" rel="stylesheet" href="/css/app.min.css" />
        <?php foreach ($this->stylesheets as $href): ?>
            <link href="<?php echo $href; ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>

        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab|PT+Sans|Fira+Mono" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js" integrity="sha384-0s5Pv64cNZJieYFkXYOTId2HMA2Lfb6q2nAcx2n0RTLUnCAoTTsS0nKEO27XyKcY" crossorigin="anonymous"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js" integrity="sha384-ZoaMbDF+4LeFxg6WdScQ9nnR1QC2MIRxA1O9KWEXQwns1G8UNyIEZIQidzb0T1fo" crossorigin="anonymous"></script>
        <![endif]-->

    </head>
    <body id="page-top" class="index">

                <!-- Navigation -->
                <nav id="mainNav" class="navbar navbar-custom navbar-fixed-top">
                    <div class="container">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header page-scroll">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand page-scroll" href="#page-top">PHP Start</a>
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="hidden">
                                    <a href="#page-top"></a>
                                </li>
                                <li>
                                    <a class="page-scroll" href="/components">Componentes</a>
                                </li>
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
                            <div class="intro-lead-in">Welcome To Our Studio!</div>
                            <div class="intro-heading">It's Nice To Meet You</div>
                            <a href="#services" class="page-scroll btn btn-primary btn-lg">Tell Me More</a>
                        </div>
                    </div>
                </header>
        <?php
        if(is_array($resp)) extract($resp);
        require_once 'app/views/template/' . $page . '.php';
        ?>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <span class="copyright">Copyright &copy; Your Website 2016</span>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline quicklinks">
                            <li><a href="#">Privacy Policy</a>
                            </li>
                            <li><a href="#">Terms of Use</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <div id="ajaxFormAlert" class="alert alert-feedback-fixed">
            <button type="button" class="close" id="alert-close" data-toggle="alert"><span class="icon-cross"></span></button>
            <h4> <span class="icon-warning"></span> Oops!</h4>
            <p id="alertFeedbackText">Parece que algo deu errado. Não se preocupe, te ajudaremos a encontrar o caminho <span class="icon-emoji-flirt"></span>.</p>
        </div>

        <script type='text/javascript' src="/js/app.min.js"></script>
        <?php foreach ($this->scripts as $path): ?>
            <script type='text/javascript' src="<?php echo $path; ?>"></script>
        <?php endforeach; ?>

        <?php if(IntecPhp\Model\Config::$GOOGLE_ANALYTICS_ID): ?>
            <script>
              (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
              (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
              })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
              ga('create', '<?php echo IntecPhp\Model\Config::$GOOGLE_ANALYTICS_ID; ?>', 'auto');
              ga('send', 'pageview');
            </script>
        <?php endif; ?>
    </body>
</html>
