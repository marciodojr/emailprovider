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

## Teste
```
grunt test
```

## Deploy
```
grunt build
```
