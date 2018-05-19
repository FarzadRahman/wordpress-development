<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Britt
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
		<?php
			if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta clearfix">
				<?php britt_posted_on(); ?>
				<?php britt_get_first_cat(); ?>
				<span><a class="read-more" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo esc_html__('Continue reading', 'britt'); ?></a></span>				
			</div><!-- .entry-meta -->
			<?php
			endif;
		?>		
	</header><!-- .entry-header -->

	<div class="post-inner">

	<?php if ( has_post_thumbnail() && ( get_theme_mod( 'index_feat_image' ) != 1 ) ) : ?>
		<div class="entry-thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('britt-small-thumb'); ?></a>
		</div>
	<?php endif; ?>

		<div class="entry-content">
			<?php
			if ( is_single() ) :
				the_content();
			else :
				the_excerpt();
			endif;
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'britt' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	</div>

</article><!-- #post-## -->
