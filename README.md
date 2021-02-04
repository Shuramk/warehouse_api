
Installation
------------
```shell
git clone
docker-compose up -d --build
```

```shell
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:migrations:migrate -n
docker-compose exec php php bin/console doctrine:fixtures:load -n
```

Check
------------
`New user:`
POST http://localhost:8000/api/register?name=ВасилийКузьмич&username=test1&password=test1

`Get token:`
POST http://localhost/api/login_check
_{
"username": "Test",
"password": "testtest"
}_

`Swagger:`
http://localhost:8000/api/docs

`graphiql:`
http://127.0.0.1:8000/api/docs/graphiql

`/graphql_playground:`
http://127.0.0.1:8000/api/docs/graphql_playground





