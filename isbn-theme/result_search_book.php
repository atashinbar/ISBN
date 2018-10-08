<?php

$result_for = $_GET["s"];
global $wpdb;
//var_dump($result_for);
$results =  $wpdb->get_results (
"
SELECT * 
FROM  wp_books_info 
WHERE isbn =  $result_for
"
);
var_dump($results);