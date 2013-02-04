<?php
/**
 * The bannermaker tamplate
  */

get_header(); ?>

		<div id="wrapper">
			
				<?php while ( have_posts() ) : the_post(); ?>

					

				<?php endwhile; // end of the loop. ?>
			
		</div><!-- #primary -->

<?php get_footer(); ?>