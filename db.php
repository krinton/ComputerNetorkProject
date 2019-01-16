<?php
//database connections
 $db = mysqli_connect('127.0.0.1:3307','root','','pcap')
 or die('Error connecting to MySQL server.');

//name of the table from the database to use, if only working with 1 db table
$table = "pcap_analysis1";
?>