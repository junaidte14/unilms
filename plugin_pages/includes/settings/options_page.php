<?php
if(function_exists( 'wp_enqueue_media' )){
    wp_enqueue_media();
}else{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
?>

<div class="wrap">
<h1><?php esc_attr_e('UniLMS', 'unilms');?></h1>

<form method="post" action="options.php">
    <?php settings_fields( 'uni_lms_settings' ); ?>
    <?php
    	$options = get_option('uni_lms_options');
    	if(!empty($options)){
    		if(array_key_exists('uni_lms_inst_logo', $options)){
	    		$current_logo = $options['uni_lms_inst_logo'];
	    	}else{
	    		$current_logo = '';
	    	}
            
    	}else{
    		$current_logo = '';
    	}

    ?>

    <p>
    	<h3><?php esc_attr_e('Institute Logo Image URL:', 'unilms');?></h3>
    	<span><?php esc_attr_e('To be used while printing course files or other documents', 'unilms');?></span></br></br>
    	<?php 
    	if($current_logo != ""){
    	?>
        	<img class="uni_lms_inst_logo" src="<?php echo esc_url($current_logo); ?>" height="100" width="100"/></br></br>
        <?php }?>
        <input class="uni_lms_inst_logo_url" type="text" name="uni_lms_options[uni_lms_inst_logo]" size="60" value="<?php echo esc_url($current_logo); ?>">
        <a href="#" id="uni_lms_inst_logo_upload"><?php esc_attr_e('Upload', 'unilms');?></a>
	</p>
    
    <?php submit_button(); ?>

</form>

<script>
    jQuery(document).ready(function($) {
        $('#uni_lms_inst_logo_upload').click(function(e) {
            e.preventDefault();

            var custom_uploader = wp.media({
                title: 'Custom Image',
                button: {
                    text: 'Upload Image'
                },
                multiple: false  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.uni_lms_inst_logo').attr('src', attachment.url);
                $('.uni_lms_inst_logo_url').val(attachment.url);

            })
            .open();
        });
    });
</script>
</div>