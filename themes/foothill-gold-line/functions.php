<?php
/**
 * Foothill Gold Line functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Foothill_Gold_Line
 */
if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        "page_title" => "Theme options",
        'menu_title' => 'Theme Options',
        'menu_slug' => 'theme-general-settings'
    ));
    acf_add_options_sub_page(array(
        'page_title' => 'Pages Backgrounds',
        'menu_title' => 'Pages backgrounds',
        'parent_slug' => 'theme-general-settings',
    ));
}

function plugins_requirements() {
    if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
        echo "<div class='error'><p>" . __('This theme requires to be installed Advanced Custom Fields PRO plugin', 'foothill-gold-line') . "</p></div>";
    }
    if (!is_plugin_active('custom-post-type-ui/custom-post-type-ui.php')) {
        echo "<div class='error'><p>" . __('This theme requires to be installed Custom Post Type UI plugin', 'foothill-gold-line') . "</p></div>";
    }
    /*if (!is_plugin_active('modern-events-calendar/mec.php')) {
        echo "<div class='error'><p>" . __('This theme requires to be installed Modern Events Calendar plugin', 'foothill-gold-line') . "</p></div>";
    }*/
}

add_action('admin_notices', 'plugins_requirements');


if (!function_exists('foothill_gold_line_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function foothill_gold_line_setup() {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Foothill Gold Line, use a find and replace
         * to change 'foothill-gold-line' to the name of your theme in all the template files.
         */
        load_theme_textdomain('foothill-gold-line', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'menu-1' => esc_html__('Primary', 'foothill-gold-line'),
            	'language-selector' => esc_html__('Language Selector','foothill-gold-line'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('foothill_gold_line_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 90,
            'width' => 90,
            'flex-width' => false,
            'flex-height' => true,
        ));
    }

endif;
add_action('after_setup_theme', 'foothill_gold_line_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function foothill_gold_line_content_width() {
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('foothill_gold_line_content_width', 640);
}

add_action('after_setup_theme', 'foothill_gold_line_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function foothill_gold_line_widgets_init() {

    register_sidebar(array(
        'name' => esc_html__('Footer Sidebar 1', 'foothill-gold-line'),
        'id' => 'foot-sidebar-1',
        'description' => esc_html__('Add widgets here.', 'foothill-gold-line'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Index Sidebar 2', 'foothill-gold-line'),
        'id' => 'sidebar-index-2',
        'description' => esc_html__('Add widgets here.', 'foothill-gold-line'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
}

add_action('widgets_init', 'foothill_gold_line_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function foothill_gold_line_scripts() {
    wp_enqueue_style('foothill-gold-line-barlow', 'https://fonts.googleapis.com/css2?family=Barlow:wght@400;500;600;700&display=swap', array(), null);
    wp_enqueue_style('foothill-gold-line-style', get_stylesheet_uri(), array('foothill-gold-line-barlow'), '1.19');

    wp_enqueue_script('foothill-gold-line-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

    wp_enqueue_script('foothill-gold-line-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'foothill_gold_line_scripts');

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
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

function get_archive_by_date_hierachy($post_type) {
    $posts_array = array();

    $all_posts = get_posts(array(
        'numberposts' => -1,
        'post_type' => $post_type,
        'date_query' => array(
            'column' => 'post_date',
            array(
                'before' => date("Y")
            )
        )
    ));

    foreach ($all_posts as $thepost) {
        $posts_array[get_the_date('Y', $thepost->ID)][get_the_date('F', $thepost->ID)][] = $thepost->ID;
    }
    ?>
    <div class="accordion ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
        <?php
        foreach ($posts_array as $year_k => $year_v) {
            ?>
            <h3 class="title ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"><span class="ui-icon ui-icon-triangle-1-e"></span><?php echo $year_k; ?></h3>
            <div class="content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                <div class="iaccordion ui-accordion ui-widget ui-helper-reset ui-accordion-icons">
                    <?php foreach ($year_v as $month_k => $month_v) {
                        ?>
                        <h3 class="title ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"><span class="ui-icon ui-icon-triangle-1-e"></span><?php echo $month_k; ?></h3>
                        <div class="content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">

                            <?php foreach ($month_v as $post_id) {
                                $link = get_the_permalink($post_id);

                                if(get_field("file_link", $post_id)){
                                    $attached_file = get_field("file_link", $post_id);
                                    $link = $attached_file["url"];
                                }
                                if(get_field("article_external_link", $post_id)){
                                    if (!strstr(get_field("article_external_link", $post_id), "https://")) {
                                        $link = "https://" . get_field("article_external_link", $post_id);
                                    } else {
                                        $link = get_field("article_external_link", $post_id);
                                    }
                                }
                                ?>
                                <p>
                                    <a href="<?php echo $link; ?>" title="<?php echo get_the_title($post_id); ?>"><strong><?php
                                            if (get_field("toggle_date", $post_id) === "show") {
                                                echo get_the_date('', $post_id) . " - ";
                                            }
                                            ?></strong> <?php echo get_the_title($post_id); ?></a> <?php
                                    if (get_field("article_teaser", $post_id)) {
                                        echo " - ";
                                        echo strip_tags(get_field("article_teaser", $post_id));
                                    }
                                    ?>
                                </p>

                        <?php }
                        ?>
                        </div>
                <?php
            }
            ?>
                </div>
            </div>
    <?php } ?>

    </div> <?php
}


/* Add Image Sizes */

add_image_size( 'slider_image', 467, 348, array( 'center', 'center') );
add_image_size( 'home_slider', 466, 278, array( 'center', 'center') );

/* Get Taxonomy Terms */
function display_taxonomy_terms($post_type, $display = false) {
    global $post;
    $term_list = wp_get_post_terms($post->ID, $post_type, array('fields' => 'names'));

    if($display == false) {
        echo $term_list[0];
    }elseif($display == 'return') {
        return  $term_list[0];
    }
};

/* Breadcrumbs based on menu */
function my_breadcrumb($theme_location = 'main', $separator = ' &gt; ') {

    $items = wp_get_nav_menu_items($theme_location);
    _wp_menu_item_classes_by_context( $items ); // Set up the class variables, including current-classes
    $crumbs = array();

    foreach($items as $item) {
        if ($item->current_item_ancestor || $item->current) {
            $crumbs[] = "<li><a href=\"{$item->url}\" title=\"{$item->title}\">{$item->title}</a></li>";
        }
    }
    echo implode($separator, $crumbs);
}

/** Apply the shared tan button style to the language menu trigger. */
function foothill_gold_line_language_button_attributes($atts, $item, $args, $depth) {
    if (isset($args->theme_location) && 'language-selector' === $args->theme_location
        && 0 === $depth && in_array('fgl-translate-button', (array) $item->classes, true)) {
        $atts['class'] = trim(($atts['class'] ?? '') . ' fgl-button fgl-button--tan');
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'foothill_gold_line_language_button_attributes', 10, 4);
