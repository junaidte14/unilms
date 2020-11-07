<?php
	$active_tab = isset( $_GET[ 'tab' ] ) ? esc_html($_GET[ 'tab' ]) : 'about';
	$page_action = isset( $_GET[ 'page_action' ] ) ? esc_html($_GET[ 'page_action' ]) : '';
?>

<h2 class="nav-tab-wrapper">
    <a href="<?php echo esc_url('?page=unilms&tab=about');?>" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>">About</a>
    <a href="<?php echo esc_url('?page=unilms&tab=quickguide');?>" class="nav-tab <?php echo $active_tab == 'quickguide' ? 'nav-tab-active' : ''; ?>">Quick Guide</a>
</h2>

<?php         
    if($active_tab == 'about') {
	    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/admin/about.php');
    }
    elseif($active_tab == 'quickguide'){
        include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/admin/quickguide.php');
    }
     
?>
