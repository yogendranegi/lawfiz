<?php
/**
 * lawcraft functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package lawcraft
 */

/**
 *  Defining Constants
 */

// Core Constants
define('LAWCRAFT_REQUIRED_PHP_VERSION', '5.6' );
define('LAWCRAFT_DIR_PATH', get_template_directory());
define('LAWCRAFT_DIR_URI', get_template_directory_uri());
define('LAWCRAFT_THEME_AUTH','#');
define('LAWCRAFT_THEME_URL','#');
define('LAWCRAFT_THEME_PRO_URL','#');
define('LAWCRAFT_THEME_DOC_URL','#');
define('LAWCRAFT_THEME_VIDEOS_URL','#');
define('LAWCRAFT_THEME_SUPPORT_URL','https://wordpress.org/support/theme/lawcraft/');
define('LAWCRAFT_THEME_RATINGS_URL','https://wordpress.org/support/theme/lawcraft/reviews/');
define('LAWCRAFT_THEME_CHANGELOGS_URL','https://themes.trac.wordpress.org/log/lawcraft/');
define('LAWCRAFT_THEME_CONTACT_URL','#');


// Register Custom Navigation Walker
require_once(get_template_directory() .'/inc/wp_bootstrap_navwalker.php');

//Register Required plugin
require_once(get_template_directory() .'/inc/class-tgm-plugin-activation.php');


/**
* Check for minimum PHP version requirement 
*
*/
function lawcraft_check_theme_setup( $oldtheme_name, $oldtheme ){
    // Compare versions.
    if ( version_compare(phpversion(), LAWCRAFT_REQUIRED_PHP_VERSION, '<') ) :
    // Theme not activated info message.
    add_action( 'admin_notices', 'lawcraft_php_admin_notice' );
    function lawcraft_php_admin_notice() {
        ?>
            <div class="update-nag">
                <?php esc_html_e( 'You need to update your PHP version to a minimum of 5.6 to run LawCraft WordPress Theme.', 'lawcraft' ); ?> <br />
                <?php esc_html_e( 'Actual version is:', 'lawcraft' ) ?> <strong><?php echo phpversion(); ?></strong>, <?php esc_html_e( 'required is', 'lawcraft' ) ?> <strong><?php echo LAWCRAFT_REQUIRED_PHP_VERSION; ?></strong>
            </div>
        <?php
    }
    // Switch back to previous theme.
    switch_theme( $oldtheme->stylesheet );
        return false;
    endif;
}
add_action( 'after_switch_theme', 'lawcraft_check_theme_setup', 10, 2  );

if ( ! function_exists( 'lawcraft_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function lawcraft_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on lawcraft, use a find and replace
     * to change 'lawcraft' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'lawcraft', get_template_directory() . '/languages' );

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
        'primary' => esc_html__( 'Primary', 'lawcraft' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(      
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Gallery post format
    add_theme_support( 'post-formats', array( 'gallery' ));

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Remove theme support for new widgets block editor
    remove_theme_support( 'widgets-block-editor' );

    /**
     * lawcraft theme info
     */
    //require get_template_directory() . '/inc/theme-info.php';

    /*
    * About page instance
    */
    /*$config = array();
    LawCraft_About_Page::lawcraft_init( $config );

    if ( is_customize_preview() ) {
        require get_template_directory() . '/inc/starter-content.php';
        add_theme_support( 'starter-content', lawcraft_get_starter_content() );
    }
    */

}
endif;
add_action( 'after_setup_theme', 'lawcraft_setup' );


/*
custom logo
*/
function lawcraft_logo_setup(){
    add_theme_support('custom-logo', array(
        'height' => 65,
        'width' => 350,
        'flex-height' => true,
        'flex-width' => true,
    ));
}
add_action('after_setup_theme', 'lawcraft_logo_setup');


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function lawcraft_widgets_init() {
	//Footer widget columns
    $widget_num = absint(get_theme_mod( 'lawcraft_footer_widgets', '4' ));
    for ( $i=1; $i <= $widget_num; $i++ ) :
        register_sidebar( array(
            'name'          => esc_html__( 'Footer Column', 'lawcraft' ) . $i,
            'id'            => 'footer-' . $i,
            'description'   => '',
            'before_widget' => '<div id="%1$s" class="section %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="widget-title" itemprop="name">',
            'after_title'   => '</h4>',
        ) );
    endfor;


    register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'lawcraft' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'lawcraft' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'lawcraft_widgets_init' );


/*
script goes here
*/
function lawcraft_scripts() {

    wp_enqueue_style( 'lawcraft-style', get_template_directory_uri() . '/style.css', array(), wp_get_theme()->get('Version'));
    wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.3.7');
    wp_enqueue_style( 'dmsans-google-fonts', 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,700;1,9..40,400;1,9..40,700&display=swap', array(), '1.0');
    wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '3.3.7', true );
    wp_enqueue_script( 'main-js', get_template_directory_uri() . '/js/main.js', array(), '1.0', true );
    wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/css/fontawesome.css', array(), '5.10.1');
}
add_action( 'wp_enqueue_scripts', 'lawcraft_scripts' );


/** 
* Excerpt More
*/
function lawcraft_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}
    return '&hellip;';
}
add_filter('excerpt_more', 'lawcraft_excerpt_more');


/** 
* Custom excerpt length.
*/
function lawcraft_excerpt_length($length) {
	if ( is_admin() ) {
		return $length;
	}
	return 30;
}
add_filter('excerpt_length', 'lawcraft_excerpt_length');



// include template-function.php
require_once(get_template_directory() .'/inc/template-functions.php');

// include template-tags.php
require_once(get_template_directory() .'/inc/template-tags.php');