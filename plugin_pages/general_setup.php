<?php
	$active_tab = isset( $_GET[ 'tab' ] ) ? esc_html($_GET[ 'tab' ]) : 'home';
	$page_action = isset( $_GET[ 'page_action' ] ) ? esc_html($_GET[ 'page_action' ]) : '';
?>

<h2 class="nav-tab-wrapper">
    <a href="<?php echo esc_url('?page=uni_lms&tab=home');?>" class="nav-tab <?php echo $active_tab == 'home' ? 'nav-tab-active' : ''; ?>">Home</a>
</h2>

<?php         
    if( $active_tab == 'home' ) {
        include( plugin_dir_path( __FILE__ ) . 'includes/admin/home.php');
    } else{

    }
     
?>