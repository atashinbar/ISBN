<?php

$result_for = $_GET["s"];
global $wpdb;
$results =  $wpdb->get_results (
    "SELECT * 
    FROM  wp_books_info 
    WHERE isbn =  $result_for"
);
$Out = $book_id = array();
foreach ($results as $result) {
    $Out = json_decode(json_encode($result), True);
    $book_id[] = $Out['post_id'];
}

if ( !empty( $book_id) )
{
    foreach ($book_id as $key => $value)
    {
        $args = array( 'p' => $value , 'post_type' => 'book', 'posts_per_page' => 10 );
        $loop = new WP_Query( $args );

        while ( $loop->have_posts() ) : $loop->the_post();

            echo '<a href="'.get_the_permalink($value).'">'.get_the_title($value).'</a><br>';

        endwhile;
    }
} else {

    esc_html_e( 'No book found' , 'isbn' ); 

}
