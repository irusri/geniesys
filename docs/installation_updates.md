Installation & Updates
=====================

------------------------
Download & Requirements
------------------------

You can download the latest version of GenIECMS by using the official download link:

[![Download](https://github.com/irusri/GenIECMS/blob/master/docs/download.png?raw=true "Download")](http://geniecms.org/latest/genie.zip)

If you prefer using the terminal please run:

```
git clone --recursive https://github.com/irusri/GenIECMS.git
```    

**Requirements**
* Apache 2 with URL rewriting (mod_rewrite) or nginx
* PHP 5.4+

------------------------
Running from Command Line
------------------------
When you have already installed PHP 5.4 or higher version into your **nix* support computer, just use following lines to install GenIECMS.
```
git clone --recursive https://github.com/irusri/GenIECMS.git
cd GenIECMS
php -S localhost:8000
```
You should now be able to access GenIECMS at: ```http://localhost:8000/GenIECMS``` in your browser.

------------------------
Installing GenIECMS on a Mac
------------------------
Most Mac users will probably try GenIECMS with MAMP.  

[![MAMP](https://github.com/irusri/GenIECMS/blob/master/docs/mamp.png?raw=true "MAMP")](http://www.mamp.info/en/downloads/)

**Installing MAMP**

Installing MAMP is just a matter of downloading the app from the MAMP website and running the installer. It will install a MAMP app in your Applications folder.

[![MAMP](https://github.com/irusri/GenIECMS/blob/master/docs/mamp-02.png?raw=true "MAMP")](http://www.mamp.info/en/downloads/)

By starting the MAMP app you are also starting your Apache and MySQL server. You should now be able to reach your local server at ```http://localhost:8888```.

**Download GenIECMS**

[![Download](https://github.com/irusri/GenIECMS/blob/master/docs/download.png?raw=true "Download")](http://geniecms.org/latest/genie.zip)

**Copy GenIECMS to MAMP Web server**

You will find the source of GenIECMS in your download folder. So you just need to Copy GenIECMS folder into to your corresponding ```~/Applications/MAMP/htdocs/ folder```.

That is basically what you need to do in order to install GenIECMS on your Mac's local server. You should now be able to access it at: ```http://localhost:8888/GenIECMS``` in your browser.

------------------------
Installing GenIECMS on a PC
------------------------
GenIECMS can be successfully installed into windows computer using XAMPP as a Web server. 
[![XAMPP](https://github.com/irusri/GenIECMS/blob/master/docs/xampp.png?raw=true "XAMPP")](https://www.apachefriends.org/download.html)

