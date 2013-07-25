<?php
//processes our ajax
function symbiostock_process_ajax( )
{
    //security check
    if ( !isset( $_POST[ 'symbiostock_nonce' ] ) || !wp_verify_nonce( $_POST[ 'symbiostock_nonce' ], 'symbiostock-nonce' ) )
        return;
    
	do_action('ss_admin_ajax');
	
    //we make a switch statement for different ajax requests
    
    switch ( $_POST ) {
        
        case $_POST[ 'action' ] == 'symbiostock_admin_form_submit':
            
            //for main symbiostock window, instantiate new admin panel class
            
            new symbiostock_render_admin_panel();
            
            break;
        
        case $_POST[ 'action' ] == 'symbiostock_process_images':
            
			include_once( 'image-processor/symbiostock_image_processor.php' );
			
            include_once( 'processor.php' );
            
            break;
            
    } //$_POST
    
    die( );
    
}
add_action( 'wp_ajax_symbiostock_admin_form_submit', 'symbiostock_process_ajax' );
add_action( 'wp_ajax_symbiostock_process_images', 'symbiostock_process_ajax' );
?>