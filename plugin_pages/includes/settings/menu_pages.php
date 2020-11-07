<?php
function display_uni_lms_setup_page_std() {
    require_once(UNI_LMS_BASE_DIR . '/plugin_pages/includes/admin/home.php');
}

function display_uni_lms_settings_page_std() {
    require_once(plugin_dir_path(__FILE__). '/options_page.php');
}

function uni_lms_admin_actions_std() {
	global $unilmspro_plugin_name;
	add_menu_page( __('UniLMS Settings Page', 'unilms'), 'UniLMS', 'edit_posts', $unilmspro_plugin_name, 'display_uni_lms_setup_page_std', 'dashicons-welcome-learn-more', 30
    );
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Dashboard', 'unilms'), 'Dashboard', 'edit_posts', $unilmspro_plugin_name, 'display_uni_lms_setup_page_std'
    );
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Classes', 'unilms'), 'Classes', 'administrator','edit.php?post_type=uni_lms_classes');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Courses', 'unilms'), 'Courses', 'edit_posts','edit.php?post_type=uni_lms_courses');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Lectures', 'unilms'), 'Lectures', 'edit_posts','edit.php?post_type=uni_lms_lectures');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Activities', 'unilms'), 'Activities', 'edit_posts','edit.php?post_type=uni_lms_quizzes');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Attendances', 'unilms'), 'Attendances', 'edit_posts','edit.php?post_type=uni_lms_attendances');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Course Files', 'unilms'), 'Course Files', 'edit_posts','edit.php?post_type=uni_lms_course_files');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Students', 'unilms'), 'Students', 'edit_posts','edit.php?post_type=uni_lms_students');
    add_submenu_page( $unilmspro_plugin_name, __('UniLMS Settings', 'unilms'), 'Settings', 'administrator', 'uni_lms_settings', 'display_uni_lms_settings_page_std'
    );
}

/* Parent Menu Fix */
add_filter( 'parent_file', 'uni_lms_parent_file_std' );
 
/**
 * Fix Parent Admin Menu Item
 */
function uni_lms_parent_file_std( $parent_file ){
 
    /* Get current screen */
    global $current_screen, $self, $unilmspro_plugin_name;
 
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 
        (
            'uni_lms_classes' == $current_screen->post_type ||
            'uni_lms_courses' == $current_screen->post_type ||
            'uni_lms_lectures' == $current_screen->post_type ||
            'uni_lms_quizzes' == $current_screen->post_type ||
            'uni_lms_attendances' == $current_screen->post_type ||
            'uni_lms_students' == $current_screen->post_type ||
            'uni_lms_course_files' == $current_screen->post_type
        ) 
    ) {
        $parent_file = $unilmspro_plugin_name;
    }
 
    return $parent_file;
}

add_filter( 'submenu_file', 'uni_lms_submenu_file_std' );
 
/**
 * Fix Sub Menu Item Highlights
 */
function uni_lms_submenu_file_std( $submenu_file ){
 
    /* Get current screen */
    global $current_screen, $self;
 
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_classes' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_classes';
    }
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_courses' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_courses';
    }
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_quizzes' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_quizzes';
    }
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_lectures' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_lectures';
    }
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_attendances' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_attendances';
    }
    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_students' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_students';
    }

    if ( in_array( $current_screen->base, array( 'post', 'edit' ) ) && 'uni_lms_course_files' == $current_screen->post_type ) {
        $submenu_file = 'edit.php?post_type=uni_lms_course_files';
    }
 
    return $submenu_file;
}

?>