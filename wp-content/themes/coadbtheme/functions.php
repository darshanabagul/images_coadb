<?php

function coadb_script_enquire()
{
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array());
	wp_enqueue_style('font', get_template_directory_uri() . '/css/font.css', array(),'all');
	wp_enqueue_style('customestyle', get_template_directory_uri() . '/css/home.css', array(),'all');
	wp_enqueue_style('customstyle', get_template_directory_uri() . '/css/style.css', array(),'all');
	wp_enqueue_style('animate', get_template_directory_uri() . '/css/animate.css', array());
	wp_enqueue_style('inner-layout', get_template_directory_uri() . '/css/inner-layout.css', array());
	wp_enqueue_style('islick', get_template_directory_uri() . '/css/slick.css', array());
	wp_enqueue_style('slick-theme', get_template_directory_uri() . '/css/slick-theme.css', array());
	wp_enqueue_style('myslick', get_template_directory_uri() . '/css/myslick.css', array());
	wp_enqueue_style('load-fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', array());
	wp_enqueue_style('magnific', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.css', array());
	wp_enqueue_style('customestyleold', get_template_directory_uri() . '/css/style1.css', array(),'all');

	wp_enqueue_script('customjs', get_template_directory_uri() . '/js/jquery.min.js', array(), '1.0.0', true);	
	wp_enqueue_script('bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0', true);	
	wp_enqueue_script('wowjs', get_template_directory_uri() . '/js/wow.min.js', array(), '1.0.0', true);	
	wp_enqueue_script('magnific-popup', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.js', array());	
	wp_enqueue_script('jquery-2.2.0', 'https://code.jquery.com/jquery-2.2.0.min.js', array());	
	wp_enqueue_script('slickjs', get_template_directory_uri() . '/js/slick.js', array(), '1.0.0', true);	
	
}
add_action('wp_enqueue_scripts', 'coadb_script_enquire');

function coadb_theme_setup()
{
	add_theme_support('menus');
	register_nav_menu('home','Home Header Navigation'); //home page menu(merch,about,contact us, learning center)
	register_nav_menu('surname','Surname Menu Navigation'); //surname details menu(Gallery info, purchase jpg, buy merchendize, which coat of page)
	register_nav_menu('other','Other Menu Navigation'); //other pages menu
	register_nav_menu('social','Social Menu Navigation');// social links menu
	register_nav_menu('footer','Footer Menu Navigation'); //footer menu
	add_theme_support('post-thumbnails');
	set_post_thumbnail_size( 140, 140, true );
}
add_action('init', 'coadb_theme_setup');

function theme_enqueue_scripts() {
	// Enqueue jQuery UI and autocomplete
	wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-autocomplete' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

function theme_autocomplete_dropdown_shortcode( $atts ) {
	return '<input type="text" name="autocomplete" id="autocomplete" value="" placeholder="Search by typing product name..." />';
}
add_shortcode( 'autocomplete', 'theme_autocomplete_dropdown_shortcode' );

function coadb_theme_widgets_init()
{
	register_sidebar(array(
		'name' => 'Level Up New Widget Area',
		'id' => 'level up new widget area',
		'before_widgets' => '<aside>',
		'after_widgets' => '</aside>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>'
	));
}
add_action('widgets_init', 'coadb_theme_widgets_init');

/*
===========================================
		Activate custom settings
===========================================
*/


function find_coat_of_arms() {
	global $wp;
    session_start();
	//$path = get_template_directory_uri() .'/processed_images/dolan/';
    if (!empty($_GET['surname'])) {
        $page = $_GET['surname'];
        $_SESSION['slug'] = strtolower($page);
    }
    $page = stripslashes(strtolower($page));
    $coat_of_arms['page_slug'] = $page;

    //call curl for getting all coat_of_arms images from bucket
    $handle = curl_init();
    $url = "http://ec2-3-16-187-143.us-east-2.compute.amazonaws.com/coadb/coadb_API/Welcome/getCoatOfArms";
    
    $postData = array(
      'Surname' => $coat_of_arms['page_slug'].'/shop-images/'
    );
     
    curl_setopt_array($handle,
      array(
         CURLOPT_URL => $url,
         // Enable the post response.
        CURLOPT_POST       => true,
        // The data to transfer with the response.
        CURLOPT_POSTFIELDS => $postData,
        CURLOPT_RETURNTRANSFER     => true,
      )
    );
     
    $images = curl_exec($handle);
    $images = json_decode($images);
    
	if (!empty($images)) {
    	$coat_of_arms['images'] = $images;
	}
    return $coat_of_arms;
}

function wpb_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
 
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );

/*
===========================================
			Include Walker File
===========================================
*/
//require get_template_directory() . '/inc/walker.php';

add_action('wp_ajax_save_custom_data', 'save_custom_data');
add_action('wp_ajax_nopriv_save_custom_data', 'save_custom_data');

function save_custom_data()
{
    session_start();
    $coat_of_arm_img = $_POST['coat_of_arm_img']; //coat of arm img 
    $product_id = $_POST['product_id']; //Product ID    
    $_SESSION['user_custom_datas'] = $coat_of_arm_img;
    
    $quantity = 1; //Or it can be some userinputted quantity
    if( WC()->cart->add_to_cart( $product_id, $quantity )) {
        global $woocommerce;
        $cart_url = $woocommerce->cart->get_cart_url();
        $output = array('success' => 1, 'msg' =>'Added the product to your cart', 'cart_url' => $cart_url );
    } else {
        $output = array('success' => 0, 'msg' => 'Something went wrong, please try again');
    }
    $output = array('success' => 1, 'msg' =>'Added the product to your cart', 'cart_url' => $cart_url );
    wp_die(json_encode($output));
}

add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',1,10);
function wdm_add_item_data($cart_item_data, $product_id) {
	global $woocommerce;
	session_start();	
    $new_value = array();
    $new_value['_custom_options'] = $_SESSION['user_custom_datas'];//$_POST['custom_options'];
    unset($_SESSION['user_custom_datas']);
    if(empty($cart_item_data)) {
        return $new_value;
    } else {
        return array_merge($cart_item_data, $new_value);
    }
}

add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3 );
function wdm_get_cart_items_from_session($item,$values,$key) {
    if (array_key_exists( '_custom_options', $values ) ) {
        $item['_custom_options'] = $values['_custom_options'];
    }
    return $item;
}

