<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package symbiostock
 * @since symbiostock 1.0
 */
?>
	</div><!-- #main .site-main -->
	</div>
    
<footer id="colophon" class="site-footer" role="contentinfo">
   	<div class="container">
		<div class="site-info row-fluid">
      
            
            <?php dynamic_sidebar('Footer 1/3'); ?> 			         
            
            <?php dynamic_sidebar('Footer 2/3'); ?>            
            
            <?php dynamic_sidebar('Footer 3/3'); ?>
            
			<?php symbiostock_credit_links('footer'); ?>
            </div>
                    
		</div><!-- .site-info -->
    
   <div class="footer_info">       
               <?php symbiostock_website_copyright(); ?>               
   </div>          
</footer><!-- #colophon .site-footer -->
<?php get_template_part('modal-login'); ?>
<?php wp_footer(); ?>

</body>
</html>