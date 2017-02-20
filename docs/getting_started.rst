Getting Started
=============
The Genome Integrative Explorer Content Management System (GenIE-CMS) is the first dedicative in-house CMS to facilitate external groups in setting up their own web resource for searching, visualizing, editing, sharing and reproducing their genomic and transcriptomic data while using project raw data(gff3,fasta,fatsq) as an input.

------------
Requirements
------------

**Web Server**:
Basic installation of GenIE CMS will require a web server(Apache 2 with URL rewriting or nginx) and PHP 5.4+ support. LAMP(Linux,Apache,MySQL,PHP) is recommended for Linux environment. 

**Optional settings**:  
 #. Update php.ini (ex: memory_limit=256M)  
 #. MySQL my.cnf (ex: max_allowed_packet = 32M) 

------------------
Download & Install
------------------

#. Go to web root directory (ex: /var/www) and run following command.::

       wget https://geniecms.org/latest/setup.sh && sh setup.sh install_genie
#. Navigate to **http://[your server name]/genie** (ex: http://localhost/genie).
#. Follow the instructions on the front page to customise the installation.
#. Download and install necessary plugins as described in `plugins section <https://geniecms.org/index.html#plugins>`_.
