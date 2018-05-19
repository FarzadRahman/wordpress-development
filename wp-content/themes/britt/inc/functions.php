<?php
/**
 * Britt functions
 *
 * @package Britt
 */

/**
 * Carousel
 */
function britt_posts_carousel() {

	$hide 				= get_theme_mod('hide_carousel_singles', '1');
	$carousel_title 	= get_theme_mod('carousel_title', __('Latest news', 'britt'));
	$post_ids			= get_theme_mod('carousel_posts');
	$posts_array		= explode(',', $post_ids);

	if ( is_singular() && $hide ) {
		return;
	}

	if ($post_ids == '') {
		return;
	}

?>
	<section class="posts-carousel">
		<div class="container">
			<h3 class="carousel-title"><?php echo esc_html($carousel_title); ?></h3>
			<div class="carousel-inner">
			<?php $r = new WP_Query( array(
				'post__in'			  => $posts_array,
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => true
			) );
			if ($r->have_posts()) :

			while ( $r->have_posts() ) : $r->the_post(); ?>
				<div class="carousel-post">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="entry-thumb">
						<?php the_post_thumbnail('britt-small-thumb'); ?>
					</div>
					<?php endif; ?>							
					<div class="carousel-post-content">
						<?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>

						<?php
						$category = get_the_category();
						if ($category) :
						  echo '<a class="carousel-cat" href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" title="' . sprintf( __( 'View all posts in %s', 'britt' ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a> ';
						endif; ?>

					</div>
				</div>

			<?php endwhile; ?>
			<?php endif; ?>
			<?php wp_reset_postdata(); ?>
		</div>
		</div>
	</section>

<?php
}
add_action('britt_featured_area', 'britt_posts_carousel');

/**
 * Featured image style
 */
function britt_featured_image_large() {
	$featured_image = get_theme_mod('single_featured_image', 'in-post');

	if ( $featured_image != 'above-post')
		return;

	if ( is_single() && has_post_thumbnail() ) {
		echo '<div class="large-thumb container">';
			echo '<div class="single-thumb">';
				the_post_thumbnail('britt-above-post-thumb');
			echo '</div>';
			echo '<header class="entry-header">';
				the_title( '<h1 class="entry-title">', '</h1>' );
				if ( 'post' === get_post_type() ) {
				echo '<div class="entry-meta clearfix">';
					britt_posted_on();
				echo '</div>';
				}
			echo '</header>';
		echo '</div>';
	}
}
add_action('britt_featured_area', 'britt_featured_image_large', 12);

/**
 * Featured categories
 */
function britt_featured_categories() {

	$hide 	= get_theme_mod('hide_featured_cats', 0);

	if ( $hide ) {
		return;
	}

	$featured_label = get_theme_mod('featured_cats_label', __('Hot topics', 'britt'));
	$featured_cats = array();
	$featured_cats[] = get_theme_mod('featured_cat_1', get_option( 'default_category', '' ));
	$featured_cats[] = get_theme_mod('featured_cat_2', get_option( 'default_category', '' ));
	$featured_cats[] = get_theme_mod('featured_cat_3', get_option( 'default_category', '' ));

	echo '<div class="featured-cats">';
		echo '<div class="container">';
			echo '<h3 class="featured-cats-title">' . esc_html($featured_label) . '</h3>';
			foreach ($featured_cats as $featured_cat) {
				echo '<span><a href="' . esc_url( get_category_link($featured_cat) ) . '" title="' . get_cat_name( $featured_cat ) . '">' . get_cat_name( $featured_cat ) . '</a></span>';
			}
		echo '</div>';
	echo '</div>';
}
add_action('britt_featured_area', 'britt_featured_categories', 11);

/**
 * Remove archive labels
 */
function britt_archive_labels($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', false );
    } elseif ( is_author() ) {
        $title = '<span class="vcard">' . get_the_author() . '</span>' ;
	}
    return $title;
}
add_filter( 'get_the_archive_title', 'britt_archive_labels');

/**
 * Logo
 */
function britt_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}