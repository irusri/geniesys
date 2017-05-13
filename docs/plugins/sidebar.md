```
mysql> explain genebaskets;
+------------------+--------------+------+-----+---------+-----------------------------+
| Field            | Type         | Null | Key | Default | Extra                       |
+------------------+--------------+------+-----+---------+-----------------------------+
| gene_basket_id   | int(10)      | NO   | PRI | NULL    | auto_increment              |
| gene_basket_name | varchar(100) | NO   |     | NULL    |                             |
| harga            | bigint(16)   | NO   |     | NULL    |                             |
| genelist         | mediumtext   | YES  |     | NULL    |                             |
| ip               | varchar(255) | YES  |     | NULL    |                             |
| time             | timestamp    | YES  |     | NULL    | on update CURRENT_TIMESTAMP |
+------------------+--------------+------+-----+---------+-----------------------------+
6 rows in set (0.00 sec)

mysql> explain defaultgenebaskets;
+----------------+--------------+------+-----+---------+-----------------------------+
| Field          | Type         | Null | Key | Default | Extra                       |
+----------------+--------------+------+-----+---------+-----------------------------+
| gene_basket_id | int(10)      | NO   | PRI | NULL    |                             |
| ip             | varchar(255) | NO   |     |         |                             |
| time           | timestamp    | YES  |     | NULL    | on update CURRENT_TIMESTAMP |
+----------------+--------------+------+-----+---------+-----------------------------+
3 rows in set (0.00 sec)
   
   ```
