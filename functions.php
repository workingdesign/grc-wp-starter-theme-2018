<?php
/**
 * GRC 2018 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package GRC_2018
 */

if ( ! function_exists( 'grc2018_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function grc2018_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on GRC 2018, use a find and replace
		 * to change 'grc2018' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'grc2018', get_template_directory() . '/languages' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'grc2018' ),
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

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'grc2018_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );



		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 90,
			'width'       => 90,
			'flex-width'  => true,
			// 'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'grc2018_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function grc2018_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'grc2018_content_width', 640 );
}
add_action( 'after_setup_theme', 'grc2018_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function grc2018_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'grc2018' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'grc2018' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'grc2018_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function grc2018_scripts() {
	// Enqueue Google Fonts Dosis and Kavivanar GRC
	wp_enqueue_style( 'grc2018-fonts', 'https://fonts.googleapis.com/css?family=Dosis:400,700|Kavivanar' );

	wp_enqueue_style( 'grc2018-style', get_stylesheet_uri() );

	// Custom GRC JS
	wp_enqueue_script( 'grc2018-main', get_template_directory_uri() . '/scripts/main.js', array(), '20180410', true );

	wp_enqueue_script( 'grc2018-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'grc2018-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'grc2018_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php'; // GRC former extra.php

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * GRC Functions.
 */

/**
 * SwiperSlider: modern mobile touch slider with hardware accelerated transitions and native behavior
 * http://idangero.us/swiper/
 */

function grc2018_swiper() {
	if ( ! is_admin() ) {

		// Enqueue SwiperSlider JavaScript
		wp_register_script('js_swiper', get_template_directory_uri(). '/js/swiper.min.js', array() );
		wp_enqueue_script('js_swiper');

		// Enqueue SwiperSlider Stylesheet
		wp_register_style( 'swiper-style', get_template_directory_uri() . '/css/swiper.min.css', 'all' );
		wp_enqueue_style( 'swiper-style' );

		// SwiperSlider custom settings
		add_action('wp_footer', 'grc2018_swiper_settings');

		function grc2018_swiper_settings() { ?>
			<script>
			  var mySwiper = new Swiper('.swiper-container', {
			      // Optional parameters
			      // direction: 'vertical',
			      direction: 'horizontal',
			      loop: true,

			      // If we need pagination
			      pagination: {
			          el: '.swiper-pagination',
			      },

			      // Navigation arrows
			      navigation: {
			          nextEl: '.swiper-button-next',
			          prevEl: '.swiper-button-prev',
			      },

			      // And if we need scrollbar
			      scrollbar: {
			          el: '.swiper-scrollbar',
			      },
			  })
			</script>
		<?php
		}

	}
}

add_action('init', 'grc2018_swiper');
