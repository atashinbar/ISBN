<?php
get_header(); ?>

    <div id="page-content" class="page-content-area">
    <?php
        if ( have_posts() ) :
            
			/* Start the Loop */
            while ( have_posts() ) : the_post();
            
            echo '<a href="'.get_the_permalink().'">' . get_the_title() . '</a>';
            echo '<br>';
            echo get_the_content();

            endwhile;

        endif;
    ?>
    </div>
<?php
get_footer();