	
<?php /* Template Name: Search ISBN */ 
get_header();
?>
<form id="searchform" action="<?php bloginfo('home'); ?>/" method="get">
    <input id="s" maxlength="150" name="s" size="20" type="text" value="" class="txt" />
    <input name="post_type" type="hidden" value="book" />
    <input id="searchsubmit" class="btn" type="submit" value="Search" />
</form>
<?php
get_footer();
