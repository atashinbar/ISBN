<?php
get_header();
?>
<header class="page-header">
    <?php
        the_archive_title( '<h1 class="page-title">', '</h1>' );
    ?>
</header>
<div id="page-content" class="page-content-area">
    <?php
        the_archive_description( '<div class="taxonomy-description">', '</div>' );
    ?>
</div>
<?php
get_footer();
