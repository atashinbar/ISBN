<?php
get_header(); ?>

    <div id="page-content" class="page-content-area">
    <?php
        if ( have_posts() ) :
            
			/* Start the Loop */
            while ( have_posts() ) : the_post();
            
            echo get_the_title();
            echo '<br>';
            echo esc_html__('ISBN Number:','isbn') . get_post_meta( get_the_ID(), '_book_isbn',true );

            endwhile;

        endif;
    ?>
    </div>
<?php
get_footer();