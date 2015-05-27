Invoice
=======

Invoice storing application writen in old good legacy php :P

Development enviroment (docker)
======================

Project using (docker-compose)[1].

You need to install docker-compose and docker run such commands to setup dev env:

```bash
sudo docker-compose build
sudo docker-compose up -d
sudo docker exec -i -t legacyinvoice_web_1 bash # name generated base on main project dir name run docker ps -a to check your name
```

[1]: https://docs.docker.com/compose/install/
