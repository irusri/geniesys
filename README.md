[Website](http://geniesys.org) | [Documentation](https://geniesys.gitbook.io) | [Demo](https://eucgenie.org) 
=======

[![DOI:10.1101/808881](https://zenodo.org/badge/DOI/10.1101/808881.svg)](https://doi.org/10.1101/808881)


Docker installation can be tested or run in several ways.

**1.\) Run using [Play with Docker](https://labs.play-with-docker.com/)**  
The quickest way to test the GenIE-Sys, it takes only a few minutes

[![Try in PWD](https://raw.githubusercontent.com/play-with-docker/stacks/master/assets/images/button.png)](https://labs.play-with-docker.com/?stack=https://raw.githubusercontent.com/irusri/docker4geniesys/master/pwd-stack.yml#)

**2.\) Run with [already built in Docker image](https://hub.docker.com/r/irusri/docker4geniesys)**                                                                          
The fastest way to run the GenIE-Sys locally or your own server
```text
docker run --rm -i -t -p "80:80" -p "3308:3306" -v ${PWD}/genie:/app -v ${PWD}/mysql:/var/lib/mysql -e MYSQL_ADMIN_PASS="mypass" --name geniesys irusri/docker4geniesys
```

**3.\) Build image locally using [Dockerfile](https://github.com/irusri/docker4geniesys) and run.**  
This is quite slow since you have to build the image locally

```text
git clone https://github.com/irusri/docker4geniesys.git  
cd docker4geniesys  
docker-compose up
```

You can access the MySQL database using `mysql -u admin -pmypass -h localhost -P 3308` or using `http://localhost/phpmyadmin`. As you may noticed here `admin` is the default MySQL username and `mypass` is the default  password. You can change the default password in `docker-compose.yml file.`

👍  You can access the GenIE-Sys on `http://localhost/geniesys/` URL and follow the  [documentation](https://app.gitbook.com/@geniesys/s/geniesys/for-administrators/installation).


Licence & Contributors
======================

This work is under Free and Open Source licence

Contributions are welcome!
