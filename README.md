# Configuração mínima para novos projetos em PHP

## Instalar o Docker e Docker Compose

- Docker (CE): https://docs.docker.com/install/linux/docker-ce/ubuntu/
- Docker Compose: https://docs.docker.com/compose/install/

## Execução com o docker

**IMPORTANTE**: Ao utilizar esse método, remova as pastas `vendor` e `node_modules`, `public/{img,css,js,pjs,fonts}` e os arquivos `composer.lock` e `package-lock.json` se existirem.

- Criar arquivo .env com os valores adequados. Ex:
```sh
# .docker/.env
MYSQL_DATABASE=phpstart
MYSQL_USER=phpstartadmin
MYSQL_PASSWORD=admin
MYSQL_ROOT_PASSWORD=root
```

- Construir e executar o container: `docker-compose up`
- Executar ambiente de desenvolvimento: `docker-compose run node npm run dev`

**Importante**: Como o BrowserSync é executado dentro de um container node, só é possível utilizar a url de acesso externa para desenvolvimento. O navagador não é aberto automaticamente.

- Executar ambiente de teste: `docker-compose run node npm run test`

Acesso de linha de comando para mysql, beanstalk e redis
- `mysql -u root -p --port=13306` # mysql
- `telnet localhost 16379` # redis
- `telnet localhost 21300` # beanstalkd

## Execução sem o docker (descontinuado)

**IMPORTANTE**: Ao utilizar esse método, remova as pastas `vendor` e `node_modules`, `public/{img,css,js,pjs,fonts}` e os arquivos `composer.lock` e `package-lock.json` se existirem.

Crie um o arquivo settings.local.php em config e crie também o usuário e banco de dados.
```php
<?php

return [
    'display_errors' => true,
    'db' => [
        'host' => 'localhost',
        'db_name' => 'phpstart',
        'db_user' => 'phpstart_admin',
        'db_pass' => 'admin',
        'charset' => 'utf8mb4'
    ],
    'redis' => [
        'host' => 'localhost',
        'port' => 6379
    ],
    'session' => [
        'cookie_name' => 'app_ssid',
        'cookie_expires' => 1800 // 30 min
    ],
];

```

- Dependências de sistema:
php7.1 ou maior, mysql-server, redis-server, php-mysql, php-dom, php-mbstring, php-xml, php-redis.

- Dependências de projeto:

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

**Importante**: Para evitar problemas de caching em navegadores, durante o desenvolvimento, recomenda-se desativar o cache na janela de debug (rede) do navegador.

Acessar o container em execução: `docker exec -it emailprovider-php-fpm /bin/sh`

Banco de dados
```sql
CREATE TABLE `virtual_aliases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) NOT NULL,
  `source` varchar(100) NOT NULL,
  `destination` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `domain_id` (`domain_id`),
  CONSTRAINT `virtual_aliases_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `virtual_domains` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `virtual_domains` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

CREATE TABLE `virtual_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_id` int(11) NOT NULL,
  `password` varchar(106) NOT NULL,
  `email` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `domain_id` (`domain_id`),
  CONSTRAINT `virtual_users_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `virtual_domains` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
```

php vendor/bin/doctrine orm:convert-mapping --force --from-database annotation ./src/Entity/