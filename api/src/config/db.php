<?php
require 'crypt.php';
class db{
        // Properties
        private $dbhost = '';
        private $dbuser = '';
        private $dbpass = '';
        private $dbname = '';

        // Connect
        public function connect($database_name){

            $ini_array = parse_ini_file("../../genie_files/settings",true) or die("Unable to open file!");
            $genieCrypt=new genieCrypt();

            $this->dbhost=$ini_array['settings'][host];
            $this->dbuser=$ini_array['settings'][username];
            $this->dbpass=$genieCrypt->DecryptThis($ini_array['settings'][password]);
            $database_name=$ini_array['settings'][database];

            //Make a connection
            $conn = mysqli_connect($host, $username, $password);

            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$database_name";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;    
        }

}
