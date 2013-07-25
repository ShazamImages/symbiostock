<?php
/**
 * symbiostock functions and definitions
 *
 * @package symbiostock
 * @since symbiostock 1.0
 */
/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since symbiostock 1.0
 */

//ini_set('display_errors',1);
 
//define some paths for easy working
//remove code editing ability
//define('DISALLOW_FILE_EDIT', TRUE);
//http constants
$symbiostock_template_directory = get_bloginfo('template_directory');
define('symbiostock_CLASSDIR', $symbiostock_template_directory . '/inc/classes' );
define('symbiostock_IMGDIR', $symbiostock_template_directory . '/img' );
define('symbiostock_HEADERDIR', $symbiostock_template_directory . '/img/header' );
define('symbiostock_JSDIR', $symbiostock_template_directory . '/js' );
define('symbiostock_CSSDIR', $symbiostock_template_directory . '/css' );
//branding - shows up a lot in the theme, so we make some constants for that
define('symbiostock_LOGO', symbiostock_IMGDIR . '/symbiostock_logo.png');
define('symbiostock_LOGOSMALL', symbiostock_IMGDIR . '/symbiostock_logo_small.png');
define('symbiostock_32_DEFAULT', symbiostock_IMGDIR . '/32_default.jpg');
define('symbiostock_128_DEFAULT', symbiostock_IMGDIR . '/128_default.jpg');
//filepath constants 
$symbiostock_theme_root = get_theme_root() . '/symbiostock';
define('symbiostock_STOCKDIR', ABSPATH . 'symbiostock_rf/' );
define('symbiostock_NETDIR', ABSPATH . 'symbiostock_network/');
define('symbiostock_MARKETROOT', $symbiostock_theme_root . '/inc/classes/marketing/');
define('symbiostock_CLASSROOT', $symbiostock_theme_root . '/inc/classes/' );
define('symbiostock_INCLUDESROOT', $symbiostock_theme_root . '/inc/' );
define('symbiostock_NETWORK_MANAGER', $symbiostock_theme_root . '/inc/classes/network-manager/' );
define('symbiostock_CSSROOT', $symbiostock_theme_root . '/css/' );
define('symbiostock_TMPROOT', $symbiostock_theme_root . '/tmp/' );
//setup databases after activation - 

//this function sets simplifies our URL to remove http and www
if(!function_exists('ss_url_key')){
function ss_url_key($site){		
		$urlParts = parse_url($site);	
		$domain = preg_replace('/^www\./', '', $urlParts['host']);		
		return $domain . $urlParts['path'];
	}
}

//This variable is our simplified domain location used in referrals
define('SSREF', '?r='.  home_url( ) );


add_action('after_switch_theme', 'symbiostock_installer');
function symbiostock_installer(){
	
	/**
	* Install Theme Databases..
	*/
	require( get_template_directory() . '/inc/installer/installer.php' );
	
	}
 
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */
if ( ! function_exists( 'symbiostock_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since symbiostock 1.0
 */
function symbiostock_setup() {
	
	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );
	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );
	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );
	/**
	 * WordPress.com-specific functions and definitions
	 */
	//require( get_template_directory() . '/inc/wpcom.php' );
	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on symbiostock, use a find and replace
	 * to change 'symbiostock' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'symbiostock', get_template_directory() . '/languages' );
	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );
	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	/**
	 * Get Our Image Sizes
	 */
if ( function_exists( 'add_image_size' ) ) { 	
	add_image_size( 'homepage-thumb-cropped', 220, 135, true ); // 220 pixels wide by 135 pixels tall, hard crop mode
	
	add_image_size( 'homepage-thumb-proportional', 220, 220, true ); // soft crop mode
	
	add_image_size( 'mini-thumb', 60, 60, true ); // 60 pixels wide by 60 pixels tall, hard crop mode
}
	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // symbiostock_setup
add_action( 'after_setup_theme', 'symbiostock_setup' );
/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since symbiostock 1.0
 */
