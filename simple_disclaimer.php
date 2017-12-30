<?php
/*
* Plugin Name: Disclaimer Shortcode
* Description: Put a disclaimer anywhere
* Version: 1.0
* Author: Isham Jassat
* Author URI: https://ishamjassat.com
* License: The MIT License (MIT)
*/

// Define paths

define('disclaimer_url', plugins_url() ."/".dirname( plugin_basename( __FILE__ ) ) );
define('disclaimer_path', WP_PLUGIN_DIR."/".dirname( plugin_basename( __FILE__ ) ) );


// Enqueue style

if  ( ! function_exists( 'disclaimer_styles' ) ):

	function disclaimer_styles()
	{

	    wp_register_style( "disclaimer_styles",  disclaimer_url . '/css/style.css' , "", "1.0.0");
	    wp_enqueue_style( 'disclaimer_styles' );
	}
	add_action('wp_enqueue_scripts', 'disclaimer_styles');
	
endif;

// Add admin page

add_action( 'admin_menu', 'disclaimer_admin_menu' );

function disclaimer_admin_menu() {
	add_menu_page( 'Disclaimer Shortcode Menu', 'Disclaimer', 'manage_options', 'disclaimer-shortcode/admin_menu.php', 'mydisclaimer_admin_page', 'dashicons-tickets', 6  );
	add_action('admin_init', 'update_disclaimer');
}

function mydisclaimer_admin_page(){
	?>
	<div class="wrap">
		<h2>Disclaimer Shortcode Menu</h2>
		<form method="post" action="options.php" enctype="multipart/form-data">
		<?php settings_fields ( 'disclaimer-settings' );?>
		<?php do_settings_sections ( 'disclaimer-settings' ); ?>
			<p><label for="disclaimer_text" class="disclaimer_admin_label">Rating text:</label><input type='textarea' id='disclaimer_text' class='disclaimer_admin_textarea' name='disclaimer_text' value='<?php echo get_option('disclaimer_text'); ?>' /></p>
            <?php submit_button('Save') ?>
        </form>
	</div>
	<?php
} 

if(!function_exists ("update_disclaimer") ) {
function update_disclaimer() {
	
	register_setting('disclaimer-settings', 'disclaimer_text');
	
}
}

// Add shortcode

function disclaimer_shortcode() {

	$text = '<div class="disclaimer-text">' . get_option('disclaimer_text') . '</div>';
	return $text;

}

add_shortcode('disclaimer', 'disclaimer_shortcode');

?>
