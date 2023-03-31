<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://rishabh.com
 * @since      1.0.0
 *
 * @package    Subscribe_Me
 * @subpackage Subscribe_Me/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Subscribe_Me
 * @subpackage Subscribe_Me/public
 * @author     Rishabh <rishabh.pandey@wisdmlabs.com>
 */
class Subscribe_Me_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Subscribe_Me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Subscribe_Me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/subscribe-me-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Subscribe_Me_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Subscribe_Me_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/subscribe-me-public.js', array( 'jquery' ), $this->version, false );

	}

	public function email_shortcode() {
		add_shortcode( 'email-button', array($this, 'html_of_subscribe') );
	}

	public function html_of_subscribe() {
		
		ob_start();
		require_once ( PLUGIN_PATH . 'public/partials/subscribe-me-public-display.php');
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function email_add_shortcode() {
		echo do_shortcode( '[email-button]' );
		$this->verify_email();
	}

	public function verify_email() {

		if( isset( $_POST[ 'email' ] ) ) {

			$email = sanitize_email( $_POST[ 'email' ] );
			$pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

			if( preg_match( $pattern, $email ) ) {

				if ( isset( $_POST[ 'submit' ] ) ) {

					$subscribed_mails = get_option( 'subscribed_mails' );

					if( !$subscribed_mails ) {
						$subscribed_mails = array();
					}
					if (in_array( $email, $subscribed_mails ) ) {
						echo '<script>alert( "You are already subscribed!" );</script>';
					}
					else {
						$subscribed_mails[] = $email;
						update_option( 'subscribed_mails', $subscribed_mails );
						echo '<script>alert( "You have been subscribed successfully!");</script>';
						$this->send_mail( $email );
					}
				}
			}
			else {
				echo '<script>alert( "Please enter a valid email!" );</script>';
			}
		}
	}

	public function send_mail( $to ) {

		$subject = 'Congratulations! You are subscribed';
		$body = 'You have been subscribed successfully.';
		$headers = array (
			'From: rishabh.pandey@wisdmlabs.com',
			'Content-Type: text/html; charset=UTF-8'
		);

		wp_mail($to, $subject, $body, $headers);
	}
}
