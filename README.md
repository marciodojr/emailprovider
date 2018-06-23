# Configuração mínima para novos projetos em PHP

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

## Com Docker



- Criar arquivo .env com os valores adequados. Ex:
```sh
# .docker/.env

MYSQL_DATABASE=phpstart
MYSQL_USER=root
MYSQL_PASSWORD=root
MYSQL_ROOT_PASSWORD=root
```

- Construir e executar o container:
    - `docker-compose up`
- Executar ambiente de desenvolvimento:
    - `docker-compose run node npm run dev`

**Importante**: Como o BrowserSync é executado dentro de um container node, só é possível utilizar a url de acesso externa para desenvolvimento.

- Executar ambiente de teste:
    - `docker-compose run node npm run test`
- Fazer a build do projeto (somente produção, experimental):
    - `docker-compose run node npm run build`


## Sem Docker

- Dependências:
```
composer install
npm install grunt-cli -g
npm install
```
- Executar ambiente de desenvolvimento:
    - `grunt dev`
- Executar ambiente de teste:
    - `grunt test`
- Fazer a build do projeto (somente produção):
    - `grunt build`