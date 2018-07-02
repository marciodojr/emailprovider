# Configuração mínima para novos projetos em PHP

## Instalar o Docker e Docker Compose

- Docker (CE): https://docs.docker.com/install/linux/docker-ce/ubuntu/
- Docker Compose: https://docs.docker.com/compose/install/

## Execução com o docker

- Criar arquivo .env com os valores adequados. Ex:
```sh
# .docker/.env

MYSQL_DATABASE=phpstart
MYSQL_USER=phpstartadmin
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

## Execução sem o docker (descontinuado)

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

**Importante**: Para evitar problemas de caching em navegadores, durante o desenvolvimento, recomenda-se desativar o cache na janela de debug (rede) do navegador.
