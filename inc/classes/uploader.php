<div id="symbiostock_uploader_container">
    <h1>Symbiostock Image Uploader</h1>
    <form>
        <div id="uploader">
            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
        </div>
    </form>
    <div class="info">    
    <p><em>Want to use <strong>FTP</strong></em>? Here is the uploads folder:  <input size="140" type="text" onClick="this.select();" value="<?php echo WP_CONTENT_DIR . "/plupload/uploads/"; ?>" /></p>
    
    <h3>Uploading Directions <strong>( .jpg .eps .png .zip )</strong></h3>
    
    For best results, upload in batches of less than 40 or 50.
       
        <strong>Shift+drag</strong> to select groups of files, or <strong>CTRL+click</strong> to select individual files one by one.</p>
    <p><strong>EPS</strong>(vector) files must be accompanied by high-res <strong>JPEG</strong> or <strong>PNG</strong> files with <em>the same name</em>. Example:
    <ul>
        <li><strong>my_stock_art</strong>.eps</li>
        <li><strong>my_stock_art</strong>.jpg
        
        </li>
    </ul>
    </p>
    <hr />
    <h4>When uploading is completed...</h4>
    <p>...proceed to <strong><a title="Process files" href="<?php echo get_home_url(); ?>/wp-admin/edit.php?post_type=image&page=symbiostock-process-images">Process Images</a></strong> to process them.</p>
	
    </div>
</div>
