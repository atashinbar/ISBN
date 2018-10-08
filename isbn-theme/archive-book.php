<?php
/**
 * The template for displaying Books archive
 *
 */

get_header(); ?>

	<?php if ( have_posts() ) : ?>
		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
			?>
		</header>
	<?php endif; ?>

	<div id="page-content" class="page-content-area">
		<table>
			<tr>
				<td>
					<?php esc_html_e( 'Book Name' , 'isbn' ) ?>
				</td>
				<td>
					<?php esc_html_e( 'ISBN Number' , 'isbn' ) ?>
				</td>
			</tr>
		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
			echo '<tr>';
				echo '<td>';
					if ( !empty( get_the_title() )) {
						echo get_the_title();
					} else {
						esc_html_e('There is no Book title' , 'isbn');
					}
				echo '</td>';
				echo '<td>';
					if ( !empty( get_post_meta( get_the_ID(), '_book_isbn',true ) )) {
						echo get_post_meta( get_the_ID(), '_book_isbn',true );
					} else {
						esc_html_e('There is no ISBN number' , 'isbn');
					}
				echo '</td>';
			echo '</tr>';

			endwhile;
			wp_reset_postdata();
			?>
			</table>
			<div class="wp-pagenavi">
			<div id="wp_page_numbers">
					<ul>
						<?php if ( get_next_posts_link( 'Next Page', $loop->max_num_pages ) ): ?>
							<li><?php echo get_next_posts_link( 'Next Page', $loop->max_num_pages ); ?></li>
						<?php endif; ?>
						<?php if ( get_previous_posts_link( 'Previous Page' ) ): ?>
							<li><?php echo get_previous_posts_link( 'Previous Page' ); ?></li>
						<?php endif; ?>
					</ul>
				</div>
			</div> 	
			<?php
		else :

			esc_html_e('No Books found' , 'isbn');

		endif; ?>
		
	</div><!-- #primary -->

<?php get_footer();
