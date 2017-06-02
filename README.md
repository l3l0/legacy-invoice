Invoice example system
=======

Invoice storing application writen in old good legacy php :P
Just to show how we can refactor legacy app.

Development environment (docker)
======================

Project using (docker-compose)[1].

You need to install docker-compose and docker run such commands to setup dev env:

```bash
sudo docker-compose build
sudo docker-compose up -d
sudo docker-compose run web bash
```

Then please run composer install on docker

Tests
======================

Project using (phpspec)[2].

After composer installation you can run tests using such commands

```bash
# Unit tests
php bin/phpspec run
# Integration tests
php bin/phpunit
```

[1]: https://docs.docker.com/compose/install/
[1]: https://phpspec.net
