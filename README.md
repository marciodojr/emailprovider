## Execução

- Executar os comandos abaixo
```
git clone https://github.com/marciodojr/emailprovider && cd emailprovider
docker-compose up
```

## Usuário de acesso
- usuário: admin
- senha: 123456789

## Comandos úteis
- Acessar um container em execução: `docker exec -it <container-name> sh`
- Gerar entidades a partir do banco de dados: `php vendor/bin/doctrine orm:convert-mapping --force --from-database annotation ./src/Entity/`
- executar testes: `vendor/bin/phpunit --stop-on-failure --testdox --coverage-text`