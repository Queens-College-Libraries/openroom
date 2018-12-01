#Setup guide 

##Database 

```mysql
$ mysql -u root -h 127.0.0.1 -p
Enter password: 
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 8
Server version: 10.3.4-MariaDB MariaDB Server

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> create database openroom;
Query OK, 1 row affected (0.001 sec)

MariaDB [(none)]> create user 'openroomdemo'@'%' identified by '53PVs7nj2i2AD5FXNLNpZyW3B3sG31WGPThmPCntdldKwxZ5vvb3Pg266HSN8NG';
Query OK, 0 rows affected (0.001 sec)

MariaDB [(none)]> grant all privileges on openroom.* to 'openroomdemo'@'%';
Query OK, 0 rows affected (0.001 sec)

MariaDB [(none)]> use openroom;
Database changed
MariaDB [openroom]> source today.sql;
Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.003 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.012 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 1 row affected (0.002 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.015 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 1 row affected (0.003 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.011 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 70 rows affected (0.006 sec)
Records: 70  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.012 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.012 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.002 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.012 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 1 row affected (0.002 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.013 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.013 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 28 rows affected (0.003 sec)
Records: 28  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.014 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 2 rows affected (0.004 sec)
Records: 2  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.011 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 42 rows affected (0.004 sec)
Records: 42  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.014 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 6 rows affected (0.002 sec)
Records: 6  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.013 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.012 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 37 rows affected (0.004 sec)
Records: 37  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.015 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.001 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 4 rows affected (0.003 sec)
Records: 4  Duplicates: 0  Warnings: 0

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

Query OK, 0 rows affected (0.000 sec)

MariaDB [openroom]> \q
Bye
```

## Composer Install 

```bash
$ composer install
Loading composer repositories with package information
Installing dependencies (including require-dev) from lock file
Package operations: 6 installs, 0 updates, 0 removals
  - Installing components/jquery (3.3.1): Downloading (100%)         
  - Installing mobiledetect/mobiledetectlib (2.8.33): Downloading (100%)         
  - Installing twbs/bootstrap (v4.1.3): Downloading (100%)         
  - Installing symfony/polyfill-mbstring (v1.9.0): Loading from cache
  - Installing symfony/polyfill-ctype (v1.9.0): Loading from cache
  - Installing twig/twig (v2.5.0): Loading from cache
Generating autoload files
```