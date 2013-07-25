<?php
settings_fields( 'symbiostock_settings_group' ); 
if(isset($_POST['symbiostock_logo_link'])){ update_option('symbiostock_logo_link', $_POST['symbiostock_logo_link']); }
	
if(isset($_POST['symbiostock_login_logo_link'])){ update_option('symbiostock_login_logo_link', $_POST['symbiostock_login_logo_link']); }
if(isset($_POST['symbiostock_watermark_link'])){ update_option('symbiostock_watermark_link', $_POST['symbiostock_watermark_link']); }
if(isset($_POST['symbiostock_paypal_email'])){ update_option('symbiostock_paypal_email', $_POST['symbiostock_paypal_email']); }
if(isset($_POST['symbiostock_correspondence_email'])){ update_option('symbiostock_correspondence_email', $_POST['symbiostock_correspondence_email']); }
if(isset($_POST['symbiostock_customer_area_greeting'])){ update_option('symbiostock_customer_area_greeting', $_POST['symbiostock_customer_area_greeting']); }
if(isset($_POST['symbiostock_customer_welcome_body'])){ update_option('symbiostock_customer_welcome_body', $_POST['symbiostock_customer_welcome_body']); }
if(isset($_POST['symbiostock_customer_thank_you'])){ update_option('symbiostock_customer_thank_you', $_POST['symbiostock_customer_thank_you']); }
if(isset($_POST['symbiostock_eula_page'])){ update_option('symbiostock_eula_page', $_POST['symbiostock_eula_page']); }
if(isset($_POST['symbiostock_logo_for_paypal'])){ update_option('symbiostock_logo_for_paypal', $_POST['symbiostock_logo_for_paypal']); }
if(isset($_POST['symbiostock_copyright_name'])){ update_option('symbiostock_copyright_name', $_POST['symbiostock_copyright_name']); }
//symbiostock_paypal_live_or_sandbox
if(isset($_POST['symbiostock_paypal_live_or_sandbox'])){ 
update_option('symbiostock_paypal_live_or_sandbox', $_POST['symbiostock_paypal_live_or_sandbox']); 
}
$symbiostock_paypal_live_or_sandbox = get_option('symbiostock_paypal_live_or_sandbox');
$symbiostock_paypal_live_or_sandbox == 'sandbox' || !isset($symbiostock_paypal_live_or_sandbox)  ? $symbiostock_paypal_sandbox = 'checked="checked"' : $symbiostock_paypal_sandbox = '';
$symbiostock_paypal_live_or_sandbox == 'live' ? $symbiostock_paypal_live = 'checked="checked"' : $symbiostock_paypal_live = '';
//symbiostock_credit_links
if(isset($_POST['symbiostock_credit_links'])){ 
update_option('symbiostock_credit_links', $_POST['symbiostock_credit_links']); 
}
$symbiostock_credit_links = get_option('symbiostock_credit_links');
$symbiostock_credit_links == 'product_page' || !isset($symbiostock_credit_links)  ? $symbiostock_credit_links_product_page = 'checked="checked"' : $symbiostock_credit_links_product_page = '';
$symbiostock_credit_links == 'footer' ? $symbiostock_credit_links_footer = 'checked="checked"' : $symbiostock_credit_links_footer = '';
$symbiostock_credit_links == 'no_use' ? $symbiostock_credit_links_no_use = 'checked="checked"' : $symbiostock_credit_links_no_use = '';
//symbiostock_currency
if(isset($_POST['symbiostock_currency'])){ 
update_option('symbiostock_currency', $_POST['symbiostock_currency']); 
}
$symbiostock_currency = get_option('symbiostock_currency');
$symbiostock_currency == 'USD' || !isset($symbiostock_currency)  ? $symbiostock_currency_USD = 'selected="selected"' : $symbiostock_currency_USD = '';
$symbiostock_currency == 'EUR' ? $symbiostock_currency_EUR = 'selected="selected"' : $symbiostock_currency_EUR = '';
$symbiostock_currency == 'GBP' ? $symbiostock_currency_GBP = 'selected="selected"' : $symbiostock_currency_GBP = '';
$symbiostock_currency == 'CAD' ? $symbiostock_currency_CAD = 'selected="selected"' : $symbiostock_currency_CAD = '';
$symbiostock_currency == 'JPY' ? $symbiostock_currency_JPY = 'selected="selected"' : $symbiostock_currency_JPY = '';
//symbiostock_theme_credit
if(isset($_POST['symbiostock_theme_credit'])){ 
update_option('symbiostock_theme_credit', $_POST['symbiostock_theme_credit']); 
}
$symbiostock_theme_credit = get_option('symbiostock_theme_credit', '');
$symbiostock_theme_credit == 'on' || !isset($symbiostock_theme_credit)  ? $symbiostock_theme_credit_on = 'checked="checked"' : $symbiostock_theme_credit_on = '';
$symbiostock_theme_credit == 'off' ? $symbiostock_theme_credit_off = 'checked="checked"' : $symbiostock_theme_credit_off = '';
//watermark
$watermark = symbiostock_CLASSDIR . '/image-processor/symbiostock-watermark.png';
$logo = get_option('symbiostock_logo_link', symbiostock_LOGO  );
if(empty($logo)){
	update_option('symbiostock_logo_link',  symbiostock_LOGO);
	}
