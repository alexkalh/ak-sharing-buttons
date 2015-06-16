<?php
/*
Plugin Name: AK Sharing Buttons
Description: Ajax load and append a list of sharing button to single-post, static-page. Ex: facebook, twitter, pinterst, google-plus, linkedin.
Version: 1.0.0
Author: Colours Theme
Author URI: http://colourstheme.com
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

AK Sharing Buttons plugin, Copyright 2014 Kopatheme.com
AK Sharing Buttons is distributed under the terms of the GNU GPL.

Requires at least: 4.1
Tested up to: 4.2.2
Text Domain: ak-sharing-buttons
Domain Path: /languages/
*/

define('AKSB_IS_DEV', true);
define('AKSB_SECURITY_KEY', '9oupd.YEHkX$B$PtGeS2rkOSbtX/.EB9g/');
define('AKSB_DIR_URL', plugin_dir_url(__FILE__));
define('AKSB_DIR_PATH', plugin_dir_path(__FILE__));

add_action('plugins_loaded', array('AK_Sharing_Buttons', 'plugins_loaded'));	
add_action('after_setup_theme', array('AK_Sharing_Buttons', 'after_setup_theme'), 11);	


class AK_Sharing_Buttons {

	function __construct(){		
		if(!is_admin()){
				add_action('loop_start', array($this, 'loop_start'));
				add_action('loop_end', array($this, 'loop_end'));				
				add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
				add_action('wp_footer', array($this, 'add_security_key'));							
		}

		add_action('wp_ajax_aksb_load_sharing_buttons', array($this, 'load_sharing_buttons'));
		add_action('wp_ajax_nopriv_aksb_load_sharing_buttons', array($this, 'load_sharing_buttons'));					
	}

	public static function plugins_loaded(){
		load_plugin_textdomain('ak-sharing-buttons', false, AKSB_DIR_PATH . '/languages/');
	}

	public static function after_setup_theme(){
			new AK_Sharing_Buttons();							
	}	

	public function loop_start($query){
		if($query->is_main_query() && is_singular()){
			add_filter('the_content', array($this, 'add_buttons_wrap'));
		}
	}

	public function loop_end($query){
		if($query->is_main_query()  && is_singular()){
			remove_filter('the_content', array($this, 'add_buttons_wrap'));
		}
	}

	public function add_buttons_wrap($content){		
		$content .= '<div id="aksb-buttons-wrap" class="clearfix"></div>';
		return $content;
	}

	public function add_security_key(){
		wp_nonce_field(AKSB_SECURITY_KEY, 'aksb-sharing-buttons-security');
	}

	public function load_sharing_buttons(){
		check_ajax_referer(AKSB_SECURITY_KEY, 'security');

		$post_id   = isset($_POST['post_id']) ? (int) $_POST['post_id'] : 0;
	
		if($post_id):
			$url   = get_permalink($post_id);
			$title = get_the_title($post_id);
			$thumb = '';

			if(has_post_thumbnail($post_id)){
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');
				if(isset($image[0]) && !empty($image[0])){
					$thumb = $image[0];
				}				
			}

			?>
				<!-- Twitter -->
				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en"></a>
				<script type="text/javascript">
					!function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
							if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = "//platform.twitter.com/widgets.js";
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, "script", "twitter-wjs");
				</script>

				<!-- Facebook -->
				<div class="fb-like" 
				data-send="false" 
				data-layout="button_count" 
				data-width="200" 
				data-show-faces="true"></div>
				<div id="fb-root"></div>
				<script type="text/javascript">
					(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id))
					return;
					js = d.createElement(s);
					js.id = id;
					js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
					fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));
				</script>

				<!-- Linkedin -->
				<script type="IN/Share" data-counter="right"></script>       
				<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>

				<!-- Pinterest -->
				<?php $pinterest_url = sprintf('http://pinterest.com/pin/create/button/?url=%s&media=%s&description=%s', esc_url($url), esc_url($thumb), esc_attr( $title)); ?>
				<span class="pin-it">
					<a href="<?php echo esc_url($pinterest_url); ?>" 
						class="pin-it-button" 
						count-layout="horizontal"></a>
				</span>
				<script type="text/javascript" src="http://assets.pinterest.com/js/pinit.js"></script>				

				<!-- Google Plus -->
				<div class="g-plusone" data-size="medium"></div>
				<script type="text/javascript">
					(function() {
						var po = document.createElement('script');
						po.type = 'text/javascript';
						po.async = true;
						po.src = 'https://apis.google.com/js/plusone.js';
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(po, s);
					})();
				</script>				
			<?php
		endif;

		exit();
	}

	public function enqueue_scripts(){		
		$suffix = AKSB_IS_DEV ? '' : '.min';
		wp_enqueue_style('aksb-style', AKSB_DIR_URL . "/css/style{$suffix}.css", array(), NULL);
    wp_enqueue_script('aksb-script', AKSB_DIR_URL . "/js/script{$suffix}.js", array('jquery'), FALSE, TRUE);
    wp_localize_script('aksb-script', 'aksb', array(
			'url'     => admin_url('admin-ajax.php'),
			'post_id' => is_singular() ? get_queried_object_id() : 0
    ));
	}
}