<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $this->title; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="keywords" content="<?php echo $this->metaKeywords; ?>"/>
        <meta name="description" content="<?php echo $this->metaDescription; ?>"/>

        <!-- Facebook -->
        <meta prefix="og: http://ogp.me/ns#" property="og:title" content="<?php echo $this->metaOgDataArray['name']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:image:width" content="450"/>
        <meta prefix="og: http://ogp.me/ns#" property="og:image:height" content="300"/>
        <meta prefix="og: http://ogp.me/ns#" property="og:image" content="<?php echo $this->metaOgDataArray['photo_url']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:url" content="<?php echo $this->metaOgDataArray['url']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:site_name" content="LibrasSAC"/>
        <meta prefix="og: http://ogp.me/ns#" property="og:description" content="<?php echo $this->metaOgDataArray['description']; ?>" />
        <meta prefix="og: http://ogp.me/ns#" property="og:type" content="website"/>

        <?php foreach ($this->stylesheets as $href): ?>
            <link href="<?php echo $href; ?>" rel="stylesheet" type="text/css">
        <?php endforeach; ?>
    </head>
    <body>
        <header class="header">
            <p>Header</p>
        </header>
        <main>
            <?php
            if(is_array($resp)) {
                extract($resp);
            }
            include_once 'app/views/template/' . $page . '.php';
            ?>
        </main>
        <footer class="footer">
            <p>Footer</p>
        </footer>
        <?php foreach ($this->scripts as $path): ?>
            <script type='text/javascript' src="<?php echo $path; ?>"></script>
        <?php endforeach; ?>
    </body>
</html>
