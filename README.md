# psr7framework
Create test project with PSR-7 statndart - request, response, middleware.

### Using docker with environment

Build docker container for initialize project:

```shell
docker-compose build
```
Run docker container in background mode:
```shell
docker-compose up -d
```
Install php dependencies by composer:
```shell
docker-compose exec -u dev php composer install
```
application available at **http://localhost**

Routes available in test application define in file
`public/index.php:26`


---


In container define user name **dev** use it in all commands 😎

Enter to php container with **bash** shell:
```shell
docker-compose exec -u dev php bash
```

Run Phpunit test in docker container:
```shell
docker-compose exec -u dev php vendor/bin/phpunit
```
