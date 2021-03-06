<?php
/**
 * This is the function.php of the child theme and contain all the main information about the theme.
 *
 *
 *
 * @package Listify Child Theme
 * @since 0.1
 * @version 0.1
 */

function listify_child_styles() {
    $parent_style = 'listify-child';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'listify-child-css', get_stylesheet_directory_uri() . '/css/style.css', array( $parent_style ), wp_get_theme()->get('Version'));
	wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array( $parent_style ), wp_get_theme()->get('Version'));
	wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script('code-js', get_stylesheet_directory_uri() . '/js/code.js', array( 'jquery' ), '1.0', true );

}
add_action( 'wp_enqueue_scripts', 'listify_child_styles', 999 );

function listify_theme_setup() {
	add_theme_support('menus');
	register_nav_menu('primary', 'Primary Header Navigation');
	register_nav_menu('secondary', 'Secondary Navigation');
}
add_action('init', 'listify_theme_setup');


require_once("custom_fields.php");

/* This code adapted from: Registration Redirect */
add_filter( 'registration_redirect', 'ckc_registration_redirect' );
function ckc_registration_redirect() {
    return get_page_link(473);
}

/* This code adapted from: Login Redirect */
add_filter( 'login_redirect', 'ckc_login_redirect' );
function ckc_login_redirect() {
    return home_url();
}

/** Customizing the WordPress Login Page
 *
 * Load CSS file.
 * https://premium.wpmudev.org/blog/customize-login-page/
 */
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');


function my_custom_js() {
	echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>';
}
// Add hook for admin <head></head>
add_action('admin_head', 'my_custom_js');
// Add hook for front-end <head></head>
add_action('wp_head', 'my_custom_js');


/** Customizing the WordPress Login Logo URL
 *
 *
 * hhttp://www.wpbeginner.com/wp-tutorials/how-to-change-the-login-logo-url-in-wordpress/
 */
add_filter( 'login_headerurl', 'custom_loginlogo_url' );
function custom_loginlogo_url($url) {
	return 'http://www.badges4languages.com';
}


/** Limit Upload Size for Non-Admins
 *
 * Limit the upload size limit to 1MB for any users who are not an administrator.
 */
function limit_upload_size_limit_for_non_admin( $limit ) {
	if ( ! current_user_can( 'manage_options' ) ) {
		$limit = '1000000'; // 1mb in bytes
	}
	return $limit;
}
add_filter( 'upload_size_limit', 'limit_upload_size_limit_for_non_admin' );

/** Disable Admin Bar
 *
 *  for All Users Except for Administrators
 */
if (!current_user_can('edit_posts')) {
	add_filter('show_admin_bar', '__return_false');
}

/** Remove links to the Admin Tool-Bar
 *
 */
add_action( 'admin_bar_menu', 'remove_links_toolbar', 999 );
function remove_links_toolbar($wp_admin_bar)
{
 global $wp_admin_bar;
 //$wp_admin_bar->remove_menu('comments');
 //$wp_admin_bar->remove_menu('updates');

 $wp_admin_bar->remove_menu('wp-logo');
}


/** Disable default dashboard widgets
 *
 *  for All Users Except for Administrators
 */
function disable_default_dashboard_widgets() {

	//remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_activity', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}

if (!current_user_can('manage_options')) {
        add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets');
}






/* Call the login folder and change the default wp login page */
/*
 * Under construction
 *
function my_custom_login() {
echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');
 *
 *
 */



/** show Jetpack only for administrators
 *
 * http://wpguru.co.uk/2014/03/how-to-remove-the-jetpack-admin-menu-from-subscribers/
 *
 */

function pinkstone_remove_jetpack() {
	if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {
		remove_menu_page( 'jetpack' );
	}
}
add_action( 'admin_init', 'pinkstone_remove_jetpack' );


/**
 *  This function permit to do a WP_Query and take the right badge to the plugin.
 *
 * @param string "$_POST['target']" permit to retrieve the information about the target (student, teacher)
 * @param string "$_POST['level']" permit to retrieve the information about the level (A1, A2, B1, B2, ...)
 */
function searchBadges_ajax_handler() {
	$target = $_POST['target'];
	$level = $_POST['level'];

	if ($level === ""){

		$args = array(
            'post_type'   => 'badge',
            'orderby' => 'name',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_type',
                    'value' => $target,
                ),
            )
        );

	} else {

        $args = array(
            'post_type' => 'badge',
            'orderby' => 'name',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_type',
                    'value' => $target,
                ),
            ),
            'tax_query' => array(
                array(
                    'taxonomy' => 'level',
                    'field' => 'slug',
                    'terms' => $level,
                )
            ),
        );

    }

	$response = new WP_Query($args);

	if( $response->have_posts() ):

		echo '<div class="row">';

		while( $response->have_posts() ): $response->the_post(); ?>

			<?php get_template_part( 'content', 'badge-preview' ); ?>

		<?php endwhile;

		echo '</div>';


	endif;

	wp_reset_postdata();
	wp_die(); // close the connection
}

add_action('wp_ajax_searchBadges', 'searchBadges_ajax_handler'); // add action for logged users
add_action( 'wp_ajax_nopriv_searchBadges', 'searchBadges_ajax_handler' ); // add action for unlogged users


function getTaxonomyLevel_ajax_handler() {
	$searchTerm = $_POST['searchTerm'];
	$values = get_terms( 'level');
	$count = 0;
	echo "<option value='$count'>Select</option>";
	foreach ($values as $value){
		$count++;
		echo "<option value='$count'>$value->name</option>";
	}
}

add_action('wp_ajax_getTaxonomyLevel', 'getTaxonomyLevel_ajax_handler'); // add action for logged users
add_action( 'wp_ajax_nopriv_getTaxonomyLevel', 'getTaxonomyLevel_ajax_handler' ); // add action for unlogged users
