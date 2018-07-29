## Execução

- Executar os comandos abaixo
```
git clone https://github.com/marciodojr/emailprovider && cd emailprovider
docker-compose up
```

- criar o banco de dados:
```sh
docker exec -it emailprovider sh
php vendor/bin/doctrine orm:schema-tool:create
exit
```

- Importar dados para o banco:
```sh
docker exec -it emailprovider-mysql sh
mysql -u servermailadmin -p servermail <data/database/populate.sql
# utilize a senha 'admin'
exit;
```

## Usuário de acesso
- usuário: admin
- senha: 123456789

## Comandos úteis
- Acessar um container em execução: `docker exec -it <container-name> sh`
- Gerar entidades a partir do banco de dados: `php vendor/bin/doctrine orm:convert-mapping --force --from-database annotation ./src/Entity/`