# Configuração mínima para novos projetos em PHP

## Configurar o composer


## Instalar dependências do composer
	`composer install`

## Instalar pacotes NPM
Obs: é possível que seja necessário instalar o pacote **rub-compass** para utilizar o `grunt-contrib-sass` (`sudo apt-get install ruby-compass`)
```
npm install
npm install grunt-cli -g
npm install grunt grunt-contrib-clean grunt-contrib-watch grunt-contrib-copy grunt-rework grunt-browserify grunt-contrib-sass grunt-contrib-uglify grunt-php \
grunt-browser-sync --save-dev
```

## Criar um arquivo de configuração local **app/config/config.local.php**
Ex:
```.php
<?php
putenv('MODE=DEV');
putenv('DB_HOST=localhost');
putenv('DB_NAME=phpstart');
putenv('DB_USER=root');
putenv('DB_PASS=root');
putenv('DB_CHARSET=utf8');
```
# Bibliotecas base
 - [x] Bootstrap
 - [x] Moment
 - [x] FontAwesome
 - [x] Entypo Plus
 - [] Mask

# Como desenvolver
  - Abra o terminal na pasta raiz e digite `grunt dev`
