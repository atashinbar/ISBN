<?php
/* Template Name: Search Results */
 

$search_refer = $_GET["post_type"];
if ($search_refer == 'book')
{
    load_template(TEMPLATEPATH . '/result_search_book.php');
}
 
?>