add_filter('woocommerce_cart_item_name','add_usr_custom_session',1,3);
function add_usr_custom_session($product_name, $values, $cart_item_key ) {
	$return_string = $product_name;
	if($values['data']->get_name() == 'Digital JPG Image') {
		$description = $values['_custom_options'];
		$return_string = $product_name . "<br />" . ucfirst($description);
	}
	return $return_string;
}
/*
function custom_new_product_image( $_product_img, $cart_item, $cart_item_key ) {
	$a = $cart_item['data']->get_image();
	if($cart_item['data']->get_name() == 'Digital JPG Image') {
    	$a = '<img src="'.get_site_url().'/wp-content/uploads/processed_images/'.$cart_item['_custom_options'].'" />';
    }
    return $a;
}
add_filter( 'woocommerce_cart_item_thumbnail', 'custom_new_product_image', 10, 3 );
*/

function custom_new_product_image( $_product_img, $cart_item, $cart_item_key ) {
	$a = $cart_item['data']->get_image();
	if($cart_item['data']->get_name() == 'Digital JPG Image') {
        $page = stripslashes(strtolower($cart_item['_custom_options']));
		$description = $page;
		$folderName = explode('-', $description);
    	$a = '<img src="http://s3.us-east-2.amazonaws.com/bucket.coadb/'.$folderName[0].'/shop-images/'.$description.'" />';
    }
    return $a;
}
add_filter( 'woocommerce_cart_item_thumbnail', 'custom_new_product_image', 10, 3 );


add_action('woocommerce_add_order_item_meta','wdm_add_values_to_order_item_meta',1,2);
function wdm_add_values_to_order_item_meta($item_id, $values) {
    global $woocommerce,$wpdb;
    
    //define('TOKEN_DIR', 'tokens');
    if($values['data']->get_name() == 'Digital JPG Image') {
        $page = stripslashes(strtolower($values['_custom_options']));
        $description = $page;
    }
    $fid = base64_encode($description);
    $key = uniqid(time().'-key',TRUE);
    /*
    if(!is_dir(TOKEN_DIR)) {
        mkdir(TOKEN_DIR);
        $file = fopen(TOKEN_DIR.'/.htaccess','w');
        fwrite($file,"Order allow,deny\nDeny from all");
        fclose($file);
    }
    
    // Write the key to the keys list
    $file = fopen(TOKEN_DIR.'/keys','a');
    fwrite($file, "{$key}\n");
    fclose($file);
	*/
    if(!empty($values['data']->get_name())) {
    	wc_add_order_item_meta($item_id,'JPG Details','<a href="'.get_site_url().'/download?fid='.$fid.'&key='.$key.'"> Download </a>'.$description);
    }
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

   return preg_replace('/[^A-Za-z0-9\-]/', ' - ', $string); // Removes special chars.
}

/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */

add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );
function my_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
    if (in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}

function my_upload_dir($upload) {
  $upload['path']   =  $upload['basedir'] . $upload['subdir'];
  $upload['url']    =  $upload['baseurl'] . $upload['subdir'];
  return $upload;
}

function redirect_to_home() {
  if(!is_admin() && is_page('2')) {
    wp_redirect(get_home_url());
    exit();
  }
}
add_action('template_redirect', 'redirect_to_home');