global $current_user;
      get_currentuserinfo();
?>
<table class="widefat form-table symbiostock-settings">
    <thead>
        <tr>
            <th colspan="2"> <strong>Branding and Image</strong> - Paste urls from <a title="Media Uploader" href="<?php echo get_home_url(); ?>/wp-admin/upload.php">media uploader</a> below. <br />
                <br />
                <em>Need some templates? (<a title="Photoshop and Jpeg Symbiostock Branding Templates" href="https://github.com/orangeman555/symbiostock/blob/master/Symbiostock%20branding%20templates%20PSD%20and%20JPG.zip?raw=true">PSD and JPG</a> | <a title="AI and EPS Symbiostock Branding Templates" href="https://github.com/orangeman555/symbiostock/blob/master/Symbistock%20branding%20templates%20AI%20and%20EPS.zip?raw=true">AI and EPS</a>)</em>
                &mdash; <?php echo sshelp('templates', 'Templates'); ?> </th>
        </tr>
    </thead>
    
    <?php do_action('ss_settings_table_top') ?>
    
    <tr>
        <th scope="row">Header Logo<br /><?php echo sshelp('header_logo', 'Header Logo'); ?></th>
        <td><input class="symbiostock_settings" type="text" name="symbiostock_logo_link"  id="symbiostock_logo_link" value="<?php echo get_option('symbiostock_logo_link', symbiostock_LOGO  ); ?>" />
    </td>
    </tr>
    <tr>
        <th scope="row">Login Page Logo<br /> <?php echo sshelp('login_page_logo', 'Login Page Logo'); ?></th>
        <td><input class="symbiostock_settings" type="text" name="symbiostock_login_logo_link"  id="symbiostock_login_logo_link" value="<?php echo get_option('symbiostock_login_logo_link', symbiostock_IMGDIR . '/site-login-logo.png'  ); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row">Watermark Image<br /> <?php echo sshelp('watermark_image', 'Watermark Image'); ?></th>
        <td><input class="symbiostock_settings" type="text" name="symbiostock_watermark_link"  id="symbiostock_watermark_link" value="<?php echo get_option('symbiostock_watermark_link', $watermark ); ?>" />
            <br />
        </td>
    </tr>
    <thead>
        <tr>
            <th colspan="2"> <strong>Email and Payment Process Communication</strong></th>
        </tr>
    </thead>
    <tr>
        <th scope="row">Paypal Email &amp; IPN <br />
            <br />
            <label for="symbiostock_paypal_live">
                <input type="radio" id="symbiostock_paypal_live" name="symbiostock_paypal_live_or_sandbox" <?php echo $symbiostock_paypal_live; ?> value="live" />
                <a target="_blank" title="Paypal" href="https://www.paypal.com/">Live</a> </label>
            <label for="symbiostock_paypal_sandbox">
                <input type="radio" id="symbiostock_paypal_sandbox" name="symbiostock_paypal_live_or_sandbox" <?php echo $symbiostock_paypal_sandbox ; ?> value="sandbox" />
                <a target="_blank" title="Paypal Sandbox" href="https://www.sandbox.paypal.com//">Sandbox (testing)</a> </label>
                <br /><br /><br /> <?php echo sshelp('paypal', 'Paypal help.'); ?> 
        </th>
        <td><label for="symbiostock_paypal_email">
                <input class="symbiostock_settings" type="text" name="symbiostock_paypal_email"  id="symbiostock_paypal_email" value="<?php echo get_option('symbiostock_paypal_email'); ?>" />
                Paypal Email</label>
            <br />
            <br />
            <label for="symbiostock_ipn"><strong>
                <input onClick="this.select();" id="symbiostock_ipn" class="symbiostock_settings" type="text"  value="<?php echo get_bloginfo('url') . '/symbiostock_ipn/'; ?>" />
                </strong> Paypal IPN</label>
            <br />
            <br />
            <label for="symbiostock_logo_for_paypal">
                <input class="symbiostock_settings" type="text" name="symbiostock_logo_for_paypal"  id="symbiostock_logo_for_paypal" value="<?php echo get_option('symbiostock_logo_for_paypal'); ?>" />
                Site Paypal Logo</label>
            <br />
            *Your logo seen on the paypal site when the customer is paying. Exactly <strong>150px by 50px</strong>. 
            
            <!--CURRENCY--> 
            <br />
            <label for="symbiostock_currency">
                <?php
            $symbiostock_currencies = array(
                'USD' => __( 'US Dollars ($)', 'symbiostock' ),
                'EUR' => __( 'Euros (€)', 'symbiostock' ),
                'GBP' => __( 'Pounds Sterling (£)', 'symbiostock' ),
                'CAD' => __( 'Canadian Dollars ($)', 'symbiostock' ),
                'JPY' => __( 'Japanese Yen (¥)', 'symbiostock' ),
            );
            ?>
                <select id="symbiostock_currency" name="symbiostock_currency">
                    <?php
            foreach ($symbiostock_currencies as $currency => $desc){
					echo 'symbiostock_currency_'.$currency;
					$symbiostock_currency_selected = ${'symbiostock_currency_'.$currency};					
					?>
                    <option <?php echo $symbiostock_currency_selected; ?> value="<?php echo $currency ?>" ><?php echo $desc; ?></option>
                    <?php	
                }
            ?>
                </select>
                - Shop Currency </label>
            
            <!--/CURRENCY--></td>
    </tr>
    <tr>
        <th scope="row">Correspondence Email <br /> <?php echo sshelp('email', 'Email'); ?> </th>
        <td><input class="symbiostock_settings" type="text" name="symbiostock_correspondence_email"  id="symbiostock_correspondence_email" value="<?php echo get_option('symbiostock_correspondence_email', $current_user->user_email); ?>" />
        </td>
    </tr>
    <tr>
        <th scope="row">Customer Area Greeting</th>
        <td><textarea class="symbiostock_settings" name="symbiostock_customer_area_greeting"  id="symbiostock_customer_area_greeting"><?php echo stripslashes(get_option('symbiostock_customer_area_greeting')); ?></textarea>
            <br />
            Welcome your customer, talk about stuff - <?php echo symbiostock_customer_area( '<em>Top of Customer Area.</em>' ); ?> HTML allowed.</td>
    </tr>
    <tr>
        <th scope="row">Customer Welcome Email <br /> <?php echo sshelp('email', 'Email'); ?> </th>
        <td><textarea class="symbiostock_settings" name="symbiostock_customer_welcome_body"  id="symbiostock_customer_welcome_body"><?php echo stripslashes(get_option('symbiostock_customer_welcome_body')); ?></textarea>
        </td>
    </tr>
    <tr>
        <th scope="row">Customer Thank You Email <br /> <?php echo sshelp('email', 'Email'); ?> </th>
        <td><textarea class="symbiostock_settings" name="symbiostock_customer_thank_you"  id="symbiostock_customer_thank_you"><?php echo stripslashes(get_option('symbiostock_customer_thank_you')); ?></textarea>
        </td>
    </tr>
    
    <?php do_action('ss_settings_table_bottom') ?>
    
    <thead>
        <tr>
            <th colspan="2"> <strong>Credit Links</strong> &mdash; <?php echo sshelp('credit_links', 'About Credit Links'); ?> </th>
        </tr>
    </thead>
    <tr>
        <td colspan="2"><label for="symbiostock_credit_links_1">
                <input type="radio" id="symbiostock_credit_links_1" name="symbiostock_credit_links" <?php echo $symbiostock_credit_links_product_page; ?> value="product_page" />
                <strong> Product Page (Suggested)</strong></label>
            <br />
            <label for="symbiostock_credit_links_2">
                <input type="radio" id="symbiostock_credit_links_2" name="symbiostock_credit_links" <?php echo $symbiostock_credit_links_footer ; ?> value="footer" />
                In Footer </label>
            <br />
            <label for="symbiostock_credit_links_3">
                <input type="radio" id="symbiostock_credit_links_3" name="symbiostock_credit_links" <?php echo $symbiostock_credit_links_no_use ; ?> value="no_use" />
                Do Not Use</label>
            <br />
            <br />
            Backlinks to <a title="clipartillustration.com" href="http://www.clipartillustration.com/">Leo Blanchette's main selling website</a>, <a title="ClipArtOf.com" href="http://www.clipartof.com/">ClipArtOf.com</a> (Special thanks to Kenny and Jamie), and <a title="Microstockgroup.com" href="http://www.microstockgroup.com/">MicrostockGroup.com</a>, who hosts the Symbiostock knowledge forums.<br />
            This is one of the few ways I profit on this theme, so I thank you for keeping this live.
            
            <br /><br />
            
            <label for="symbiostock_theme_credit_on">
                <input type="radio" id="symbiostock_theme_credit_on" name="symbiostock_theme_credit" <?php echo $symbiostock_theme_credit_on; ?> value="on" />
                Wordpress / Theme credit <strong>ON</strong></label>
            <br />
            <label for="symbiostock_theme_credit_off">
                <input type="radio" id="symbiostock_theme_credit_off" name="symbiostock_theme_credit" <?php echo $symbiostock_theme_credit_off ; ?> value="off" />
                Wordpress / Theme credit <strong>OFF</strong></label>
            
            </td>
            
   		</tr>
    
   		
        <tr>
        <th scope="row">Footer Copyright Info</th>
        <td><label>Copyright name: <input type="text" class="symbiostock_settings" name="symbiostock_copyright_name"  id="symbiostock__copyright_name" value="<?php echo stripslashes(get_option('symbiostock_copyright_name', '')); ?>" /></label>          
        </td>
    </tr>
</table>