function symbiostock_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Sidebar', 'symbiostock' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	
	//Home page, above content area (typically for a slide show)
	register_sidebar( array(
		'name' => __( 'Home Page (Above Content)', 'symbiostock' ),
		'id' => 'home-page-above-content',
		'before_widget' => '<div class="home-above-content"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<div class="row-fluid"><h3 class="featured-posts span12">',
		'after_title' => '</h3></div>',
	) );
	//home page beside content area, such as for a sidebar type content, or CTA
		register_sidebar( array(
		'name' => __( 'Home Page (Beside Content)', 'symbiostock' ),
		'id' => 'home-page-beside-content',
		'before_widget' => '<div class="home-beside-content"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<div class="row-fluid"><h3 class="featured-posts span12">',
		'after_title' => '</h3></div>',
	) );
	
	//Home page below content (for featured images)		
		register_sidebar( array(
		'name' => __( 'Home Page (Below Content)', 'symbiostock' ),
		'id' => 'home-page-below-content',
		'before_widget' => '<div class="row-fluid home-below-content"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<div class="row-fluid"><h3 class="featured-posts span12">',
		'after_title' => '</h3></div>',
	) );
	
		//Call To Action Widgets
		register_sidebar( array(
		'name' => __( 'Home Page Bottom Row 1/3', 'symbiostock' ),
		'id' => 'cta-1',
		'before_widget' => '<div class="symbiostock-cta span4"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
		register_sidebar( array(
		'name' => __( 'Home Page Bottom Row 2/3', 'symbiostock' ),
		'id' => 'cta-2',
		'before_widget' => '<div class="symbiostock-cta span4"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
		register_sidebar( array(
		'name' => __( 'Home Page Bottom Row 3/3', 'symbiostock' ),
		'id' => 'cta-3',
		'before_widget' => '<div class="symbiostock-cta span4"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
		
		//author page widgets 
	
		//Author Page page below content (for featured images)		
		register_sidebar( array(
		'name' => __( 'Author Page (Below Content)', 'symbiostock' ),
		'id' => 'author-page-below-content',
		'before_widget' => '<div class="row-fluid author-below-content"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<div class="row-fluid"><h3 class="featured-posts span12">',
		'after_title' => '</h3></div>',
	) );
			register_sidebar( array(
		'name' => __( 'Author Page (Sidebar)', 'symbiostock' ),
		'id' => 'author-page-sidebar',
		'before_widget' => '<div class="row-fluid author-sidebar"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<div class="row-fluid"><h3 class="featured-posts span12">',
		'after_title' => '</h3></div>',
	) );					
		
		//image page widget areas	
		
		register_sidebar( array(
		'name' => __( 'Image Page Side', 'symbiostock' ),
		'id' => 'image-page-side',
		'before_widget' => '<div class="well image-page-widget-side"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
		
		register_sidebar( array(
		'name' => __( 'Image Page Bottom', 'symbiostock' ),
		'id' => 'image-page-bottom',
		'before_widget' => '<div class="well image-page-widget-bottom"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );
			
		register_sidebar( array(
		'name' => __( 'Image Page Bottom Fullwidth', 'symbiostock' ),
		'id' => 'image-page-bottom-fullwidth',
		'before_widget' => '<div class="row-fluid image-page-widget-bottom-fullwidth"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside></div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		) );	
	//footer sidebars
	
		register_sidebar(array(
		'name'=>'Footer 1/3',
		
		'before_widget' => '<div class="footer_section span4">',
			
		'after_widget' => "</div>\n",
		
		'before_title' => '',
		
		'after_title' => "",
		));	
		
		
		register_sidebar(array(
		'name'=>'Footer 2/3',
		
		'before_widget' => '<div class="footer_section span4">',
			
		'after_widget' => "</div>\n",
		
		'before_title' => '',
		
		'after_title' => "",
		));	
		
		
		register_sidebar(array(
		'name'=>'Footer 3/3',
		
		'before_widget' => '<div class="footer_section span4">',
		
		'after_widget' => "</div>\n",
		
		'before_title' => '',
		
		'after_title' => "",
		));	
		
}
add_action( 'widgets_init', 'symbiostock_widgets_init' );
/**
 * Enqueue scripts and styles
 */
function symbiostock_scripts() {
    if (!is_admin()) {	
	
		wp_enqueue_style( 'style', get_stylesheet_uri() );
		
	    //bootstrap
        wp_register_script('symbiostock_bootstrap_js', symbiostock_JSDIR . '/bootstrap.min.js', array('jquery'), '1.0', false );
        wp_enqueue_script('symbiostock_bootstrap_js');
        //modernizr
        wp_register_script('modernizr', symbiostock_JSDIR . '/modernizr.js', array('jquery'), '2.6.2');
        wp_enqueue_script('modernizr'); // Enqueue it!
        //scripts
        wp_register_script('symbiostock_scripts', symbiostock_JSDIR . '/scripts.js', array('jquery'), '2.6.2');
        wp_enqueue_script('symbiostock_scripts'); // Enqueue it!
	
		//other scripts
		
		wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );
	
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	
		if ( is_singular() && wp_attachment_is_image() ) {
			wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
		}
		
		//custom scripts for image search page -
		if(is_tax( 'image-tags' ) || is_tax( 'image-type' ) || (is_search() && get_query_var( 'post_type' ) == 'image')){
				
			wp_register_script('search-results', symbiostock_JSDIR . '/search-results.js', array('jquery'), '2.6.2');
	
			wp_enqueue_script('search-results'); // Enqueue it!
		
		}
		function symbiostock_header_js(){
			?>
			<script type="text/javascript">
			var symbiostock_large_loader = "<?php echo symbiostock_IMGDIR . '/loading-large.gif' ?>";
			
			//tracking 
			jQuery(document).ready(function ($) {
				var _host = "<?php echo SSREF ?>";				
				$('a.ssref').on('click', function () {					
					var _ref_url = $(this).attr('href') + _host;
					$(this).attr( 'href', _ref_url );
				});
			});		
					
			</script>
			<?php
		}
		// Add hook for admin <head></head>
		add_action( 'wp_head', 'symbiostock_header_js' );
		//if buddypress is installed
		
	
	}
	
}
//separate content from addon-stuff that other plugins do
function symbiostock_sep_content($content) {
	if(!is_feed() && !is_home()) {
		
		$type = get_post_type( $post );
		
		if($type=='image'){
		
			$content = '<div class="content-wrap"><hr />' . $content . '<hr /></div>';
		
		}
	}
	return $content;
}
add_filter('the_content', 'symbiostock_sep_content', 1);
//custom login functions
function symbiostock_is_login_page() {
    return !strncmp($_SERVER['REQUEST_URI'], '/wp-login.php', strlen('/wp-login.php'));
}
if(symbiostock_is_login_page()){
	
	
	function symbiostock_login_stylesheet() { ?>
        <link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo symbiostock_CSSDIR . '/style-login.css'; ?>" type="text/css" media="all" />
        <?php 
	}
	
	add_action( 'login_enqueue_scripts', 'symbiostock_login_stylesheet' );
	
	function symbiostock_login_logo() {
		
		$default = symbiostock_IMGDIR . '/site-login-logo.png';
		
		$symbiostock_login_logo = get_option('symbiostock_login_logo_link', $default );;
		
		if(empty($symbiostock_login_logo)){
			$symbiostock_login_logo = $default;
			}
		
		?>
	<style type="text/css">
		body.login div#login h1 a {
			background-image: url(<?php echo $symbiostock_login_logo ?>);
			padding-bottom: 30px;
		}
	</style>
	<?php }
	add_action( 'login_enqueue_scripts', 'symbiostock_login_logo' );
	
		function sybiostock_login_logo_url() {
		return get_bloginfo( 'url' );
	
	}
	add_filter( 'login_headerurl', 'sybiostock_login_logo_url' );
	
	function symbiostock_login_logo_url_title() {
		return get_option('symbiostock_my_network_description', get_bloginfo( 'description' ));
	}
	add_filter( 'login_headertitle', 'symbiostock_login_logo_url_title' );
	
}
/**
 * Sets up filters for basic functionality and viewing
 *
 * @since symbiostock 1.0
 */
add_filter('excerpt_length', 'symbiostock_excerpt_length');
function symbiostock_excerpt_length($length) {
	return 20; 
}
add_filter('excerpt_more', 'symbiostock_excerpt_more'); 
function symbiostock_excerpt_more($more) {
	
    global $post;
	
    return ' ... <a class="read-more" href="'. get_permalink($post->ID) . '"> See More &raquo;</a>';
	
}
function symbiostock_admin_bar_remove() {
        global $wp_admin_bar;
        /* Remove WP Logo */
        $wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'symbiostock_admin_bar_remove', 0);
add_action( 'wp_enqueue_scripts', 'symbiostock_scripts' );
//symbiostock_product_attachments, symbiostock_delete_cleanup, symbiostock_product_delete
//are all used in a complete deleletion of files when an image post is deleted
//this gets all attachment ids for post
function symbiostock_product_attachments($post_id){
		
		$attachments_to_delete = array();
			
			$args = array(
			'post_type' => 'attachment',
			'numberposts' => null,
			'post_status' => null,
			'post_parent' => $post_id,
		); 
		
		$attachments = get_posts($args);
			
		if ($attachments) {
			foreach ($attachments as $attachment) {
	
			   array_push($attachments_to_delete, $attachment->ID);
			}
		}	
		
		return $attachments_to_delete;
	}
//during image deletion, we tidy up by removing attachments
add_action( 'wp_trash_post', 'symbiostock_delete_cleanup' );
function symbiostock_delete_cleanup($post_id){
	
	$type = get_post_type($post_id);
	
	if($type == 'image'){
		
		$attach_ids = symbiostock_product_attachments($post_id);
		
		foreach ($attach_ids as $delete){
			
			//we only want to delete previews, not other attachments
			$preview_check = get_post_meta($delete, 'symbiostock_preview');
							
			if( $preview_check[0] == 'minipic' || $preview_check[0] ==  'preview' || $preview_check[0] ==  'transparency' ){
			
				wp_delete_attachment( $delete, false ); 
			
			}
			}
		
	
		//now delete parent post
		
		wp_delete_post( $post_id, true );
		}
	
	}
//if an image post is deleted, stock image files also get deleted
add_action('delete_post', 'symbiostock_product_delete');
function symbiostock_product_delete($post_id){
		
	$type = get_post_type($post_id);
	
	if($type == 'image'){
		
    $extensions = array('jpg', 'png', 'zip', 'eps');
			
		foreach($extensions as $type){
			
			$file = symbiostock_STOCKDIR . $post_id . '.' . $type;
			$file_promo = symbiostock_STOCKDIR . $post_id . '_promo.jpg';
			
			if(file_exists($file)){
				
				unlink($file);
									
			}
			
			if(file_exists($file_promo)){
			
				unlink($file_promo);
								
			}	
			
			}
		}
	
	}
function symbiostock_filter_post_tag_term_links( $term_links ) {
    $wrapped_term_links = array();
    foreach ( $term_links as $term_link ) {
		
        $wrapped_term_links[] = '<i class="icon-tag"></i> ' . $term_link;
    }	
	
    return $wrapped_term_links;
}
add_filter( 'term_links-post_tag', 'symbiostock_filter_post_tag_term_links' );
//image info specific functions
//WARNING too database intensive. Needs to use get_post_custom() but that function does not seem to play well with serialized data
function symbiostock_post_meta($postid){
	
	$meta_values = array(
		'extensions',
		'collections', 
		'collection_img', 
		'related_images', 
		'author', 
		'live', 
		'size_info',
		'price_bloggee', 
		'price_small',
		'price_medium', 
		'price_large', 
		'price_vector', 
		'price_zip', 
		'locked', 
		
		'symbiostock_rating',
		'symbiostock_rank',
		
		'discount_percent', 
		'exclusive', 
		'symbiostock_minipic', 
		'symbiostock_preview',
		'symbiostock_transparency',	
		'size_eps', 
		'size_zip',
		'symbiostock_bloggee_available',			
		'symbiostock_small_available',			
		'symbiostock_medium_available',			
		'symbiostock_large_available',			
		'symbiostock_vector_available',			
		'symbiostock_zip_available',
		'symbiostock_model_release',
		'symbiostock_property_release',
		
		'symbiostock_referral_link_1',
		'symbiostock_referral_link_2',
		'symbiostock_referral_link_3',
		'symbiostock_referral_link_4',
		'symbiostock_referral_link_5',
		
		'symbiostock_referral_label_1',
		'symbiostock_referral_label_2',
		'symbiostock_referral_label_3',
		'symbiostock_referral_label_4',
		'symbiostock_referral_label_5',
	);
	
	$image_meta = array();
	
	foreach ($meta_values as $meta_value){
				
		$image_meta[$meta_value] = get_post_meta($postid, $meta_value);
		
		}
	
	$image_meta['id'] = $postid;	
	
	return $image_meta;
		
	}
function symbiostock_get_user_files($user_id=''){
		
		if(empty($user_id)){
			global $current_user;
     		get_currentuserinfo();
			
			$user_id = $current_user->ID;
		} 
		$user_products = get_user_meta($user_id , 'symbiostock_purchased_products'); 
		
		$user_products = unserialize($user_products[0]);		
		
		return $user_products;
	}	
function symbiostock_network_info(){
	
	$network_values = array(	
		'symbiostock_my_network_name',
		'symbiostock_my_network_description',
		'symbiostock_my_network_avatar',
		'symbiostock_my_network_logo',
		'symbiostock_my_network_about_page',
		'symbiostock_my_network_announcement',
		'symbiostock_use_network',		
	);
	
	$network_info = array();
	
	foreach ($network_values  as $network_value){
				
		$network_info[$network_value] = get_option($network_value);
		
		}	
	
	return $network_info;
		
	}
//customer page is generated on setup. We retrieve this at various parts of site
function symbiostock_customer_area_link(){
	
	$customer_page_id = get_option('symbiostock_customer_page'); 
	
	$permalink =  get_permalink( $customer_page_id );
	
	return $permalink;
	
}	
function symbiostock_customer_area($text, $btn = false){
	
	if($btn == true){
		
		$btn_class="btn btn-success alignright";
		
		}
	
	$customer_page_id = get_option('symbiostock_customer_page'); 
	
	$permalink =  get_permalink( $customer_page_id );
	
	$customer_page_link = '<a class="' . $btn_class . '" title="' . $text. '" href="' . $permalink . '"><i class="icon-shopping-cart"> </i> ' . $text . '</a>';
	return $customer_page_link;
	
}	
//customer login page is generated on setup. We retrieve this at various parts of site
function symbiostock_customer_login($text){
	
	$login_page_id = get_option('symbiostock_login_page'); 
	
	$permalink =  get_permalink( $login_page_id );
	
	$login_page_id_link = '<a title="' . $text. '" href="' . $permalink . '"><i class="icon-file"> </i> ' . $text . '</a>';
	return $login_page_id_link;
	
}	
function symbiostock_eula($text, $linkonly = false){
	
	$symbiostock_eula_page = get_option('symbiostock_eula_page'); 
	

	$permalink =  get_permalink( $symbiostock_eula_page );
	if($linkonly == true)
		return $permalink;
		
	$customer_login_page_link = '<a title="' . $text. '" href="' . $permalink . '"><i class="icon-lock"> </i> ' . $text . '</a>';
	return $customer_login_page_link;
	
}
function symbiostock_network($text, $linkonly = false){
	
	$symbiostock_network_page = get_option('symbiostock_network_page'); 
	
	$permalink =  get_permalink( $symbiostock_network_page );
	
	if($linkonly == true){		
		return $permalink;		
		}
		
	$page_link = '<a title="' . $text. '" href="' . $permalink . '"><i class="icon-group"> </i> ' . $text . '</a>';
	return $network_page_link;
	
}	
function symbiostock_directory_link($text = '', $linkonly = false, $small_pic = true){
	
	$symbiostock_directory_page = get_option('symbiostock_directory_page'); 
	
	$permalink =  get_permalink( $symbiostock_directory_page );
	
	if($linkonly == true){		
		return $permalink;		
		}
	
	$small_pic == true ? $size = 32 : $size = 128;
	
	$img = '<img class="img-polaroid" alt="Part of the Symbiostock Network" src = "' . symbiostock_IMGDIR . '/'.$size.'_default.jpg" />';
		
	$directory_page_link = '<a title="' . $text. '" href="' . $permalink . '">'.$img.' ' . $text . '</a>';
	
	return $directory_page_link;
	
}		
function symbiostock_customer_nav_links(){
	if(is_user_logged_in()){	
	   global $current_user;		
 	   get_currentuserinfo();	
	
	
	$name = $current_user->display_name;
	}
	if(!is_user_logged_in()){
		
		$nav_links = '<li data-toggle="modal" data-target="#symbiostock_member_modal" class="login_register">' . symbiostock_customer_login('Login / Register') . '</li>';
				
		} else {
		$nav_links = '<li class="logout"><a href="' . wp_logout_url( get_permalink( ) ) . '" title="Logout">(<i class="icon-key"> </i> Logout)</a></li>';
		$nav_links .= '<li class="license_area">' . symbiostock_customer_area($name) . '</li>';	
		
		
				
		}
		
	return $nav_links;
	
	}
//add a menu item for customer on above header nav
add_filter('wp_nav_menu_items','add_customer_nav', 10, 2);
function add_customer_nav( $nav, $args ) {
	
    if( $args->theme_location == 'above-header-menu' )
	
        return $nav. symbiostock_customer_nav_links();
    return $nav;
}
//set up our symbiostock feed
function symbiostock_feed_display($feed_url, $qty){
		
	$rss = fetch_feed($feed_url);
		if (!is_wp_error( $rss ) ) :
				$maxitems = $rss->get_item_quantity($qty);
			$rss_items = $rss->get_items(0, $maxitems);
			if ($rss_items):
			
				foreach ( $rss_items as $item ) : 
					//instead of a bunch of string concatenation or echoes, I prefer the terseness of printf 
					//(http://php.net/manual/en/function.printf.php)
					printf('<a href="%s">%s</a>%s',$item->get_permalink(),$item->get_title(),$item->get_description() );
				endforeach;
				
			endif;
		endif;
	}
//for validating URLs
function symbiostock_validate_url($url){
	if (filter_var($url, FILTER_VALIDATE_URL)) {
	  return true;
	}
	else {
	  return false;
	}
}
//set up some unique variables for wp_query so that our network search gets parameters properly
function symbiostock_wp_query_vars( $qvars ){		
	global $wp_query;
	$qvars[] = 'symbiostock_network_search'; //is this a network query?
	$qvars[] = 'symbiostock_network_info'; //do we want network info?
	$qvars[] = 'symbiostock_number_results'; //how many search results do we want?
	
	$qvars[] = 'paypal_return_message'; //if returning from paypal, we show a message in user area
	$qvars[] = 'page';
	$qvars[] = 'paged';
	
	//marketing
	$qvars[] = 'ss-' . get_option('marketer_user_number', '88888888');
	$qvars[] = 'type';
	$qvars[] = 'date';
	$qvars[] = 'time';
	$qvars[] = 'image_number';
	
		
	return $qvars;
	}
add_filter('query_vars', 'symbiostock_wp_query_vars');
//the next few functions compensate for what appears to be a pagination bug.
//image searches are sent to taxonomy where results are shown. If no results, 404 is thrown, but 
// we disguise the 404 to be a typical "no results found in search" page.
function symbiostock_modify_query( $query ) {
	if ( ( is_search() && get_query_var( 'post_type' ) == 'image' ) ) {
	/*	
		$encoded_search_term = urlencode(get_query_var('s'));
		
		$home = home_url();
		$params = array( 'image-tags' => $encoded_search_term);
		$redirect = add_query_arg( $params, $home );
		wp_redirect($redirect);
		exit();*/
	
	}
}
//symbiostock_search_pagination_mod filter fixes a horrible pagination bug with this theme. Its a creative work around, and hopefully doesnt trouble us anymore.
//the "paged" variable does not seem to work on search results, but only on archive and taxonomy pages. 
//So this modifies the pagination to use "page" variable instead, which seems to work fine.
add_filter( 'paginate_links', 'symbiostock_search_pagination_mod', 1 );
function symbiostock_search_pagination_mod( $link )
{
    
    if ( is_search() ) {
        
        $pattern = '/page\/([0-9]+)\//';
        
        if ( preg_match( $pattern, $link, $matches ) ) {
            $number = $matches[ 1 ];
            
            $link = remove_query_arg( 'paged' );
            
            $link = add_query_arg( 'page', $number );
            
        } else {
            
            $link = str_replace( 'paged', 'page', $link );
            
        }
        
    }
    return $link;
}
add_action( 'parse_query', 'symbiostock_modify_query' );
function symbiostock_filter_404_title( $title )
{
    if ( is_404() && is_tax( 'image-tags' )) {
        $title = 'No results found. ';
    }
    // You can do other filtering here, or
    // just return $title
    return $title;
}
//this changes the "topics" word to "images" in taxonomy cloud
function symbiostock_category_text( $count )
{
    return sprintf( _n( '%s topic', '%s Images', $count ), number_format_i18n( $count ) );
}
add_filter( 'widget_tag_cloud_args', 'symbiostock_widget_tag_cloud_args' );
function symbiostock_widget_tag_cloud_args( $args )
{
  
    if ( $args[ 'taxonomy' ] == 'image-type' || $args[ 'taxonomy' ] == 'image-tags') {
        $args[ 'topic_count_text_callback' ] = symbiostock_category_text;
    }
    return $args;
}
// Hook into wp_title filter hook
add_filter( 'wp_title', 'symbiostock_filter_404_title', 1 );

//set the results per page depending on if we are doing image search
function symbiostock_image_results_per_page( $query ) {
		$network_search = get_query_var('symbiostock_network_search');
		
		if($network_search != true && !is_admin()){
			$marketer_user_key = get_option('marketer_user_number');	
			$marketer_key = get_query_var( 'ss-' . $marketer_user_key );
						
			isset($marketer_key ) && !empty($marketer_key) ? $per_page = 100 : $per_page = 24;
						
			$per_page = apply_filters('symbiostock_posts_per_page', $per_page);
			
			$query->set('posts_per_page', $per_page);
			return;
		}
}
add_action( 'pre_get_posts', 'symbiostock_image_results_per_page' );

//set the results per page depending on if we are doing image search
function symbiostock_network_results_per_page( $query ) {
		$network_search = get_query_var('symbiostock_network_search');
		
		if($network_search == true){
			$per_page = 24;			
			
			$ipp = get_query_var( 'ipp' );	//ipp is Images Per Page
			isset($_GET['ipp']) && !empty($_GET['ipp']) ? $per_page = $_GET['ipp'] : '';
		
			$query->set('posts_per_page', $per_page);
			return;
			}
}
add_action( 'pre_get_posts', 'symbiostock_network_results_per_page' );

//Symbiostock Decode Entities function
function ssde($text) {
    $text= htmlspecialchars($text); #NOTE: UTF-8 does not work!
    //$text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
    //$text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
	
    return $text;
}
function symbiostock_credit_links( $position )
{
    
    $symbiostock_credit_links = get_option( 'symbiostock_credit_links' );
    
    $links = array(
         'ClipArtIllustration.com - First Symbiostock Site, and home of the Orange Man' => 'http://www.clipartillustration.com',
        'Microstockgroup.com - A meeting place for microstock professionals.' => 'http://www.microstockgroup.com',
        'ClipArtof.com - High Resolution Stock Illustrations &amp; Clip Art' => 'http://www.clipartof.com/',
        'Symbiostock.com - Sell your images and network with fellow microstock professionals.' => 'http://www.symbiostock.com/' 
    );
    
    if ( $position == $symbiostock_credit_links ) {
        
		
        echo '<ul class="nav nav-tabs nav-stacked nav-list">';
       	
        foreach ( $links as $title => $link ) {
            
            $link_parts = explode( '-', $title );
            
            echo '<li><a class="" title="' . trim( $link_parts[ 1 ] ) . '" href="' . $link . '"><i class="icon-double-angle-right"> </i>' . trim( $link_parts[ 0 ] ) . '</a></li>';
            
        }
        
        echo '</ul>';
    }
    
}
//appends an SEO phrase to image titles
function symbiostock_seo_title( $title ) {
	if ( is_single($post) && 'image' == get_post_type() && in_the_loop() ){
		$append = get_option('symbiostock_title_seo_text', '');
		
		$title = $title . ' ' . $append;
	
	}
	return $title;
}
add_filter( 'the_title', 'symbiostock_seo_title', 10, 2 );
function symbiostock_sort_tag_score( $item1, $item2 ) {
	if ( $item1['score'][0] != $item2['score'][0] ) {
		return $item1['score'][0] < $item2['score'][0] ? 1 : -1;
	} else {
		return $item1['score'][1] < $item2['score'][1] ? -1 : 1; // ASC
	}
}
//prevents slug clashes between categories and image keywords by appending '-images' to the category slug.
function symbiostock_unique_category( $term_id, $tt_id, $taxonomy )
{
    
    if ( $taxonomy == 'image-type' ) {
        
        if ( isset( $_POST[ 'slug' ] ) && !empty( $_POST[ 'slug' ] ) ) {
            $name = sanitize_title( $_POST[ 'slug' ] ) . '-images';
        } elseif ( isset( $_POST[ 'tag-name' ] ) && !empty( $_POST[ 'tag-name' ] ) ) {
            $name = sanitize_title( $_POST[ 'tag-name' ] ) . '-images';
        } elseif ( isset( $_POST[ 'newimage-type' ] ) && !empty( $_POST[ 'newimage-type' ] ) ) {
            $name = sanitize_title( $_POST[ 'newimage-type' ] ) . '-images';
        }
        
        wp_update_term( $term_id, $taxonomy, array(
            
             'slug' => $name 
            
        ) );
        
    }
    
}
add_action( 'create_term', 'symbiostock_unique_category', 10, 3 );
//generates copyright notice for website 
function symbiostock_website_copyright(){
	
	$copyright_owner = stripslashes(get_option('symbiostock_copyright_name', ''));	
	
	?>
    <p class="muted">	
    Copyright &copy;
	<?php $the_year = date("Y"); echo $the_year; ?>
	
	<?php echo ' <strong>' . $copyright_owner  . '</strong>, ' . get_bloginfo('url') . ''; ?>
	All Rights Reserved. 
	</p>
	<?php
    $theme_credit = get_option('symbiostock_theme_credit', '');
	
	if(empty($theme_credit) || $theme_credit == 'on' ){
		?>
		<div class="muted">
			<strong>Stock image</strong> and <strong>networking</strong> platform <a href="http://www.symbiostock.com/">SYMBIOSTOCK</a>, by the maker of <a href="http://www.clipartillustration.com/">ClipArtIllustration.com</a>
		</div>    
		<?php
		}
		
	}
//simply brings you to help page and lands on given id #
//
function sshelp($destination_id, $subject){
	//get_home_url(); /wp-admin/profile.php#extended_network_info"
	return '<span class="description"> &bull; info: 
	<a title="See help page: '.$subject.'" href="'.get_home_url().'/wp-admin/admin.php?page=symbiostock-control-options&tab=5symbiostock-help#'.$destination_id.'">'.$subject.'</a>
	</span>';
	
	}
//this converts the name of a network assocate to a unique value: www.mysite.com/my_symbiostock/ becomes "wwwmysitecommysymbiostock"
//which can be used as a folder name or ID.
function symbiostock_website_to_key($website){
	
	$website = preg_replace('#^https?://#', '', $website);
	$website = preg_replace('/^www\./', '', $website);
	
	$key = preg_replace('/[^A-Za-z0-9 ]/', '', $website);
	
	return $key;
	}
	
//Symbiostock shares email addresses, and sometimes they could be harvested if .csv files are searched. This converts them to a string unrecognizeable outside our program.
//http://stackoverflow.com/questions/16314678/php-encode-an-email-address-hide-from-spammers-decode-easily-without-flaws
function symbiostock_email_convert($email, $action = 'encode'){
	if($action == 'decode'){
		//decode email address	
		$email = base64_decode(strtr($email, '-_', '+/'));
		} else {
		//encode email address		
		$email = rtrim(strtr(base64_encode($email), '+/', '-_'), '=');		
	}	
	return $email;	
}	

function symbiostock_list_admins(){
		
		$main_author = get_option('symbiostock_site_author');
		
		$args = array(	
			'role'         => 'Administrator',
		 );
		$admins = get_users( $args );
		
		?><select id="symbiostock_site_author" name="symbiostock_site_author"><?php
		foreach($admins as $admin){
			$main_author == $admin->ID ? $choice = 'selected="selected"' : $choice = '';
			?><option <?php echo $choice; ?> value="<?php echo $admin->ID; ?>"><?php echo $admin->display_name; ?></option> <?php		
			}
		?></select><?php

	}

//checks if current logged in user is the Symbiostock site author
function is_symbiostock_author(){
	$main_author = get_option('symbiostock_site_author');
	
	
	$current_user = wp_get_current_user();
	
	if($main_author != $current_user->ID){
			return false;		
		} else {			
			return true;	
		}
	
	}

//SYMBIOSTOCK SOCIAL STUFF
add_action( 'show_user_profile', 'symbiostock_social_credentials');
add_action( 'edit_user_profile', 'symbiostock_social_credentials');
function symbiostock_social_credentials( $user, $get_fields = false ) { 
	$symbiostock_social_credentials = get_option('symbiostock_social_credentials'); 
	if ( !current_user_can( 'manage_options', $user-ID ) )
		return false;
		
	if(!is_symbiostock_author())		
		return;
		
		
	
	$prfx =  'symbiostock_';
	
	$text_fields = array(				
		'Personal Photo'       => '(URL) - 150 x 150px' . sshelp('personal_photo', 'Profile Photo'),	
		'Gallery Page'         => '(URL)' . sshelp('gallery_page', 'Gallery Page'),
		'Contact Page'         => '(URL)',			
		'Software'             => 'Illustrator, photoshop, 3d Studio Max, etc.',			
		'Equipment'            => 'Cameras, computers, graphic tablets, etc.',			
		'Languages'            => sshelp('languages', 'Languages'),	
		'Clients'              => 'Who you\'ve worked for.',
		'Home Location'        => sshelp('location_info', 'Location'),
		'Temporary Location 1' => sshelp('temporary_location_info', 'Temp Location'),			
		'Temporary Location 2' => '',							
	);
	
	$select_dropdowns = array(
		'Open for Assignment Jobs' => array('No', 'Yes'),	
		'Profession 1'      => array('-', 'Illustrator', 'Photographer', 'Developer', 'Artist', 'Marketing', 'Graphic Design', '3d Design' ),
		'Profession 2'      => array('-', 'Illustrator', 'Photographer', 'Developer', 'Artist', 'Marketing', 'Graphic Design', '3d Design' ),		
		'Portfolio Focus 1' => array('-', 'Photography', 'Vector', '3d Design', 'Digital Painting'),	
		'Portfolio Focus 2' => array('-', 'Photography', 'Vector', '3d Design', 'Digital Painting'),
		'Specialty 1'   => array('-', 'Travel','People','Illustrations','Maps','Cartoon','Nature','Editorial','Landscape','Food','Lifestyle','Backgrounds','Industry', 'Mascot Series'),
		'Specialty 2'   => array('-', 'Travel','People','Illustrations','Maps','Cartoon','Nature','Editorial','Landscape','Food','Lifestyle','Backgrounds','Industry', 'Mascot Series'),
		
		
	);
	
	//this function can also be used to get the expected values array
	if( $get_fields == true){ 
	
	$info = array();
	
	foreach($select_dropdowns as $key => $dropdown){		
		array_push($info, $prfx . strtolower(str_replace(' ', '_', $key)));		
		}
	foreach($text_fields as $key => $text_field){		
		array_push($info, $prfx . strtolower(str_replace(' ', '_', $key)));		
		}		
	//returns info, aborts function
	
	
	return $info;
	}		
	
	
	
	$credentials = get_option('symbiostock_social_credentials');		
	?>
	<h2 id="extended_network_info">Symbiostock Profile and Extended Network Info</h2><?php echo  sshelp('symbiostock_profile', 'Your profile and network symbiocard'); ?>
	<table class="form-table">		
        	
		<?php	
			
		foreach($text_fields as $key => $text){			
			
			$name_id = $prfx . strtolower(str_replace(' ', '_', $key));				
				
			!empty($credentials[$name_id]) ? $value = stripslashes(trim($credentials[$name_id])) : $value = '';

				?>                
                <tr>
                    <th><label for="<?php echo $name_id; ?>"><?php echo $key; ?></label></th>                
                    <td>
                    
                    	<?php
						//if URL field, validate
						if (strpos($text,'URL') && !empty($value)) {
							
							if(!symbiostock_validate_url($value)){
								
								echo '<p class="error"><strong>Invalid URL for ' . $key  . '. Please try again.</strong></p>';
								
								$value = '';
							}
							
						}											
						?>
                        
                		<input type="text" name="<?php echo $name_id; ?>" id="<?php echo $name_id; ?>" value="<?php echo $value; ?>" class="regular-text" />
                        <span class="description"><?php echo $text; ?></span>
                    </td>
                </tr>                
                <?php				
			}
		
		foreach ($select_dropdowns as $key => $options){
			$name_id = $prfx . strtolower(str_replace(' ', '_', $key));			
									
			?>
                <tr>
                    <th><label for="<?php echo $name_id; ?>"> <?php echo $key; ?></label> </th>                
                    <td>
                		<select id="<?php echo $name_id ?>" name="<?php echo $name_id; ?>" class="regular-text">                        
                        <?php						
						foreach($options as $option){
							
							$option == $credentials[$name_id] ? $selected = 'selected="selected"' : $selected = '';
														
							?> <option <?php echo $selected; ?> value="<?php echo $option; ?>"><?php echo $option; ?></option> <?php							
							}
						?>                        
                        </select><br />
                    </td>
                </tr>                            
            <?php			
			}		
			?>        
		<input type="hidden" name="symbiostock_social_credentials" value="1" />
	</table>
<?php }
add_action( 'personal_options_update', 'symbiostock_update_social_credentials' );
add_action( 'edit_user_profile_update', 'symbiostock_update_social_credentials' );
function symbiostock_update_social_credentials($user){
	
	if ( !current_user_can( 'manage_options', $user-ID ) )
		return false;
	
	if(!is_symbiostock_author())		
		return;
	
	
	$options = symbiostock_social_credentials( $user, true );
	
	$symbiostock_social_credentials = array();
	
	foreach($options as $option){
	
		if(isset($_POST[$option]) && $_POST[$option] != '-' &&  !empty($_POST[$option])){
				//add to our symbiostock_social_credentials, which will be saved for profile and network use
				$symbiostock_social_credentials[$option] = trim($_POST[$option]);						
			}			
		}
		
	isset($_POST['first_name']) && !empty($_POST['first_name'])?$symbiostock_social_credentials['symbiostock_first_name'] = trim($_POST['first_name']):$symbiostock_social_credentials['symbiostock_first_name'] = '';
	isset($_POST['last_name']) && !empty($_POST['last_name'])?$symbiostock_social_credentials['symbiostock_last_name'] = trim($_POST['last_name']):$symbiostock_social_credentials['symbiostock_last_name'] = '';
	//isset($_POST['nickname']) && !empty($_POST['nickname'])?$symbiostock_social_credentials['symbiostock_nickname'] = trim($_POST['nickname']):$symbiostock_social_credentials['symbiostock_nickname'] = '';
	isset($_POST['url']) && !empty($_POST['url'])?$symbiostock_social_credentials['symbiostock_alternate_url'] = trim($_POST['url']):$symbiostock_social_credentials['symbiostock_alternate_url'] = '';
	isset($_POST['description']) && !empty($_POST['description'])?$symbiostock_social_credentials['symbiostock_author_bio'] = trim($_POST['description']):$symbiostock_social_credentials['symbiostock_author_bio'] = '';
	
		
	update_option('symbiostock_social_credentials', $symbiostock_social_credentials);
	symbiostock_save_network_info();	
}
function symbiostock_get_social_credentials($user){
	
	
	}

//creates image sliders for various needs in the theme
function symbiostock_image_slider( $id = 'sscarousel', $size='preview', $action = 'latest' ){
	
	$images = array();
	
	switch($action){	
		case 'latest':			
			$args = array(        
				'post_type' => 'image',       
				'showposts' => 6,		
			);				
			$images = new WP_Query($args);		
		break;
		
		case 'featured':
			$featured_images_id = get_option('symbiostock_featured_images', '');
			$args = array(						
					'post_type' => 'image',       
					'showposts' => 6,	
					'tax_query' => array(
					array(
						'taxonomy' => 'image-type',
						'field' => 'id',
						'terms' => $featured_images_id,
					)
				)				
			);
			$images = new WP_Query($args);		
		break;		
	}
	$active = true;

	?>
<div class="symbiostock_carousel_<?php echo $size; ?>_container">    
    <div id="<?php echo $id ?>" class="symbiostock_carousel_<?php echo $size; ?> carousel slide span12">
        <ol class="carousel-indicators">
            <li data-target="#<?php echo $id ?>" data-slide-to="0" class="active"></li>
            <li data-target="#<?php echo $id ?>" data-slide-to="1"></li>
            <li data-target="#<?php echo $id ?>" data-slide-to="2"></li>
        </ol>
        <!-- Carousel items -->
        <div class="carousel-inner">
            <?php
            $active = true;
            while ( $images->have_posts() ) : 
                    $images->the_post();	
                
                $size == 'minipic' ? $img = get_post_meta(get_the_ID(), 'symbiostock_minipic') : '';
                $size == 'preview' ? $img = get_post_meta(get_the_ID(), 'symbiostock_preview') : '';
                
                if($active == true){
                        $active = false;
                        $class = 'active ';
                    } else {
                        $class = '';	
                    }
                ?><div class="<?php echo $class; ?>item ">            
                <a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><img src="<?php echo $img[0]; ?>" alt="<?php the_title(); ?>" /></a>
                <?php if($size == 'preview'):	?>
                <div class="carousel-caption">
                    <p><?php the_title(); ?></p>               
                </div>
                <?php endif; ?>            
                </div> <?php	
                
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
        <!-- Carousel nav --> 
        <a class="carousel-control left" href="#<?php echo $id ?>" data-slide="prev">&lsaquo;</a> <a class="carousel-control right" href="#<?php echo $id ?>" data-slide="next">&rsaquo;</a> 
    </div>
</div>
<?php	
}

//
function symbiostock_slider_shorttag( $atts ){
	if(empty($atts['id']) || empty($atts['size']) || empty($atts['action'])){
		return;
		}
 symbiostock_image_slider( $atts['id'], $atts['size'], $atts['action']);
}
add_shortcode( 'ss-slider', 'symbiostock_slider_shorttag' );	
/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Get symbiostock Menus
 */
require_once('inc/menus.php');
/**
 * Get symbiostock Widgets
 */
 
require_once('inc/classes/widgets.php');
/**
 * Get symbiostock Carousel
 */
 
require_once('inc/classes/symbiostock_carousel.php');
/**
 * Get symbiostock Admin Area
 */
 
require_once('inc/classes/admin.php');
/**
 * Get Image Custom Post Functions
 */
 
require_once('inc/rf-custom-post-functions.php');
/**
 * Get the cart
 */
 
require_once('inc/classes/cart/cart.php');
/**
 * Get symbiostock frontend ajax
 */
require_once('inc/classes/symbiostock_ajax_frontend.php');

//get our interpreter class, for displaying network data and search results
require_once(symbiostock_NETWORK_MANAGER . '/network-manager.php');
//added support for other plugins 
//http://wordpress.org/extend/plugins/gecka-terms-thumbnails/
//category thumbnails
if( function_exists('add_term_thumbnails_support') )
add_term_thumbnails_support ('image-type');
//http://wordpress.org/extend/plugins/gecka-terms-thumbnails/
//category thumbnails
//get any number of symbiostock feeds 
function symbiostock_feed($type = 'rss_url', $format = 'link', $fetchwhat = 'new-images'){
	
	$feed = get_bloginfo( $type );
	
	switch($fetchwhat){
	
	case 'new-images':	
	$feed = add_query_arg( array('post_type' => 'image'), $feed);	
	break;
	case 'image-type':
	$term = get_term_by( 'slug', get_query_var( 'image-type' ),  'image-type' );	
	$feed = add_query_arg( array('image-type' => $term->slug), $feed);	
	break;
	
	case 'image-tags':
	$term = get_term_by( 'slug', get_query_var( 'image-tags' ),  'image-tags' );	
	$feed = add_query_arg( array('image-tags' => $term->slug), $feed);	
	break;		
	
	}
	if($format=='link'){
		return $feed;
	} elseif ($format=='icon'){
		return '<small><a class="muted" title="RSS" href="'.$feed.'"><i class="icon-rss">&nbsp;</i></a></small>';
		}
	}
	
//include the author-box function. Its so big it gets its own file!	
require_once('symbiostock_author_box.php');
//misc image processing functions 
function symbiostock_reprocess_image( $post_id, $promo = false, $size = 590) {
	global $post;
	global $typenow;
	$post_type_bulk = $typenow;
		
	if($post->post_type = 'image' || $post_type_bulk = 'image' && !isset($_POST['symbiostock_update_images']))
		
	//sometimes people have images of obnoxiously huge size, so we up memory to obnoxiously huge limit
	ini_set( "memory_limit", "1024M" );
	//set the time limit for five minutes in case theres a lot of images
	set_time_limit( 300 );
	
	$attachment_id = get_post_meta($post_id , 'symbiostock_preview_id');
	
	$file_attachment_path = get_attached_file( $attachment_id[0] );
		
	include_once( symbiostock_CLASSROOT . 'image-processor/symbiostock_image_processor.php' );
	
	$watermark_path = symbiostock_get_watermark_path();
	
	$stockdir = symbiostock_STOCKDIR;
	
	$tmp = symbiostock_TMPROOT;	
	
	if (file_exists($stockdir . $post_id . '.jpg')) {
		$file = $stockdir . $post_id . '.jpg';
		$meta = true;
		$ext = '.jpg';
	} else if(file_exists($stockdir . $post_id . '.png')){
		
		//if this is a promo image, we must abort because png files don't do IPTC
		if($promo == true)
			return;
		
		$file = $stockdir . $post_id . '.png';
		$meta = false;	
		$ext = '.png';	
	} else {
		return;
	}
	
	//first generate a new preview, then save it to tmp
	$image = wp_get_image_editor( $file );            
	$image->resize(  $size,  $size );			
	$image->set_quality( 100 );            
	$image->save( $tmp . $post_id . '.jpg' );
	
	if($promo == false){	
		//watermark the image
		symbiostock_watermark_image( 
			$tmp . $post_id . '.jpg', 
			$tmp . $post_id . '.jpg', 
			$watermark_path 
		);	
	}
	
	//update its meta
	symbiostock_update_meta( 
		$file, 
		$tmp . $post_id . '.jpg', 
		$tmp . $post_id . '.jpg', 
		$post_id 
	);	
	//copy it
	
	if($promo == true){
		//if promo it sits in our protected directory as an assumed promo image (passed through protected URL)
		if ( !copy($tmp . $post_id . '.jpg', $stockdir . $post_id . '_promo.jpg' )){
    		echo "failed to copy $file...\n";
		}
	} else {
		//if it is watermarked, we over-write its preview		
		if ( !copy($tmp . $post_id . '.jpg', $file_attachment_path )){
			echo "failed to copy $file...\n";
		}
	}
	
	//delete temp image
	if(file_exists($tmp . $post_id . '.jpg')){
		unlink($tmp . $post_id . '.jpg');	
	} elseif (file_exists($tmp . $post_id . '.png')){
		unlink($tmp . $post_id . '.jpg');
		}
}

if(is_admin()){
//for changing image sizes	
function symbiostock_change_image_sizes($image_id, $bloggee_size, $small_size, $medium_size){
	
		include_once(symbiostock_CLASSROOT . 'image-processor/symbiostock_image_processor.php');		
		
		if(file_exists(symbiostock_STOCKDIR . $image_id . '.jpg')){
			
			$image_file = symbiostock_STOCKDIR . $image_id . '.jpg';
		
		} elseif(file_exists(symbiostock_STOCKDIR . $image_id . '.png')){
			
			$image_file = symbiostock_STOCKDIR . $image_id . '.png';
			
		} else {return;}
		
		$process = new symbiostock_image_processor( true );
		
		$resized = $process->establish_image_sizes($image_file, $bloggee_size, $small_size, $medium_size);
		
		return $resized;
		
	}	
	
}
//for generating image previews, which are used by promoting agencies (optional feature, not used unless specifically evoked)
function symbiostock_promo_image($images){
	//images is an array of post ids which are used to coordate the images
	
	if(empty($images)){
		return;
		}
		
	ini_set( "memory_limit", "1024M" );
	set_time_limit( 0 );	
		
	foreach($images as $image){
		
		symbiostock_reprocess_image( $post_id, false, 600);
		
		}	
	
	}	

//adding custom functionality to the bulk edit screen is not easy with current wordpress. We are using a class developed by FoxRunSoftware
/*
Plugin Name: FoxRunSoftware Custom Bulk Action Demo
Plugin URI: http://www.foxrunsoftware.net/articles/wordpress/add-custom-bulk-action/
Description: A working demonstration of a custom bulk action
Author: Justin Stern
Author URI: http://www.foxrunsoftware.net
Version: 0.1
	Copyright: © 2012 Justin Stern (email : justin@foxrunsoftware.net)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/
if(is_admin){
	if (!class_exists('symbiostock_reprocess_images')) {
	 
		class symbiostock_reprocess_images {
			
			public function __construct() {
				
				if(is_admin()) {
					// admin actions/filters
					add_action('admin_footer-edit.php', array(&$this, 'custom_bulk_admin_footer'));
					add_action('load-edit.php',         array(&$this, 'custom_bulk_action'));
					add_action('admin_notices',         array(&$this, 'custom_bulk_admin_notices'));
				}
			}
			
			
			/**
			 * Step 1: add the custom Bulk Action to the select menus
			 */
			function custom_bulk_admin_footer() {
				global $post_type;
				
				if($post_type == 'image') {
					?>
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery('<option>').val('reprocess').text('<?php _e('Reprocess')?>').appendTo("select[name='action']");
								jQuery('<option>').val('reprocess').text('<?php _e('Reprocess')?>').appendTo("select[name='action2']");
								jQuery('<option>').val('makepromo').text('<?php _e('Make Promo Preview')?>').appendTo("select[name='action']");
								jQuery('<option>').val('makepromo').text('<?php _e('Make Promo Preview')?>').appendTo("select[name='action2']");								
							});
						</script>
					<?php
				}
			}
			
			
			/**
			 * Step 2: handle the custom Bulk Action
			 * 
			 * Based on the post http://wordpress.stackexchange.com/questions/29822/custom-bulk-action
			 */
			function custom_bulk_action() {
				global $typenow;
				$post_type = $typenow;
				
				if($post_type == 'image') {
					
					// get the action
					$wp_list_table = _get_list_table('WP_Posts_List_Table');  // depending on your resource type this could be WP_Users_List_Table, WP_Comments_List_Table, etc
					$action = $wp_list_table->current_action();
					
					$allowed_actions = array("reprocess", "makepromo");
					if(!in_array($action, $allowed_actions)) return;
					
					// security check
					check_admin_referer('bulk-posts');
					
					// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
					if(isset($_REQUEST['post'])) {
						$post_ids = array_map('intval', $_REQUEST['post']);
					}
					
					if(empty($post_ids)) return;
					
					// this is based on wp-admin/edit.php
					$sendback = remove_query_arg( array('reprocessed', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
					if ( ! $sendback )
						$sendback = admin_url( "edit.php?post_type=$post_type" );
					
					$pagenum = $wp_list_table->get_pagenum();
					$sendback = add_query_arg( 'paged', $pagenum, $sendback );
					
					switch($action) {
												
						case 'reprocess':
							ini_set( "memory_limit", "1024M" );
							set_time_limit( 0 );
							// if we set up user permissions/capabilities, the code might look like:
							//if ( !current_user_can($post_type_object->cap->reprocess_post, $post_id) )
							//	wp_die( __('You are not allowed to reprocess this post.') );
							
							$reprocessed = 0;
							foreach( $post_ids as $post_id ) {
								
								symbiostock_reprocess_image( $post_id );
				
								$reprocessed++;
							}
							
							$sendback = add_query_arg( array('reprocessed' => $reprocessed, 'ids' => join(',', $post_ids) ), $sendback );
						break;

						case 'makepromo':
							ini_set( "memory_limit", "1024M" );
							set_time_limit( 0 );
							// if we set up user permissions/capabilities, the code might look like:
							//if ( !current_user_can($post_type_object->cap->reprocess_post, $post_id) )
							//	wp_die( __('You are not allowed to reprocess this post.') );
							
							$reprocessed = 0;
							foreach( $post_ids as $post_id ) {
								
								symbiostock_reprocess_image( $post_id, true, 600 );
				
								$reprocessed++;
							}
							
							$sendback = add_query_arg( array('reprocessed' => $reprocessed, 'ids' => join(',', $post_ids) ), $sendback );
						break;
						
						default: return;
					}
					
					$sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );
					
					wp_redirect($sendback);
					
					exit();
				}
			}
			
			
			/**
			 * Step 3: display an admin notice on the Posts page after reprocessing
			 */
			function custom_bulk_admin_notices() {
				global $post_type, $pagenow;
				
				if($pagenow == 'edit.php' && $post_type == 'image' && isset($_REQUEST['reprocessed']) && (int) $_REQUEST['reprocessed']) {
					$message = sprintf( _n( 'Image Reprocessed.', '%s posts reprocessed.', $_REQUEST['reprocessed'] ), number_format_i18n( $_REQUEST['reprocessed'] ) );
					echo "<div class=\"updated\"><p>{$message}</p></div>";
				}
			}		
		}
	}
	
	new symbiostock_reprocess_images();
}

//generates dublin core semantic markup for SEO purposes.
function symbiostock_dublin_core($head = true){
	
	$postid = get_the_ID();

	$symbiostock_post_type = get_post_type();
	
	//get our post meta
	if ($symbiostock_post_type == 'image'){
		$image_id = $postid;
		$meta_array = symbiostock_post_meta($postid);			
	}else {
		return;		
	}				
	$permalink = get_permalink($image_id);
		
		$image = get_post($image_id, ARRAY_A);
		
		$date = explode(' ', $image['post_date']);
		
		// Get a list of terms for this post's custom taxonomy.
		
		$terms = '';
		
		$image_terms = get_the_terms($image_id, 'image-tags');
		
		if(!empty($image_terms) || $image_terms != false){
		foreach($image_terms as $term){			
			$terms .= $term->name . ', ';			
			}
		}
			
		$args = array(
				'post_types'     => 'image', // string or array with multiple post type names
				'posts_per_page' => 12, // return 5 posts
				'order'          => 'DESC',
				'exclude_posts'  => array($post->ID), // array with post IDs
				'limit_posts'    => -1, // don't limit posts
				'fields'         => 'all', // return post objects 
			);
			
		$taxonomies = array( 'image-tags' );
		
		if( function_exists( 'km_rpbt_related_posts_by_taxonomy' ) ) {				
			$related_images = km_rpbt_related_posts_by_taxonomy( $image_id, $taxonomies, $args  );
		}
				
		$author = get_author_posts_url( get_the_author_meta('ID'));	
		$author_name = get_the_author_meta('display_name' );	
			
		if($head == true){					
		?>  
<!--dublin core-->    
<link rel="schema.dc" href="http://purl.org/dc/elements/1.1/" />
<meta name="dc.title" content="<?php echo $image['post_title'] ?>" />
<meta name="dc.identifier" content="<?php echo $permalink; ?>" />
<meta name="dc.description" content="<?php echo $image['post_title'] ?>" />
<meta name="dc.subject" content="<?php echo $terms ?>" />
<meta name="dc.creator" content="<?php echo $author; ?>" />
<meta name="dc.contributor" content="<?php echo $author; ?>" />
<meta name="dc.publisher" content="<?php echo $author; ?>" />
<meta name="dc.license" content="<?php echo symbiostock_eula('', true); ?>" />
<meta name="dc.type" scheme="dcMITYPE" content="http://purl.org/dc/dcmitype/Image" />
<meta name="dc.type" scheme="dcMITYPE" content="http://purl.org/dc/dcmitype/StillImage" />        
<?php if($related_images){			
	foreach($related_images as $related_image){				
?>
<meta name="dc.relation" content="<?php echo get_permalink( $related_image->ID ); ?>" />
<?php
	}			
}?>
<link rel="schema.dcTERMS" href="http://purl.org/dc/terms/" />
<meta name="dcterms.created" scheme="ISO8601" content="<?php echo $date[0] ?>" />  
<!--/dublin core-->         
        <?php		
		} else {

?>
<dl class="dublincore">
    <dt>Title:</dt>
    <dd class="title"><?php echo $image['post_title'] ?></dd>
    <dt>Url:</dt>
    <dd><a href="<?php echo $permalink; ?>" class="identifier"><?php echo $permalink; ?></a></dd>
    <dt>Description:</dt>
    <dd class="description"><?php echo $image['post_title'] ?></dd>
    <dt>Subjects:</dt>
    <dd class="subject"><?php echo $terms ?></dd>
    <dt>Author:</dt>
    <dd><a href="<?php echo $author; ?>" class="creator"><?php echo $author_name; ?></a></dd>
    <dt>License:</dt>
    <dd><a href="<?php echo symbiostock_eula('', true); ?>" class="license"><?php echo symbiostock_eula('', true); ?></a></dd>
    <dt>Created:</dt>
    <dd class="created"><?php echo $date[0] ?></dd>
    <dt>Related:</dt>    
<?php if($related_images){			
	foreach($related_images as $related_image){				
?>
<dd><a href="<?php echo get_permalink( $related_image->ID ); ?>" class="relation"><?php echo $related_image->post_title; ?></a></dd>
<?php
	}			
}?>   
</dl>
<?php			
			
			}	
	
	}

if(is_admin()){
//updates all images on site with current values if needed
//in case user updates ALL posts, we up the time limit so it doesn't crash
set_time_limit ( 0 );
function symbiostock_update_all_images( )
{
	ini_set( "memory_limit", "1024M" );
    
    $meta_values = array(
         'symbiostock_exclusive' => 'exclusive',
        'symbiostock_live' => 'live',
        'price_bloggee' => 'price_bloggee',
        'price_small' => 'price_small',
        'price_medium' => 'price_medium',
        'price_large' => 'price_large',
        'price_vector' => 'price_vector',
        'price_zip' => 'price_zip',
        'symbiostock_discount' => 'discount_percent',
		'symbiostock_rank' => 'symbiostock_rank',
		'symbiostock_rating' => 'symbiostock_rating',
		'symbiostock_model_released' => 'symbiostock_model_released',
		'symbiostock_property_released' => 'symbiostock_property_released',
        
        'symbiostock_bloggee_available' => 'symbiostock_bloggee_available',
        'symbiostock_small_available' => 'symbiostock_small_available',
        'symbiostock_medium_available' => 'symbiostock_medium_available',
        'symbiostock_large_available' => 'symbiostock_large_available',
        'symbiostock_vector_available' => 'symbiostock_vector_available',
        'symbiostock_zip_available' => 'symbiostock_zip_available',
        
        'symbiostock_referral_label_1' => 'symbiostock_referral_label_1',
        'symbiostock_referral_label_2' => 'symbiostock_referral_label_2',
        'symbiostock_referral_label_3' => 'symbiostock_referral_label_3',
        'symbiostock_referral_label_4' => 'symbiostock_referral_label_4',
        'symbiostock_referral_label_5' => 'symbiostock_referral_label_5',
        
        'symbiostock_referral_link_1' => 'symbiostock_referral_link_1',
        'symbiostock_referral_link_2' => 'symbiostock_referral_link_2',
        'symbiostock_referral_link_3' => 'symbiostock_referral_link_3',
        'symbiostock_referral_link_4' => 'symbiostock_referral_link_4',
        'symbiostock_referral_link_5' => 'symbiostock_referral_link_5' 
    );
    
    $args       = array(
         'post_type' => 'image',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
		'fields' => 'ids'
    );
	
	$args = apply_filters('ss_bulk_edit_args', $args);	
	
    $all_images = null;
    $all_images = new WP_Query( $args );
	
	$count = 0;
	$total_count = 0;
	
    if ( $all_images->have_posts() ) {
        while ( $all_images->have_posts() ):
            $all_images->the_post();
            
            $id = get_the_ID();
            
            if ( isset( $_POST[ 'symbiostock_update_images' ] ) ) {
				
				$image_post = array();
				$image_post['ID'] = $id;
				$image_post['comment_status'] = $_POST['symbiostock_comments'];
				
				wp_update_post( $image_post );
				
                $edit = get_post_meta($id, 'locked', 'not_locked');
		
				if($edit == 'not_locked'){
					
					$size_info = symbiostock_change_image_sizes($id, $_POST['symbiostock_bloggee_size'], $_POST['symbiostock_small_size'], $_POST['symbiostock_medium_size']);
					
					update_post_meta($id, 'size_info', $size_info );
					
					foreach($meta_values as $key => $meta_value){
						
						$option = $_POST[$key];
						
						//echo $meta_value . ': ' . $option . '<br />';
										
						if(!empty($option)){							
							update_post_meta($id, $meta_value, $option);							
						}						
				}
					
			}      
           
        }
		$count++;
		$total_count++;
		if($count == 100){
			
			$subject = 'Image Process Update: ' . $total_count . ' Completed.';
			$message = 'Image process update: ' . $total_count . ' image pages updated on ' . get_bloginfo('wpurl');
			
			wp_mail(get_option('admin_email'), $subject, $message);
			
			$count = 0;
			
			}	
        //update post
		wp_cache_flush();
        endwhile;
		
		$complete = 'Operation complete!' . $total_count . ' images updated.';
		
		wp_mail(get_option('admin_email'), $complete, $complete);
    }
}	
	
function symbiostock_settings_and_pricing(){	
			
	//exclusivity
	if(isset($_POST['symbiostock_exclusive']) && isset($_POST['symbiostock_save_defaults']))
		update_option('symbiostock_exclusive', $_POST['symbiostock_exclusive']); 
	
	$exclusive = get_option('symbiostock_exclusive');
	$exclusive == 'not_exclusive' || !isset($exclusive)  ? $not_exclusive = 'selected="selected"' : $not_exclusive = '';
	$exclusive == 'exclusive' ? $exclusive = 'selected="selected"' : $exclusive = '';
	
	$_POST['symbiostock_save_defaults'] == 1 ? $update = true : $update = false;
	
	//live or not live
	if(isset($_POST['symbiostock_live']) && $update == true)
		update_option('symbiostock_live', $_POST['symbiostock_live']); 
	
	$live = get_option('symbiostock_live');
	$live == 'not_live' ? $not_live = 'selected="selected"' : $not_live = '';
	$live == 'live' || !isset($live)   ? $live = 'selected="selected"' : $live = '';
	
	if(isset($_POST['price_bloggee']) && $update == true)
		update_option('price_bloggee', $_POST['price_bloggee']);
	
	if(isset($_POST['price_small']) && $update == true) 
		update_option('price_small', $_POST['price_small']); 
	
	if(isset($_POST['price_medium']) && $update == true)
		update_option('price_medium', $_POST['price_medium']); 
	
	if(isset($_POST['price_large']) && $update == true)
		update_option('price_large', $_POST['price_large']); 
	
	if(isset($_POST['price_vector']) && $update == true)
		update_option('price_vector', $_POST['price_vector']); 
	
	if(isset($_POST['price_zip']) && $update == true)
		update_option('price_zip', $_POST['price_zip']); 
	
	if(isset($_POST['symbiostock_bloggee_available']) && $update == true) 
		update_option( 'symbiostock_bloggee_available', $_POST[ 'symbiostock_bloggee_available' ] );
	
	if(isset($_POST['symbiostock_small_available']) && $update == true)
		update_option( 'symbiostock_small_available', $_POST[ 'symbiostock_small_available' ] );
	
	if(isset($_POST['symbiostock_medium_available']) && $update == true) 
		update_option( 'symbiostock_medium_available', $_POST[ 'symbiostock_medium_available' ] );
	
	if(isset($_POST['symbiostock_large_available']) && $update == true) 
		update_option( 'symbiostock_large_available', $_POST[ 'symbiostock_large_available' ] );
	
	if(isset($_POST['symbiostock_vector_available']) && $update == true) 
		update_option( 'symbiostock_vector_available', $_POST[ 'symbiostock_vector_available' ] );
	
	if(isset($_POST['symbiostock_zip_available']) && $update == true)
		update_option( 'symbiostock_zip_available', $_POST[ 'symbiostock_zip_available' ] );
	
	if(isset($_POST['symbiostock_discount']) && $update == true) 
		update_option( 'symbiostock_discount', $_POST[ 'symbiostock_discount' ] );
	
	if(isset($_POST['symbiostock_bloggee_size']) && $update == true) 
		update_option( 'symbiostock_bloggee_size', $_POST[ 'symbiostock_bloggee_size' ] );
	
	if(isset($_POST['symbiostock_small_size']) && $update == true) 
		update_option( 'symbiostock_small_size', $_POST[ 'symbiostock_small_size' ] );
	
	if(isset($_POST['symbiostock_medium_size']) && $update == true) 
		update_option( 'symbiostock_medium_size', $_POST[ 'symbiostock_medium_size' ] );
	
	//SEO title
	if(isset($_POST['symbiostock_title_seo_text']) && $update == true)
		update_option( 'symbiostock_title_seo_text', $_POST[ 'symbiostock_title_seo_text' ] );	
	
	//Rank
	if(isset($_POST['symbiostock_rank']) && $update == true)
		update_option( 'symbiostock_rank', $_POST[ 'symbiostock_rank' ] );
	
	$rank = get_option('symbiostock_rank', '2');
	$rank == '1' ? $rank_1 = 'selected="selected"' : $rank_1 = '';
	$rank == '2' ? $rank_2 = 'selected="selected"' : $rank_2 = '';
	$rank == '3' ? $rank_3 = 'selected="selected"' : $rank_3 = '';
	
	//Rating
	if(isset($_POST['symbiostock_rating']) && $update == true)
		update_option( 'symbiostock_rating', $_POST[ 'symbiostock_rating' ] );
	
	
	$rating = get_option('symbiostock_rating', '0');
	$rating == '0' ? $rating_0 = 'selected="selected"' : $rating_0 = '';
	$rating == '1' ? $rating_1 = 'selected="selected"' : $rating_1 = '';
	$rating == '2' ? $rating_2 = 'selected="selected"' : $rating_2 = '';
	$rating == '3' ? $rating_3 = 'selected="selected"' : $rating_3 = '';
	
	
	//comments on or off on images
	if(isset($_POST['symbiostock_comments']) && $update == true) 
		update_option( 'symbiostock_comments', $_POST[ 'symbiostock_comments' ] );
	
	$symbiostock_comment_status = get_option('symbiostock_comments');
	$symbiostock_comment_status == 'open' || !isset($symbiostock_comment_selected)  ? $symbiostock_comment_selected = 'selected="selected"' : $symbiostock_comment_selected = '';
	$symbiostock_comment_status == 'closed' ? $symbiostock_comment_not_selected = 'selected="selected"' : $symbiostock_comment_not_selected = '';
	//reflections on or off on minipics
	if(isset($_POST['symbiostock_reflections']) && $update == true) 
		update_option( 'symbiostock_reflections', $_POST[ 'symbiostock_reflections' ] );
	
	$symbiostock_reflections = get_option('symbiostock_reflections');
	$symbiostock_reflections == 'on' || !isset($symbiostock_reflections)  ? $symbiostock_reflections_on = 'selected="selected"' : $symbiostock_reflections_on = '';
	$symbiostock_reflections == 'off' ? $symbiostock_reflections_off = 'selected="selected"' : $symbiostock_reflections_off = '';
	//model release Yes / No / N/A
	if(isset($_POST['symbiostock_model_released']) && $update == true) 
		update_option( 'symbiostock_model_released', $_POST[ 'symbiostock_model_released' ] );
	
	$symbiostock_model_release = get_option('symbiostock_model_released', 'N/A');
	$symbiostock_model_release == 'Yes' || !isset($symbiostock_model_release)  ? $symbiostock_model_released_yes = 'selected="selected"' : $symbiostock_model_released_yes = '';
	$symbiostock_model_release == 'No' ? $symbiostock_model_released_no = 'selected="selected"' : $symbiostock_model_released_no = '';
	$symbiostock_model_release == 'N/A' ? $symbiostock_model_released_na = 'selected="selected"' : $symbiostock_model_released_na = '';
	//property release Yes / No / N/A
	if(isset($_POST['symbiostock_property_released']) && $update == true) 
		update_option( 'symbiostock_property_released', $_POST[ 'symbiostock_property_released' ] );
	
	$symbiostock_property_release = get_option('symbiostock_property_released', 'N/A');
	$symbiostock_property_release == 'Yes' || !isset($symbiostock_property_released_yes)  ? $symbiostock_property_released_yes = 'selected="selected"' : $symbiostock_property_released_yes = '';
	$symbiostock_property_release == 'No' ? $symbiostock_property_released_no = 'selected="selected"' : $symbiostock_property_released_no = '';
	$symbiostock_property_release == 'N/A' ? $symbiostock_property_released_na = 'selected="selected"' : $symbiostock_property_released_na = '';
	
	$symbiostock_bloggee_available = get_option( 'symbiostock_bloggee_available', 'yes');
	$symbiostock_small_available   = get_option( 'symbiostock_small_available', 'yes');
	$symbiostock_medium_available  = get_option( 'symbiostock_medium_available', 'yes');
	$symbiostock_large_available   = get_option( 'symbiostock_large_available', 'yes');
	$symbiostock_vector_available  = get_option( 'symbiostock_vector_available', 'yes');
	$symbiostock_zip_available     = get_option( 'symbiostock_zip_available', 'yes');
	$symbiostock_medium_size       = get_option('symbiostock_medium_size', 1000);
	$symbiostock_small_size        = get_option('symbiostock_small_size', 500);
	$symbiostock_bloggee_size       = get_option('symbiostock_bloggee_size', 250);
			
	$referral_count = 1;
	while($referral_count <=5){
		
	if(isset($_POST['symbiostock_referral_link_' . $referral_count]) && $update == true){ 
		update_option('symbiostock_referral_link_' . $referral_count, $_POST['symbiostock_referral_link_' . $referral_count]); 
		update_option('symbiostock_referral_label_' . $referral_count, $_POST['symbiostock_referral_label_' . $referral_count]); 
		}
	$referral_count++;	
	}		
	?>
	<table class="symbiostock-author-settings widefat wp-list-table">		
        <thead>
            <tr>
                <th colspan=2> <strong>&raquo; Image Status</strong> </th>
            </tr>
        </thead>		
		<tr>
			<th scope="row">Exclusive</th>
			<td><select id="symbiostock_exclusive"  name="symbiostock_exclusive">
					<option <?php echo $not_exclusive; ?> value="not_exclusive">Not Exclusive</option>
					<option <?php echo $exclusive; ?> value="exclusive">Exclusive</option>
				</select>
            </td>
		</tr>
		<tr>
			<th scope="row">Live<br /><?php echo sshelp('live', 'Live'); ?></th>
			<td><select id="symbiostock_live"  name="symbiostock_live">
					<option <?php echo $live; ?> value="live">Live</option>
					<option <?php echo $not_live; ?> value="not_live">Not Live</option>
				</select>
            </td>
		</tr>		
		<!--rank rating-->		
		<tr>
			<th scope="row">Rank<br /><?php echo sshelp('rank', 'Rank'); ?></th>
			<td>        	
				<select id="symbiostock_rank"  name="symbiostock_rank">
					<option <?php echo $rank_1; ?> value="1">1st</option>
					<option <?php echo $rank_2; ?> value="2">2nd</option>
					<option <?php echo $rank_3; ?> value="3">3rd</option>                
				</select>
				<br />
				<p class="description">Relative ranking system, putting premium at front of search results, second in the middle, third last.</p>
			</td>
		</tr>
		<tr>
			<th scope="row">Rating<br /><?php echo sshelp('rating', 'Rating'); ?></th>
			<td>
				<select id="symbiostock_rating"  name="symbiostock_rating">
					<option <?php echo $rating_0; ?> value="0"> - </option>
					<option <?php echo $rating_1; ?> value="1">GREEN</option>
					<option <?php echo $rating_2; ?> value="2">YELLOW</option>
					<option <?php echo $rating_3; ?> value="3">RED</option>                              
				</select>
				<p class="description">Nudity filter. See info link for definitions.</p>
            </td>
		</tr>
        <!--pricing and options-->        
		<thead>
            <tr>
                <th colspan=2>  <strong>&raquo; Pricing and Options <?php echo sshelp('default_pricing', 'Default Pricing'); ?></strong><br />
                    *See <strong>Settings</strong> to change type.
                </th>
            </tr>
        </thead>
		<tr>
			<th scope="row"><strong>Vector</strong></th>
			<td><input type="text" name="price_vector"  id="price_vector" value="<?php echo get_option('price_vector', '20.00'); ?>" />
				<?php symbiostock_size_available('vector', $symbiostock_vector_available) ?>
            </td>
		</tr>
		<tr>
			<th scope="row"><strong>Zip</strong> (packaged alternate files)</th>
			<td><input type="text" name="price_zip"  id="price_zip" value="<?php echo get_option('price_zip', '30.00'); ?>" />
				<?php symbiostock_size_available('zip', $symbiostock_zip_available) ?>
            </td>
		</tr>
		<tr>
			<th scope="row"><strong>Large</strong></th>
			<td><input type="text" name="price_large"  id="price_large" value="<?php echo get_option('price_large', '20.00'); ?>" />
				<?php symbiostock_size_available('large', $symbiostock_large_available) ?>
            </td>
		</tr>
		<tr>
			<th scope="row"><strong>Medium</strong></th>
			<td><input type="text" name="price_medium"  id="price_medium" value="<?php echo get_option('price_medium', '10.00'); ?>" />
				<?php symbiostock_size_available('medium', $symbiostock_medium_available) ?>
            </td>
		</tr>
		<tr>
			<th scope="row"><strong>Small</strong></th>
			<td><input type="text" name="price_small"  id="price_small" value="<?php echo get_option('price_small', '5.00'); ?>" />
				<?php symbiostock_size_available('small', $symbiostock_small_available) ?>
            </td>
		</tr>
		<tr>
			<th scope="row"><strong>Bloggee</strong></th>
			<td><input type="text" name="price_bloggee"  id="price_bloggee" value="<?php echo get_option('price_bloggee', '2.50'); ?>" />
				<?php symbiostock_size_available('bloggee', $symbiostock_bloggee_available) ?>
            </td>
		</tr>
		<tr>
			<th scope="row">Discount %</th>
			<td><input type="text" name="symbiostock_discount"  id="symbiostock_discount" value="<?php echo get_option('symbiostock_discount', '0'); ?>" />
				Enter "<strong>00</strong>" to reset to 0.
            </td>
		</tr>
        <thead>
            <tr>
                <th colspan=2>  <strong>&raquo; Default Size Settings</strong>  
                <br /><?php echo sshelp('default_size_settings', 'Default Size Settings'); ?>
                </th>
            </tr>
        </thead>
		<tr>
			<th scope="row"><strong>Medium</strong></th>
			<td><input type="text" name="symbiostock_medium_size"  id="symbiostock_medium_size" value="<?php echo $symbiostock_medium_size ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><strong>Small</strong></th>
			<td><input type="text" name="symbiostock_small_size"  id="symbiostock_small_size" value="<?php echo $symbiostock_small_size ?>" /></td>
		</tr>
		<tr>
			<th scope="row"><strong>Bloggee</strong></th>
			<td><input type="text" name="symbiostock_bloggee_size"  id="symbiostock_bloggee_size" value="<?php echo $symbiostock_bloggee_size ?>" /></td>
		</tr>
        <thead>
            <tr>
                <th colspan=2>  <strong>&raquo; Image SEO</strong> *Entering "<strong><em>-Royalty Free Image</em></strong>" will append that phrase to all image titles. </th>
            </tr>
        </thead>
		<tr>
			<th scope="row"><strong>Append Text to Title:</strong></th>    
			<td><input type="text" name="symbiostock_title_seo_text"  id="symbiostock_title_seo_text" value="<?php echo get_option('symbiostock_title_seo_text', ''); ?>" /><br /><br /></td>
	    </tr>   
		<tr>		
			<th scope="row"><strong>Image Comments</strong> <br /> Applied during processing. Must manually change afterward.</th>
			<td>
            	<select id="symbiostock_comments"  name="symbiostock_comments">
					<option <?php echo $symbiostock_comment_selected; ?> value="open">Allowed</option>
					<option <?php echo $symbiostock_comment_not_selected; ?> value="closed">Disabled</option>
				</select>
            </td>
		</tr>
        <thead>
            <tr>
                <th colspan=2>  <strong>&raquo; Legal</strong> </th>
            </tr>
        </thead>         
		<tr>    
			<th scope="row"><strong>Model Released?</strong> <br /></th>
			<td><select id="symbiostock_model_released"  name="symbiostock_model_released">
					<option <?php echo $symbiostock_model_released_yes; ?> value="Yes">Yes</option>
					<option <?php echo  $symbiostock_model_released_no; ?> value="No">No</option>
					<option <?php echo  $symbiostock_model_released_na; ?> value="N/A">N/A</option>
				</select>
            </td>
		</tr>
		<tr>    
			<th scope="row"><strong>Property Released?</strong> <br /></th>
			<td><select id="symbiostock_property_released"  name="symbiostock_property_released">
					<option <?php echo $symbiostock_property_released_yes; ?> value="Yes">Yes</option>
					<option <?php echo  $symbiostock_property_released_no; ?> value="No">No</option>
					<option <?php echo  $symbiostock_property_released_na; ?> value="N/A">N/A</option>
				</select>
            </td>
		</tr>
        <thead>		 
            <tr>
                <th colspan=2>  <strong>&raquo; Referral Links</strong> </th>
            </tr>
        </thead>
		<tr>			
			<td>
           		<label for="symbiostock_referral_link_1" scope="row"><strong>Referral Link #1:</strong></label>
            	<input class="longfield" type="text" name="symbiostock_referral_link_1"  id="symbiostock_referral_link_1" value="<?php echo get_option('symbiostock_referral_link_1', ''); ?>" />
            </td>			
			<td>
            	<label for="symbiostock_referral_label_1" scope="row">Label:</label>
            	<input class="longfield" type="text" name="symbiostock_referral_label_1"  id="symbiostock_referral_label_1" value="<?php echo get_option('symbiostock_referral_label_1', ''); ?>" />
            </td>
		</tr>
		<tr>			
			<td>
            	<label scope="row"><strong>Referral Link #2</strong></label>
            	<input class="longfield" type="text" name="symbiostock_referral_link_2"  id="symbiostock_referral_link_2" value="<?php echo get_option('symbiostock_referral_link_2', ''); ?>" />
            </td>			
			<td>
            	<label scope="row">Label:</label>
            	<input class="longfield" type="text" name="symbiostock_referral_label_2"  id="symbiostock_referral_label_2" value="<?php echo get_option('symbiostock_referral_label_2', ''); ?>" />
            </td>
		</tr>
		<tr>			
			<td>
            	<label scope="row"><strong>Referral Link #3</strong></label>
            	<input class="longfield" type="text" name="symbiostock_referral_link_3"  id="symbiostock_referral_link_3" value="<?php echo get_option('symbiostock_referral_link_3', ''); ?>" />
            </td>            			
			<td>
            	<label scope="row">Label:</label>
           		<input class="longfield" type="text" name="symbiostock_referral_label_3"  id="symbiostock_referral_label_3" value="<?php echo get_option('symbiostock_referral_label_3', ''); ?>" />
            </td>
		</tr>
		<tr>			
			<td>
            	<label scope="row"><strong>Referral Link #4</strong></label>
           		<input class="longfield" type="text" name="symbiostock_referral_link_4"  id="symbiostock_referral_link_4" value="<?php echo get_option('symbiostock_referral_link_4', ''); ?>" />
            </td>            			
			<td>
            	<label scope="row">Label:</label>
            	<input class="longfield" type="text" name="symbiostock_referral_label_4"  id="symbiostock_referral_label_4" value="<?php echo get_option('symbiostock_referral_label_4', ''); ?>" />
            </td>
		</tr>
		<tr>			
			<td>
            	<label scope="row"><strong>Referral Link #5</strong></label>
            	<input class="longfield" type="text" name="symbiostock_referral_link_5"  id="symbiostock_referral_link_5" value="<?php echo get_option('symbiostock_referral_link_5', ''); ?>" />
            </td>			
			<td>
            	<label scope="row">Label:</label>
            	<input class="longfield" type="text" name="symbiostock_referral_label_5"  id="symbiostock_referral_label_5" value="<?php echo get_option('symbiostock_referral_label_5', ''); ?>" />
            </td>
		</tr>
	</table>   
    <br /><br />
	<?php 
		
	}
}
//set up the theme auto-updater
require_once('theme-updater.php');
new WPUpdatesThemeUpdater( 'http://wp-updates.com/api/1/theme', 334, basename(get_template_directory()) );

//get marketing functions
require_once(symbiostock_MARKETROOT . 'marketer_functions.php');