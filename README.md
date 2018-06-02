# Configuração mínima para novos projetos em PHP

## Dependências
```
composer install
npm install grunt-cli -g
npm install
```

## Criar arquivo de settings local
```php
<?php

// app/config/settings.local.php

return [
    'display_errors' => true,
    'db' => [
        'host' => 'localhost',
        'db_name' => 'phpstart',
        'db_user' => 'root',
        'db_pass' => 'root',
    ],
];
```

## Gerar o conjunto de favicons em http://realfavicongenerator.net/

## Dev
```
grunt dev
```

## Test
```
grunt test
```

## Build

### Criar arquivo .env com os valores adequados. Ex:
```sh
# .docker/.env

MYSQL_DATABASE=phpstart
MYSQL_USER=root
MYSQL_PASSWORD=root
MYSQL_ROOT_PASSWORD=root
```
### Rodar os comandos de processamento dos *assets* e construção da imagem
```
grunt build
docker-compose build
```