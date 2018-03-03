# Configuração mínima para novos projetos em PHP

## Configurar o composer


## Instalar dependências do composer
	`composer install`

## Instalar pacotes NPM
Obs: é possível que seja necessário instalar o pacote **rub-compass** para utilizar o `grunt-contrib-sass` (`sudo apt-get install ruby-compass`)
```
npm install
npm install grunt-cli -g
npm install grunt grunt-contrib-clean grunt-contrib-watch grunt-contrib-copy grunt-rework grunt-browserify grunt-contrib-sass \
grunt-contrib-uglify grunt-php grunt-newer grunt-browser-sync --save-dev
```

## Gerar o conjunto de favicons em http://realfavicongenerator.net/

## Criar um arquivo de configuração local **app/config/config.local.php**
Ex:
```php
<?php
putenv('MODE=dev');

// Database
putenv('DB_HOST=localhost');
putenv('DB_NAME=phpstart');
putenv('DB_USER=root');
putenv('DB_PASS=root');
putenv('DB_CHARSET=utf8mb4');

putenv("PROJECT_ID=phpstart");
putenv("PROJECT_NAME=PhpStart");
putenv("GOOGLE_ANALYTICS_ID=");

// Facebook
putenv("FACEBOOK_APP_ID=");
putenv("FACEBOOK_APP_SECRET=");
putenv("FACEBOOK_API_VERSION=");

// Layout
putenv('META_KEYWORDS=Php, composer, grunt, npm, projeto inicial');
putenv('META_AUTHOR=');
putenv('META_DESCRIPTION=Projeto Inicial');
putenv('META_PHOTO=/img/phpstart.png');
putenv('META_NAME=Php Start');

putenv('TITLE=PhpStart');

putenv('BLACK_LISTED_IPS=179.108.');// para email
putenv("SMTP_SERVER=mail2.incluirtecnologia.com.br");
putenv("SMTP_PORT=587");
putenv("EMAIL=contato@incluirtecnologia.com.br");
putenv("EMAIL_FROM=contato@incluirtecnologia.com.br");
putenv("EMAIL_BCC_EMAIL=contato@incluirtecnologia.com.br");
putenv("EMAIL_PASS=intec700");
putenv("EMAIL_NAME=PhpStart");
putenv("EMAIL_BCC_NAME=PhpStart");
putenv("EMAIL_SUBJECT_PREFIX=[PhpStart]");
putenv("SMTP_SSL=tls");

// para email
putenv("SMTP_SERVER=mail2.incluirtecnologia.com.br");
putenv("SMTP_PORT=587");
putenv("EMAIL=contato@incluirtecnologia.com.br");
putenv("EMAIL_FROM=contato@incluirtecnologia.com.br");
putenv("EMAIL_BCC_EMAIL=contato@incluirtecnologia.com.br");
putenv("EMAIL_PASS=intec700");
putenv("EMAIL_NAME=PhpStart");
putenv("EMAIL_BCC_NAME=PhpStart");
putenv("EMAIL_SUBJECT_PREFIX=[PhpStart]");
putenv("SMTP_SSL=tls");

```

# Bibliotecas base
 - [x] Bootstrap
 - [x] Moment
 - [x] FontAwesome
 - [x] Entypo Plus
 - [x] Mask

# Como desenvolver
  - Abra o terminal na pasta raiz e digite `grunt dev`

# Deploy
    - `grunt build`
