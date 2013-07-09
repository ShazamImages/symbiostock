<?php
//image custom post type
add_action( 'init', 'symbiostock_image_manager_register' );
function symbiostock_image_manager_register( )
{
    //creating custom post type for image
    
    $labels = array(
         'name' => 'Symbiostock Images',
        'singular_name' => 'Image',
        'add_new' => 'New Image',
        'add_new_item' => 'Add New Image',
        'edit_item' => 'Edit Image',
        'new_item' => 'New Image',
        'all_items' => 'All Images',
        'view_item' => 'View Image',
        'search_items' => 'Search Images',
        'not_found' => 'No image found',
        'not_found_in_trash' => 'No images found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Royalty Free Images', 
		'not_found' =>  __('No images found'),
    );
    
    $args = array(
                
         'labels' => $labels,
        'singular_label' => __( 'Image' ),
        'description' => 'Image Listings',
        'menu_position' => 100,
        'menu_icon' => symbiostock_IMGDIR . '/symbiostock_icon2.png',
        'public' => true,
		//'publicly_queryable' => true,
        //'show_ui' => true,
        'capability_type' => 'post',
		// ----------------------------- > note - uncommenting next line seems to make issues of memory consumption.
        //'hierarchical' => true,
        'has_archive' => true,
		'exclude_from_search' => false,
		'query_var' => true,
        'supports' => array(
             'title',
            'editor',
            'thumbnail', 
			'comments',
			'excerpt',  
        ),
        'rewrite' => true,
        
    );
    
    
    register_post_type( 'image', $args );
    
    register_taxonomy( 'image-type', array(
         'image' 
    ), array(
         'hierarchical' => true,
        'label' => 'Image Categories',
        'singular_label' => 'Image Type',
        'rewrite' => true,
		'exclude_from_search' =>false,
		'public' => true, 
        'slug' => 'image-type' 		
		
    ) );
    
    register_taxonomy( 'image-tags', array(
         'image' 
    ), array(
		'public' => true,
		'rewrite' => true,
		'query_var' => true,
        'singular_label' => 'Image Keyword',
		'exclude_from_search' =>false,
		'hierarchical'            => false,
		'labels'                  => $labels,
		'show_ui'                 => true,
		'show_admin_column'       => true,
		
        'slug' => 'image-tag', 				 
        'labels' => array(
			'name' => _x( 'Image Keywords', 'taxonomy general name' ),
			'singular_name' => _x( 'Keywords', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Images' ),
			'all_items' => __( 'All Image Keywords' ),
			'edit_item' => __( 'Edit Image Keyword' ),
			'update_item' => __( 'Update Image Keyword' ),
			'add_new_item' => __( 'Add New Image Keyword' ),
			'new_item_name' => __( 'New Keyword Name' ),
			'menu_name' => __( 'Image Keywords' ),
			),
		'rewrite' => array(
			'slug' => 'search-images', // This controls the base slug that will display before each term
			'with_front' => false, 
		),
    ) );
    
}
add_action( 'admin_init', 'symbiostock_image_directory' );
function symbiostock_image_directory( )
{
    add_meta_box( 'symbiostock-image-meta', 'Symbiostock Image Info', 'symbiostock_image_manager_meta_options', 'image', 'normal', 'high' );
    
}
//creates a list of inputs in the image managing screen to allow availability or not
function symbiostock_size_available($size, $available){
	
	$available == 'yes' || !isset($available)  ? $yes = 'selected="selected"' : $yes = '';
	
	$available == 'no'  ? $no = 'selected="selected"' : $no = '';
	
	$available == 'no_select' ? $no_select = 'selected="selected"' : $no_select = '';
	
	?>
<select name="symbiostock_<?php echo $size ?>_available">
    <option <?php echo $yes ?> value="yes">Available</option>
    <option <?php echo $no ?> value="no">Not Available</option>
    <option <?php echo $no_select ?> value="no_select">No Select</option>
</select>
<?php
}	
function symbiostock_image_manager_meta_options( )
{
    global $post;
    
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;
    
    $custom           = get_post_custom( $post->ID );
    $price_bloggee    = $custom[ 'price_bloggee' ][ 0 ];
    $price_small      = $custom[ 'price_small' ][ 0 ];
    $price_medium     = $custom[ 'price_medium' ][ 0 ];
    $price_large      = $custom[ 'price_large' ][ 0 ];
    $price_zip        = $custom[ 'price_zip' ][ 0 ];
    $price_vector     = $custom[ 'price_vector' ][ 0 ];
    $discount_percent = $custom[ 'discount_percent' ][ 0 ];
    $exclusive        = $custom[ 'exclusive' ][ 0 ];
	$locked           = $custom[ 'locked' ][ 0 ];
	$live             = $custom[ 'live' ][ 0 ];
	
	//availability options
	
	$symbiostock_bloggee_available = $custom[ 'symbiostock_bloggee_available' ][ 0 ];
	$symbiostock_small_available   = $custom[ 'symbiostock_small_available' ][ 0 ];
	$symbiostock_medium_available  = $custom[ 'symbiostock_medium_available' ][ 0 ];
	$symbiostock_large_available   = $custom[ 'symbiostock_large_available' ][ 0 ];
	$symbiostock_vector_available  = $custom[ 'symbiostock_vector_available' ][ 0 ];
	$symbiostock_zip_available     = $custom[ 'symbiostock_zip_available' ][ 0 ];
	
	//rank and rating
	$symbiostock_rating     = $custom[ 'symbiostock_rating' ][ 0 ];
	$symbiostock_rank     = $custom[ 'symbiostock_rank' ][ 0 ];	
	
	//size info
	$size_info = get_post_meta($post->ID, 'size_info');
	$sizes = maybe_unserialize($size_info[0]);
	
	$sizes['large']['width'] > $sizes['large']['height'] ? $symbiostock_large_size = $sizes['large']['width'] : $symbiostock_large_size = $sizes['large']['height'];
	$sizes['medium']['width'] > $sizes['medium']['height'] ? $symbiostock_medium_size = $sizes['medium']['width'] : $symbiostock_medium_size = $sizes['medium']['height'];
	$sizes['small']['width'] > $sizes['small']['height'] ? $symbiostock_small_size = $sizes['small']['width'] : $symbiostock_small_size = $sizes['small']['height'];
	$sizes['bloggee']['width'] > $sizes['bloggee']['height'] ? $symbiostock_bloggee_size = $sizes['bloggee']['width'] : $symbiostock_bloggee_size = $sizes['bloggee']['height'];
	
	//legal
	$symbiostock_model_release     = $custom[ 'symbiostock_model_released' ][ 0 ];
	$symbiostock_property_release  = $custom[ 'symbiostock_property_released' ][ 0 ];
	
	//referral links
	
	$symbiostock_referral_label_1     = $custom[ 'symbiostock_referral_label_1' ][ 0 ];
	$symbiostock_referral_label_2     = $custom[ 'symbiostock_referral_label_2' ][ 0 ];
	$symbiostock_referral_label_3     = $custom[ 'symbiostock_referral_label_3' ][ 0 ];
	$symbiostock_referral_label_4     = $custom[ 'symbiostock_referral_label_4' ][ 0 ];
	$symbiostock_referral_label_5     = $custom[ 'symbiostock_referral_label_5' ][ 0 ];	
	$symbiostock_referral_link_1     = $custom[ 'symbiostock_referral_link_1' ][ 0 ];
	$symbiostock_referral_link_2     = $custom[ 'symbiostock_referral_link_2' ][ 0 ];
	$symbiostock_referral_link_3     = $custom[ 'symbiostock_referral_link_3' ][ 0 ];
	$symbiostock_referral_link_4     = $custom[ 'symbiostock_referral_link_4' ][ 0 ];
	$symbiostock_referral_link_5     = $custom[ 'symbiostock_referral_link_5' ][ 0 ];
	
    
?>
<div class="image_manager">

<br />

<?php
//Rating
$symbiostock_rating == '1' || !isset($symbiostock_rating)  ? $symbiostock_rating_1 = 'selected="selected"' : $symbiostock_rating_1 = '';
$symbiostock_rating == '2' ? $symbiostock_rating_2 = 'selected="selected"' : $symbiostock_rating_2 = '';
$symbiostock_rating == '3' ? $symbiostock_rating_3 = 'selected="selected"' : $symbiostock_rating_3 = '';
?>
<div>
<label>Rating: </label>
<select id="symbiostock_rating"  name="symbiostock_rating">
    <option <?php echo $symbiostock_rating_1; ?> value="1">GREEN</option>
    <option <?php echo $symbiostock_rating_2; ?> value="2">YELLOW</option>
    <option <?php echo $symbiostock_rating_3; ?> value="3">RED</option>                              
</select>
<?php echo sshelp('rating', 'Rating'); ?>
</div>


<?php
//rank
$symbiostock_rank == '1' ? $symbiostock_rank_1 = 'selected="selected"' : $symbiostock_rank_1 = '';
$symbiostock_rank == '2' || !isset($symbiostock_rank) ? $symbiostock_rank_2 = 'selected="selected"' : $symbiostock_rank_2 = '';
$symbiostock_rank == '3' ? $symbiostock_rank_3 = 'selected="selected"' : $symbiostock_rank_3 = '';
?>

<div>
<label>rank: </label>
<select id="symbiostock_rank"  name="symbiostock_rank">
    <option <?php echo $symbiostock_rank_1; ?> value="1">1st</option>
    <option <?php echo $symbiostock_rank_2; ?> value="2">2nd</option>
    <option <?php echo $symbiostock_rank_3; ?> value="3">3rd</option>                
</select>
<?php echo sshelp('rank', 'Rank'); ?>
</div>

<br />

<?php
	$locked == 'locked' ? $checked = 'checked="checked"' : $checked = '';
	 
	 echo '<img class="alignright preview_pic" alt="Image Preview" src="' . $custom['symbiostock_preview'][0] . '" />';
?>
<div>
    <label>Bloggee: </label>
    <input type="text" name = "price_bloggee" value="<?php
    echo $price_bloggee;
?>" />
    <?php symbiostock_size_available('bloggee', $symbiostock_bloggee_available) ?>
</div>
<div>
    <label>Small: </label>
    <input type="text" name="price_small" value="<?php
    echo $price_small;
?>" />
    <?php symbiostock_size_available('small', $symbiostock_small_available) ?>
</div>
<div>
    <label>Medium: </label>
    <input type="text" name = "price_medium" value="<?php
    echo $price_medium;
?>" />
    <?php symbiostock_size_available('medium', $symbiostock_medium_available) ?>
</div>
<div>
    <label>Large: </label>
    <input type="text" name = "price_large" value="<?php
    echo $price_large;
?>" />
    <?php symbiostock_size_available('large', $symbiostock_large_available) ?>
</div>
<div>
    <label>Vector: </label>
    <input type="text" name="price_vector" value="<?php
    echo $price_vector;
?>" />
    <?php symbiostock_size_available('vector', $symbiostock_vector_available) ?>
</div>
<div>
    <label>Zip: </label>
    <input type="text" name="price_zip" value="<?php
    echo $price_zip;
?>" />
    <?php symbiostock_size_available('zip', $symbiostock_zip_available) ?>
</div>
<div>
    <label>Discount: </label>
    <input type="text" name="discount_percent" value="<?php
    echo $discount_percent;
?>" />
</div>

<br />


<div>
	
    <label>Size Bloggee: </label>
    <input type="text" name="symbiostock_bloggee_size" value="<?php echo $symbiostock_bloggee_size ?>" />
</div>
<div>
    <label>Size Small: </label>
    <input type="text" name="symbiostock_small_size" value="<?php echo $symbiostock_small_size ?>" />
</div>
<div>
    <label>Size Medium: </label>
    <input type="text" name="symbiostock_medium_size" value="<?php echo $symbiostock_medium_size ?>" />
</div>
<div>
    <label>Size Large: </label>
    <input readonly type="text" name="symbiostock_large_size" value="<?php echo $symbiostock_large_size ?>" />
</div>
<?php
	
	$exclusive == 'not_exclusive' || !isset($exclusive)  ? $non_exclusive = 'selected="selected"' : $non_exclusive = '';
	$exclusive == 'exclusive' ? $exclusive = 'selected="selected"' : $exclusive = '';
	
	?>
<br />
<div>
    <label>Exclusive: </label>
    <select name="exclusive">
        <option <?php echo $non_exclusive; ?> value="not_exclusive">Not Exclusive</option>
        <option <?php echo $exclusive; ?> value="exclusive">Exclusive</option>
    </select>
</div>
<?php
	
	$live == 'not_live'  ? $not_live = 'selected="selected"' : $not_live = '';
	$live == 'live' || !isset($live) ? $live = 'selected="selected"' : $live = '';
	
	?>
<div>
    <label>Live: </label>
    <select name="live">
        <option <?php echo $live; ?> value="live">Live</option>
        <option <?php echo $not_live; ?> value="not_live">Not Live</option>
    </select>
</div>

<?php
$symbiostock_model_release == 'N/A' ? $symbiostock_model_released_na = 'selected="selected"' : $symbiostock_model_released_na = '';
$symbiostock_model_release == 'Yes' || !isset($symbiostock_model_release)  ? $symbiostock_model_released_yes = 'selected="selected"' : $symbiostock_model_released_yes = '';
$symbiostock_model_release == 'No' ? $symbiostock_model_released_no = 'selected="selected"' : $symbiostock_model_released_no = '';

$symbiostock_property_release == 'N/A' ? $symbiostock_property_released_na = 'selected="selected"' : $symbiostock_property_released_na = '';
$symbiostock_property_release == 'Yes' || !isset($symbiostock_property_release)  ? $symbiostock_property_released_yes = 'selected="selected"' : $symbiostock_property_released_yes = '';
$symbiostock_property_release == 'No' ? $symbiostock_property_released_no = 'selected="selected"' : $symbiostock_property_released_no = '';

?>
<div><br /><br />
    <label>Model Released: </label>    
        <select id="symbiostock_model_released"  name="symbiostock_model_released">
            <option <?php echo $symbiostock_model_released_yes; ?> value="Yes">Yes</option>
            <option <?php echo $symbiostock_model_released_no; ?> value="No">No</option>
            <option <?php echo $symbiostock_model_released_na; ?> value="N/A">N/A</option>
        </select><br />
    <label>Property Released: </label>    
        <select id="symbiostock_property_released"  name="symbiostock_property_released">
            <option <?php echo $symbiostock_property_released_yes; ?> value="Yes">Yes</option>
            <option <?php echo $symbiostock_property_released_no; ?> value="No">No</option>
            <option <?php echo $symbiostock_property_released_na; ?> value="N/A">N/A</option>
    </select>
    <br /><br /><br />        
</div>    
    
<?php
	
	$locked == 'not_locked' || !isset($locked)  ? $not_locked = 'selected="selected"' : $not_locked = '';
	$locked == 'locked' ? $locked = 'selected="selected"' : $locked = '';
	
	?>
<div>
    <label>Values Locked: </label>
    <select name="locked">
        <option <?php echo $not_locked; ?> value="not_locked">Not Locked</option>
        <option <?php echo $locked; ?> value="locked">Locked</option>
    </select>
</div>
<br />
<div>
    <label>Referral Link #1: </label>
    <input size="50" type="text" name="symbiostock_referral_link_1" value="<?php
    echo $symbiostock_referral_link_1;
?>" />
    <br />
    <label>Label: </label>
    <input size="50" type="text" name="symbiostock_referral_label_1" value="<?php
    echo $symbiostock_referral_label_1;
?>" /><br /><br />
</div>
<div>
    <label>Referral Link #2: </label>
    <input size="50" type="text" name="symbiostock_referral_link_2" value="<?php
    echo $symbiostock_referral_link_2;
?>" />
    <br />
    <label>Label: </label>
    <input size="50" type="text" name="symbiostock_referral_label_2" value="<?php
    echo $symbiostock_referral_label_2;
?>" /><br /><br />
</div>
<div>
    <label>Referral Link #3: </label>
    <input size="50" type="text" name="symbiostock_referral_link_3" value="<?php
    echo $symbiostock_referral_link_3;
?>" />
    <br />
    <label>Label: </label>
    <input size="50" type="text" name="symbiostock_referral_label_3" value="<?php
    echo $symbiostock_referral_label_3;
?>" /><br /><br />
</div>
<div>
    <label>Referral Link #4: </label>
    <input size="50" type="text" name="symbiostock_referral_link_4" value="<?php
    echo $symbiostock_referral_link_4;
?>" />
    <br />
    <label>Label: </label>
    <input size="50" type="text" name="symbiostock_referral_label_4" value="<?php
    echo $symbiostock_referral_label_4;
?>" /><br /><br />
</div>
<div>
    <label>Referral Link #5: </label>
    <input size="50" type="text" name="symbiostock_referral_link_5" value="<?php
    echo $symbiostock_referral_link_5;
?>" />
    <br />
    <label>Label: </label>
    <input size="50" type="text" name="symbiostock_referral_label_5" value="<?php
    echo $symbiostock_referral_label_5;
?>" /><br /><br />
<br class="clear" />
</div>
</div>

<?php
    
}
add_action( 'save_post', 'symbiostock_image_manager_save_options' );
function symbiostock_image_manager_save_options( )
{
    global $post;
	global $post_type;
	
	if($post_type != 'image')
		return;
		
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
        
    } //defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
	
	
    else {
		
        update_post_meta( $post->ID, 'price_bloggee', $_POST[ 'price_bloggee' ] );        
        update_post_meta( $post->ID, 'price_small', $_POST[ 'price_small' ] );        
        update_post_meta( $post->ID, 'price_medium', $_POST[ 'price_medium' ] );        
        update_post_meta( $post->ID, 'price_large', $_POST[ 'price_large' ] );        
        update_post_meta( $post->ID, 'price_vector', $_POST[ 'price_vector' ] );		
		update_post_meta( $post->ID, 'price_zip', $_POST[ 'price_zip' ] );        
        update_post_meta( $post->ID, 'discount_percent', $_POST[ 'discount_percent' ] );        
        update_post_meta( $post->ID, 'exclusive', $_POST[ 'exclusive' ] );		
		update_post_meta( $post->ID, 'locked', $_POST[ 'locked' ] );		
		update_post_meta( $post->ID, 'live', $_POST[ 'live' ] );		
		
		//availability options symbiostock_  $size _available		
		update_post_meta( $post->ID, 'symbiostock_bloggee_available', $_POST[ 'symbiostock_bloggee_available' ] );		
		update_post_meta( $post->ID, 'symbiostock_small_available', $_POST[ 'symbiostock_small_available' ] );		
		update_post_meta( $post->ID, 'symbiostock_medium_available', $_POST[ 'symbiostock_medium_available' ] );		
		update_post_meta( $post->ID, 'symbiostock_large_available', $_POST[ 'symbiostock_large_available' ] );		
		update_post_meta( $post->ID, 'symbiostock_vector_available', $_POST[ 'symbiostock_vector_available' ] );		
		update_post_meta( $post->ID, 'symbiostock_zip_available', $_POST[ 'symbiostock_zip_available' ] );	
		
		//rank and rating
		update_post_meta( $post->ID, 'symbiostock_rank', $_POST[ 'symbiostock_rank' ] );	
		update_post_meta( $post->ID, 'symbiostock_rating', $_POST[ 'symbiostock_rating' ] );	
		
		//size info
		
		$size_info = symbiostock_change_image_sizes($post->ID, $_POST['symbiostock_bloggee_size'], $_POST['symbiostock_small_size'], $_POST['symbiostock_medium_size']);
		update_post_meta($post->ID, 'size_info', $size_info );
		
		//legal 
		update_post_meta( $post->ID, 'symbiostock_model_released', $_POST[ 'symbiostock_model_released' ] );	
		update_post_meta( $post->ID, 'symbiostock_property_released', $_POST[ 'symbiostock_property_released' ] );	
		
		//referral links
		update_post_meta( $post->ID, 'symbiostock_referral_label_1', $_POST[ 'symbiostock_referral_label_1' ] );
		update_post_meta( $post->ID, 'symbiostock_referral_label_2', $_POST[ 'symbiostock_referral_label_2' ] );	
		update_post_meta( $post->ID, 'symbiostock_referral_label_3', $_POST[ 'symbiostock_referral_label_3' ] );	
		update_post_meta( $post->ID, 'symbiostock_referral_label_4', $_POST[ 'symbiostock_referral_label_4' ] );	
		update_post_meta( $post->ID, 'symbiostock_referral_label_5', $_POST[ 'symbiostock_referral_label_5' ] );	
				
		update_post_meta( $post->ID, 'symbiostock_referral_link_1', $_POST[ 'symbiostock_referral_link_1' ] );
		update_post_meta( $post->ID, 'symbiostock_referral_link_2', $_POST[ 'symbiostock_referral_link_2' ] );	
		update_post_meta( $post->ID, 'symbiostock_referral_link_3', $_POST[ 'symbiostock_referral_link_3' ] );	
		update_post_meta( $post->ID, 'symbiostock_referral_link_4', $_POST[ 'symbiostock_referral_link_4' ] );	
		update_post_meta( $post->ID, 'symbiostock_referral_link_5', $_POST[ 'symbiostock_referral_link_5' ] );				
        
    }     
    
}
add_filter( 'manage_edit-image_columns', 'symbiostock_image_manager_edit_columns' );
function symbiostock_image_manager_edit_columns( $columns )
{
    $columns = array(
         'cb' => '<input type="checkbox" />',
		'image_preview' => 'Preview',
		'date' => 'Uploaded',
        'title' => 'Image Name',
        'description' => 'Description',
        'exclusive' => 'Exclusive',
        'price_bloggee' => 'Bloggee',
        'price_small' => 'Small',
        'price_medium' => 'Medium',
        'price_large' => 'Large',
        'price_vector' => 'Vector',
        'cat' => 'Category',
        'tag' => 'Keywords' 
    );
    
    return $columns;
}
add_action( 'manage_image_posts_custom_column', 'symbiostock_image_manager_custom_columns' );
function symbiostock_image_manager_custom_columns( $column )
{
    global $post;
    	
    $custom = get_post_custom();
    
    switch ( $column ) {
        
		 case 'date':            
            		
			        
            break;
		
		  
		case 'image_preview':
            
            echo '<img class="admin_preview_pic" alt="Image Preview" src="' . $custom['symbiostock_minipic'][0] . '" />';
            
            break;
		
        case 'description':
            
            the_excerpt();
            
            break;
        
        case 'exclusive':
            
            echo $exclusive = ucwords(str_replace('_', ' ', $custom[ "exclusive" ][ 0 ]));
            
            break;
        
        case 'discount_percent':
            
            echo $discount_percent = $custom[ "discount_percent" ][ 0 ];
            
            break;
        
        case 'price_bloggee':
            
            echo $price_bloggee = $custom[ "price_bloggee" ][ 0 ];
            
            
            break;
        
        case 'price_small':
            
            echo $custom[ "price_small" ][ 0 ];
            
            break;
        
        case 'price_medium':
            
            echo $custom[ "price_medium" ][ 0 ];
            
            break;
        
        case 'price_large':
            
            echo $custom[ "price_large" ][ 0 ];
            
            break;
        
        case 'price_vector':
            
            echo $custom[ "price_vector" ][ 0 ];
            
            break;
        
        case 'cat':
            
            echo get_the_term_list( $post->ID, 'image-type', '', ', ', '' );
            
            break;
        
        case 'tag':
            
            echo get_the_term_list( $post->ID, 'image-tags', '', ', ', '' );
            
            break;
            
    } //$column    
}
// ---------- upload panel ---------- //
function uploader( )
{
    include_once( 'classes/uploader.php' );
    
}
function symbiostock_processor( )
{
    include_once( 'classes/processor.php' );
    
}
add_action( 'admin_menu', 'register_symbiostock_image_submenu_page' );
function register_symbiostock_image_submenu_page( )
{
    add_submenu_page( 'edit.php?post_type=image', 'Upload Images', 'Upload Images', 'manage_options', 'symbiostock-upload-images', 'uploader' );
    
    add_submenu_page( 'edit.php?post_type=image', 'Process Uploads', 'Process Uploads', 'manage_options', 'symbiostock-process-images', 'symbiostock_processor' );
    
}
//get js for uploader script and css, found under image custom post menu
//http://www.plupload.com/example_queuewidget.php
if(isset($_GET[ 'page' ])){
	
	if ( is_admin() && $_GET[ 'page' ] == 'symbiostock-upload-images' ) {
		
		//get browserplus
		
		wp_register_script( 'symbiostock_browserplus', 'http://bp.yahooapis.com/2.4.21/browserplus-min.js' );
		
		wp_enqueue_script( 'symbiostock_browserplus' );
		
		//get plupload css
		
		wp_register_style( 'symbiostock_plupload_css', WP_CONTENT_URL . '/plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css', false, '1.0.0' );
		
		wp_enqueue_style( 'symbiostock_plupload_css' );
		
		
		//Load plupload and all it's runtimes and finally the jQuery queue widget
		
		wp_register_script( 'symbiostock_plupload_full_js', WP_CONTENT_URL . '/plupload/js/plupload.full.js', array(
			 'jquery' 
		), '1.0', false );
		
		wp_enqueue_script( 'symbiostock_plupload_full_js' );
		
		wp_register_script( 'symbiostock_plupload_queue', WP_CONTENT_URL . '/plupload/js/jquery.plupload.queue/jquery.plupload.queue.js', array(
			 'jquery' 
		), '1.0', false );
		
		wp_enqueue_script( 'symbiostock_plupload_queue' );
		
		
		//and add the plupload head js with altered paths and such...
		
		function uploader_head_js( )
		{
	?>
<script type="text/javascript">
	// Convert divs to queue widgets when the DOM is ready
	jQuery(function($) {
		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'gears,flash,silverlight,browserplus,html5',
			url : '<?php
			echo WP_CONTENT_URL;
	?>/plupload/uploads/upload.php',
			max_file_size : '1000mb',
			unique_names : false,
			// Specify what files to browse for
			filters : [
				{title : "Types: jpg, png, eps, zip.", extensions : "jpg,png,eps,zip"}
				
			],
	
			// Flash settings
			flash_swf_url : '<?php
			echo WP_CONTENT_URL;
	?>/plupload/js/plupload.flash.swf',
	
			// Silverlight settings
			silverlight_xap_url : '<?php
			echo WP_CONTENT_URL;
	?>/plupload/js/plupload.silverlight.xap'
		});
	
		// Client side form validation
		$('form').submit(function(e) {
			var uploader = $('#uploader').pluploadQueue();
	
			// Files in queue upload them first
			if (uploader.files.length > 0) {
				// When all files are uploaded submit form
				uploader.bind('StateChanged', function() {
					if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
						$('form')[0].submit();
					}
				});
					
				uploader.start();
			} else {
				alert('You must queue at least one file.');
			}
	
			return false;
		});
	});
	</script>
<style>
	#wpbody{
		background-image: url(<?php
			echo symbiostock_IMGDIR;
	?>/bg/subtle_dots.png);	
		
		}
	</style>
<?php
			
		}
		// Add hook for admin <head></head>
		add_action( 'admin_head', 'uploader_head_js' );
		
	} //is_admin() && $_GET[ 'page' ] == 'symbiostock-upload-images'
}

//TEMPORARILY we remove the "new image' functionality until we put it in. For now, new images are created on upload.
function symbiostock_adjust_the_wp_menu() {
  
  //or for custom post type 'myposttype'.
  remove_submenu_page( 'edit.php?post_type=image', 'post-new.php?post_type=image' );  
}
add_action( 'admin_menu', 'symbiostock_adjust_the_wp_menu', 999 );
//add rewrite rules
add_action( 'init', 'symbiostock_rewrite' );
function symbiostock_rewrite( )
{	
    global $wp_rewrite;
    $wp_rewrite->add_permastruct('typename','typename/%year%%postname%/' , true , 1);
    add_rewrite_rule('typename/([0-9]{4})/(.+)/?$','index.php?typename=$matches[2]', 'top');
    $wp_rewrite->flush_rules();
}
?>