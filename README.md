[![geniesys](https://github.com/plantgenie/geniesys/blob/master/docs/images/logo_32.png?raw=true "Download") Website](http://geniesys.org) | [Documentation](https://geniesys.gitbook.io) | [Demo](https://eucgenie.org) 
=======

[![DOI:10.1101/808881](https://zenodo.org/badge/DOI/10.1101/808881.svg)](https://doi.org/10.1101/808881)



Docker installation can be done in several ways.

#### 1.\) Run using Play with Docker
Quickest way to test the GenIE-Sys, it takes only few minutes

[![Try in PWD](https://raw.githubusercontent.com/play-with-docker/stacks/master/assets/images/button.png)](https://labs.play-with-docker.com/?stack=https://raw.githubusercontent.com/irusri/docker4geniesys/master/pwd-stack.yml)

 **2.\) Run with build in Docker image**                                                                            
Fastest way to run the GenIE-Sys locally or your own server
```text
docker run --rm -i -t -p "80:80" -p "3308:3306" -v ${PWD}/genie:/app -v ${PWD}/mysql:/var/lib/mysql -e MYSQL_ADMIN_PASS="mypass" --name geniesys irusri/docker4geniesys
```

#### 3.\) Build image locally using Dockerfile and run.
This is quite slow since you have to build the image locally

```text
git clone https://github.com/irusri/docker4geniesys.git  
cd docker4geniesys  
docker-compose up
```

👍   Now you can access the GenIE-Sys on [http://localhost/geniesys/](http://localhost/geniesys/) URL.

<!--
**Make your wish**
 [![Beerpay](https://beerpay.io/plantgenie/geniesys/make-wish.svg?style=flat)](https://beerpay.io/plantgenie/geniesys)
-->

Licence & Contributors
======================

This work is under Free and Open Source licence

Contributions are welcome!