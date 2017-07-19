# Configuração mínima para novos projetos em PHP

## Configurar o composer


## Instalar dependências do composer
	`composer install`

## Instalar pacotes NPM
Obs: é possível que seja necessário instalar o pacote **rub-compass** para utilizar o `grunt-contrib-sass` (`sudo apt-get install ruby-compass`)
```
npm install
npm install grunt-cli -g
npm install grunt grunt-contrib-clean grunt-contrib-watch grunt-contrib-copy grunt-rework grunt-browserify grunt-contrib-sass grunt-contrib-uglify --save-dev
```

## Criar um arquivo de configuração local **config.local.php**
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
