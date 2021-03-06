<?php
/**
 * The template for displaying all single post.
 *
 *
 *
 * @package Listify Child Theme
 * @since 0.1
 * @version 0.1
 */

get_header(); ?>

	<div <?php echo apply_filters( 'listify_cover', 'page-cover page-cover--large', array( // WPCS: XSS ok.
		'size' => 'full',
	) ); ?>>
		<h1 class="page-title cover-wrapper"><?php the_post(); the_title(); rewind_posts(); ?></h1>
	</div>

	<div id="primary" class="container">
		<div class="row content-area">

			<?php if ( 'left' === esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

			<main id="main" class="site-main col-xs-12 <?php if ( 'none' !== esc_attr( listify_theme_mod( 'content-sidebar-position', 'right' ) ) && is_active_sidebar( 'widget-area-sidebar-1' ) ) : ?>col-sm-7 col-md-8<?php endif; ?>" role="main">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content' ); ?>
					<?php
						if(get_post_type( $post ) == 'teacher_portfolio'){

								echo '<h1>Teacher Portfolio:</h1></br></br>';
								teacher_grades($post);
						}

						else if (get_post_type( $post ) == 'student_portfolio'){

									echo '<h1>Student Portfolio:</h1></br></br>';
								 	student_grades($post);
						}

					?>



					<?php comments_template(); ?>

				<?php endwhile; ?>

			</main>

			<?php if ( 'right' === esc_attr( get_theme_mod( 'content-sidebar-position', 'right' ) ) ) : ?>
				<?php get_sidebar(); ?>
			<?php endif; ?>

		</div>
	</div>

<?php get_footer(); ?>
