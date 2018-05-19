<?php
/**
 * Britt functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Britt
 */

if ( ! function_exists( 'britt_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function britt_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Britt, use a find and replace
	 * to change 'britt' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'britt', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('britt-above-post-thumb', 1300);
	add_image_size('britt-large-thumb', 880);
	add_image_size('britt-small-thumb', 450);


	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'britt' ),
		'social'  => __( 'Social', 'britt' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'britt_custom_background_args', array(
		'default-color' => '000000',
		'default-image' => '',
	) ) );

	add_theme_support( 'custom-logo', array(
		'height'      => apply_filters( 'britt_logo_height', '150'),
		'width'       => apply_filters( 'britt_logo_width', '300'),
		'flex-width' => true,
	) );

}
endif;
add_action( 'after_setup_theme', 'britt_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function britt_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'britt_content_width', 640 );
}
add_action( 'after_setup_theme', 'britt_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function britt_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'britt' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_widget( 'Britt_About_Me' );
	register_widget( 'Britt_Recent_Posts' );
	register_widget( 'Britt_Video' );

}
add_action( 'widgets_init', 'britt_widgets_init' );

require get_template_directory() . "/widgets/about-me.php";
require get_template_directory() . "/widgets/recent-posts.php";
require get_template_directory() . "/widgets/video-widget.php";

/**
 * Enqueue scripts and styles.
 */
function britt_scripts() {
	wp_enqueue_style( 'britt-style', get_stylesheet_uri() );

	wp_enqueue_style( 'britt-icons', get_template_directory_uri() . '/fonts/css/fontello.css', array(), true );

	$body_font 		= get_theme_mod('body_fonts', '//fonts.googleapis.com/css?family=Merriweather:300,300italic,700,700italic');
	$headings_font 	= get_theme_mod('headings_fonts', '//fonts.googleapis.com/css?family=Playfair+Display:400,400italic,700,700italic');

	wp_enqueue_style( 'britt-body-fonts', esc_url($body_font) ); 
	
	wp_enqueue_style( 'britt-headings-fonts', esc_url($headings_font) );	

	wp_enqueue_script( 'britt-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_script( 'britt-scripts', get_template_directory_uri() . '/js/scripts.min.js', array('jquery'), '', true );		

	wp_enqueue_script( 'britt-main', get_template_directory_uri() . '/js/main.min.js', array('jquery'), '', true );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array(), '', true );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'britt_scripts' );

/**
 * Enqueue Bootstrap
 */
function britt_enqueue_bootstrap() {
	wp_enqueue_style( 'britt-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'britt_enqueue_bootstrap', 9 );

/**
 * Get first post category
 */
function britt_get_first_cat() {
	$category = get_the_category();
	if ($category) {
		echo '<span class="first-cat">' . __('Posted in ', 'britt') . '<a href="' . get_category_link( $category[0]->term_id ) . '" title="' . sprintf( __( 'View all posts in %s', 'britt' ), $category[0]->name ) . '" ' . '>' . $category[0]->name.'</a></span>';
	}	
}

/**
 * Excerpt length
 */
function britt_excerpt_length( $length ) {
	$excerpt = get_theme_mod('exc_length', '20');
	return absint($excerpt);
}
add_filter( 'excerpt_length', 'britt_excerpt_length', 999 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Styles
 */
require get_template_directory() . '/inc/styles.php';

/**
 * Extra functions
 */
require get_template_directory() . '/inc/functions.php';