# Teste Convenia

Desafio tecnico desenvolvido como parte do processo seletivo da Convenia.

## Como rodar o projeto

- Copiar o arquivo .env.example para .env
```console
cp .env.example .env
```

- Rodar o seguinte comando para instalar os containers Docker
```console
docker compose build
```

- Rodar o seguinte comando para instalar as dependencias do projeto
```console
docker compose run --rm composer install 
```

- Para iniciar os containers, rodar o seguinte comando
```console
docker compose up -d
```

- O seguinte comando para rodar as migrations
```console
docker exec --user $(id -u):$(id -g) -it laravel_php php artisan migrate
```

- Rodar o seguinte comando para gerar a chave do projeto
```console
docker exec --user $(id -u):$(id -g) -it laravel_php php artisan key:generate
```

- Rodar o seguinte comando para gerar as chaves de criptografia do Passport
```console
docker exec --user $(id -u):$(id -g) -it laravel_php php artisan passport:keys
```

## Acessar o projeto

Acessar o projeto localmente pelo link: http://localhost:80

## Usuários

Rodar o seguinte comando para criar os usuários de teste

```bash
docker exec --user $(id -u):$(id -g) -it laravel_php php artisan db:seed UserSeeder
```
Serão criados 2 usuários de teste

#### Usuário 1
- Email: test@gmail.com
- Senha: password

#### Usuário 2
- Email: test2@gmail.com
- Senha: password

Após rodar o seguinte comando para gerar as credenciais de passoword do Passport

```bash
docker exec --user $(id -u):$(id -g) -it laravel_php php artisan passport:client --password
```

Com as chaves criadas é so informar nos campos clientID e clientSecret do postmam


## Envio de emails

Para testar o envio de emais é necessario preencher as seguintes configurações no arquivo .env

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
```

## Testes

Para rodar os testes é necessario rodar o seguinte comando

```console
docker exec --user $(id -u):$(id -g) -it laravel_php php artisan test
```
