## Installation of the project on the local machine

1. Install Docker from here https://docs.docker.com/docker-for-mac/install/
2. Run from project directory language-courses next:

```sh
docker-compose build
docker-compose up -d
```  

3. Check that containers are available:

```sh
docker ps
``` 

You should see two containers something like this:

```
CONTAINER ID        IMAGE                               COMMAND                  CREATED             STATUS              PORTS                          NAMES
5b0aa93c39a6        language-courseslocal_admin-panel   "sh /var/www/courses…"   About an hour ago   Up About an hour    0.0.0.0:80->80/tcp, 9000/tcp   language-courseslocal_admin-panel_1
776b791b0d1d        mysql:5.7.22                        "docker-entrypoint.s…"   7 days ago          Up 5 hours          0.0.0.0:3306->3306/tcp         language-courseslocal_mysql_1
```

Please, to be sure that all were installed enter next:

```sh
docker logs -f language-courseslocal_admin-panel_1
```

There are should not errors and should be the last lines:

```
[26-May-2019 16:55:06] NOTICE: fpm is running, pid 316
[26-May-2019 16:55:06] NOTICE: ready to handle connections
```

If you see that above, please go to http://localhost

# Launching tests

4. To connect to the console of the container, please enter next:

```
docker exec -it language-courseslocal_admin-panel_1 /bin/bash
```

You must get to the directory /var/www, please enter:

```
cd courses
```

Launch the tests

```
vendor/bin/phpunit
```
