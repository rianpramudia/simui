<?php
    //global $connection;
    //$servername = "localhost";
    //$username = "postgres";
    //$password = "aswq";
    //$dbname = "postgres";
    
    //$connection = pg_connect($servername, $username, $password, $dbname);
    
    /**Cek koneksi**/
    //if(!$connection){
    //    die("Connection failed : ". pq_connect_error());
    //}
?>

<?php

// connecting, selecting database
// anda harus sesuaikan dbnam, user dan password sesuai dengan setting pada database server anda

$conn_string = "host=localhost port=5432 dbname=postgres user=postgres password=aswq";

$conn = pg_connect($conn_string);
$q_schema = pg_query($conn, "set search_path to simui");
$q_date = pg_query($conn, "set datestyle to 'DMY'");
if (!$conn) {
	print("Connection Failed");
	exit;
}
?>