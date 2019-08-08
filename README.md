## TEST DESENVOLVEDOR WEB

### Arquivo .env

- <b>Renomear o arquivo .env-example para .env</b>
- <b>Checar a conexão com o banco de dados.</b>
- <b>Usuario: postgres</b>
- <b>Password: docker</b>

### Rodar o docker compose

- <b>docker-compose up -d</b>

### Instalar os pacotes do php

- <b>docker exec -it php-srv composer install</b>

### Rodar a migration para criar a tabela no banco

- <b>docker exec -it php-srv vendor/bin/phinx migrate</b>

### Rodar os seeds para alimentar a tabela com dados fake

- <b>docker exec -it php-srv vendor/bin/phinx seed:run</b>

### Acessar o sistema pela url http://localhost:1234

---

Obs: Caso queira zerar a tabela roda o comando abaixo.

### Excluir a tabela do banco de dados.

- <b>docker exec -it php-srv vendor/bin/phinx rollback -t 0</b>

### Comando para parar o servidor docker

- <b>docker-compose down</b>

### Comando para excluir um container docker (forçado)

- <b>docker rm -f [ID_CONTAINER]</b>

### Comando para excluir uma imagem docker (forçado)

- <b>docker rmi -f [ID_IMAGE]</b>
