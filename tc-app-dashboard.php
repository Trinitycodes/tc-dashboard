<?php
/**
 *
 * @link              http://trinitycodes.com
 * @since             1.0.0
 * @package           Trinity Codes Dashboard
 *
 * @wordpress-plugin
 * Plugin Name:       Trinity Codes Dashboard
 * Plugin URI:        http://trinitycodes.com/
 * Description:       Customizes the admin area for applications use.
 * Version:           1.0.0
 * Author:            Trinity Codes
 * Author URI:        http://trinitycodes.com/about-trinity-codes-business-websites/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       trinity-codes-dashboard
 * Domain Path:       /languages
 */

// includes 
require_once dirname(__FILE__) . '/tc-admin-theme/tc-admin-theme.php';

class TC_App_Dashboard
{

	public function __construct() {

		/**
		 * Remove unwanted items from the admin toolbar
		 */
		add_action( 'wp_before_admin_bar_render', array( $this, 'tc_customize_admin_toolbar' ) );
		add_action( 'admin_menu', array( $this, 'tc_customize_main_navigation' ) );

		// remove unwanted dashboard widgets for relevant users
		add_action( 'wp_dashboard_setup', array( $this, 'tc_remove_dashboard_widgets' ) );

		// add_action( 'wp_dashboard_setup', array( $this, 'tc_add_dashboard_widgets' ) );

		add_filter('admin_footer_text', array( $this, 'tc_remove_footer_admin' ) );

	}

	/**
	 * Remove Admin Toolbar from Frontend
	 * @param (boolean) $status [True will show the admin bar and false will hide it.]
	 */
	public function set_front_end_toolbar( $status ) {

		show_admin_bar( $status );

	}

	// Admin footer modification
	public function tc_remove_footer_admin () 
	{
	    echo '<span id="footer-thankyou">Developed by <a href="http://trinitycodes.com" target="_blank">Trinity Codes</a></span>';
	}

	/**
	 * Remove unwanted items from the admin bar
	 */
	public function tc_customize_admin_toolbar() {

		global $wp_admin_bar;

		$wp_admin_bar->remove_menu( 'updates' );
		$wp_admin_bar->remove_menu( 'comments' );
		$wp_admin_bar->remove_menu( 'wporg' );
		$wp_admin_bar->remove_menu( 'wp-logo' );
		$wp_admin_bar->remove_menu( 'new-content' );
		$wp_admin_bar->remove_menu( 'view-site' );
		$wp_admin_bar->remove_menu( 'site-name' );

		$title = '<img src="'. plugins_url( 'tc-admin-theme/images/logo@2x.png', __FILE__ ) . '" alt="Trinity Codes" />';
		$wp_admin_bar->add_menu( array(
				'id' => 'tc-logo',
				'title' => $title,
				'href' => 'http://trinitycodes.com',
			));

		$wp_admin_bar->add_menu( array(
				'id' => 'tc-site-name',
				'title' => get_bloginfo( 'blogname' ),
				'href' => site_url(),
			));

		$wp_admin_bar->add_menu( array(
				'id' => 'front-end-link',
				'title' => 'Visit Site',
				'href' => site_url(),
			));

		$nodes = $wp_admin_bar->get_nodes();

		//echo "<pre>"; print_r($nodes); exit;

	}

	/**
	 * Customize the main navigation in the Admin Menu
	 */
	public function tc_customize_main_navigation() {

		global $menu, $submenu;

		// Show all menu items
		// echo "<pre>"; print_r( $menu ); exit;

		if( !current_user_can( 'manage_options' ) ) {

			unset( $menu[5] );
			unset( $menu[26] );
			unset( $menu[25] );
			unset( $menu[75] );

		}

	}

	/**
	 * Remove all dashboard widgets if not Administrator
	 */
	public function tc_remove_dashboard_widgets() {

	    $user = wp_get_current_user();
	    if ( ! $user->has_cap( 'manage_options' ) ) {
	        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	    }
	}

	/**
	 * Add new dashboard widgets
	 */
	public function tc_add_dashboard_widgets() {

	    wp_add_dashboard_widget( 'tc_dashboard_welcome', 'Welcome', 'tc_add_welcome_widget' );
	    add_meta_box( 'tc_dashboard_view_site', 'Frontend Links', 'tc_add_visit_site_widget', 'dashboard', 'side' );

	}

}
$tc_dashboard = new TC_App_Dashboard();

// Set the toolbar to False for front end
$tc_dashboard->set_front_end_toolbar(false);

function tc_add_welcome_widget(){ ?>
 
 	
	<p style="font-size: 18px;">Now that you are logged to <?php echo get_bloginfo('name'); ?>.</p>
	 
	<p>This is your personal Dashboard.  What do you want to do?</p>

	 
<?php }

function tc_add_visit_site_widget() {
	?>
		<div style="text-align: center; margin-bottom: 25px;">
			<p style="margin-bottom: 25px; font-size: 20px;">Go back and view the Website</p>
			<a href="<?php echo site_url(); ?>" class="button button-primary button-hero">View Site</a></li>
		</div>

	<?php
}