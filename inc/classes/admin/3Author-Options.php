	<h1>Author Default Settings and Pricing</h1>
<?php
if(isset($_POST['symbiostock_update_images'])){	
	symbiostock_update_all_images();	
	$symbiostock_edited_all_images = '<p><em>Site images updated.</em></p>';	
}	

settings_fields( 'symbiostock_settings_group' ); 

symbiostock_settings_and_pricing();
?>
<label for="symbiostock_save_defaults"><input id="symbiostock_save_defaults" type="checkbox" name="symbiostock_save_defaults" value="1" /> 
<strong>Save as defaults?</strong> <span class="description">(Will apply to uploads as well).</span></label> 
<br /><br />
<label for="symbiostock_update_images">
<input value="1" id="symbiostock_update_images" type="checkbox" name="symbiostock_update_images" />

Update <strong>ALL existing images</strong> with new values? <em>Caution!</em></label>
<br />


<?php
//if image update occured, notify user 
if(isset($symbiostock_edited_all_images)){echo $symbiostock_edited_all_images;} 

?>