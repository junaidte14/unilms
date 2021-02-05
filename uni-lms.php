<?php
/**
 * The plugin bootstrap file
 * @link              https://codoplex.com
 * @since             1.0.6
 * @package           Unilms
 *
 * @wordpress-plugin
 * Plugin Name:       UniLMS
 * Plugin URI:        https://codecanyon.net/item/unilms-learning-management-system/20645782
 * Description:       A learning management system developed for universities, schools, colleges, academies or any other type of institutes.
 * Version:           1.0.6
 * Author:            Junaid Hassan
 * Author URI:        https://codoplex.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       unilms
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
 
if ( ! defined( 'UNI_LMS_BASE_FILE' ) )
    define( 'UNI_LMS_BASE_FILE', __FILE__ );
if ( ! defined( 'UNI_LMS_BASE_DIR' ) )
    define( 'UNI_LMS_BASE_DIR', dirname( UNI_LMS_BASE_FILE ) );
if ( ! defined( 'UNI_LMS_PLUGIN_URL' ) )
    define( 'UNI_LMS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

global $unilmspro_plugin_name;
$unilmspro_plugin_name = 'unilms';

global $unilmspro_plugin_version;
$unilmspro_plugin_version = '1.0.6';

if ( is_admin() ) {
    //this code runs only on the admin side
    /**
     * The code that runs during plugin activation.
     */
    function activate_uni_lms_std() {
        if ( is_plugin_active( 'unilms-pro/uni-lms.php' ) ) {
        deactivate_plugins('unilms-pro/uni-lms.php');
        }
    }

    /**
     * The code that runs during plugin deactivation.
     */
    function deactivate_uni_lms_std() {
        remove_role('uni_lms_teacher');
        remove_role('uni_lms_student');
    }

    register_activation_hook( __FILE__, 'activate_uni_lms_std' );
    register_deactivation_hook( __FILE__, 'deactivate_uni_lms_std' );

    /*Plugin Menu Handling*/
    require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/settings/menu_pages.php');
    add_action('admin_menu', 'uni_lms_admin_actions_std');

    /*Manage plugin options / settings page*/
    function uni_lms_options_validate_std($input) {
        $options = get_option('uni_lms_options');
        $options['uni_lms_inst_logo'] = trim($input['uni_lms_inst_logo']);
        $options['uni_lms_inst_logo'] = sanitize_text_field($options['uni_lms_inst_logo']);
        $options['uni_lms_teacher_time_table'] = intval($input['uni_lms_teacher_time_table']);
        return $options;
    }

    /*UniLMS Settings:*/
    function register_uni_lms_settings_std() { // whitelist options
    register_setting( 'uni_lms_settings', 'uni_lms_options', 'uni_lms_options_validate_std');
    }
    add_action( 'admin_init', 'register_uni_lms_settings_std' );

    /*Table Removal After Uninstalling the plugin*/
    register_uninstall_hook('uninstall.php', '');

    /*User Role Management*/
    function add_roles_on_uni_lms_activation_std() {
        $check_student_role = get_role( 'uni_lms_student' );
        if(null === $check_student_role){
            add_role( 'uni_lms_student', __('UNILMS Student', 'unilms'), array( 
                'read' => true,
                )
            );
        }

    }

    register_activation_hook( __FILE__, 'add_roles_on_uni_lms_activation_std' );

    //removing unnecessary menu items and certain actions for teachers
    add_action( 'admin_init', 'uni_lms_teacher_remove_menu_pages_std' );
    function uni_lms_teacher_remove_menu_pages_std() {
    
        global $user_ID;

        if ( current_user_can( 'uni_lms_student' ) ) {
            remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
            add_action( 'admin_head', function () {

                ob_start( function( $subject ) {

                    $subject = preg_replace( '#<h[0-9]>'.__("Personal Options", 'unilms').'</h[0-9]>.+?/table>#s', '', $subject, 1 );
                    return $subject;
                });
            });

            add_action( 'admin_footer', function(){

                ob_end_flush();
            }); 
        }
    }

    //setup plugin pages
    function add_uni_lms_pages_std(){
        // Create post object
        $courses_page = array(
        'post_title'    => __('Courses', 'unilms'),
        'post_type'     => 'page',
        'post_content'  => '[uni_lms_courses_list]',
        'post_status'   => 'publish'
        );
        
        // Insert the post into the database
        if(uni_lms_get_url_by_shortcode_std('[uni_lms_courses_list]') == ""){
            wp_insert_post( $courses_page );
        }

        $student_dash = array(
        'post_title'    => __('Student Dashboard', 'unilms'),
        'post_type'     => 'page',
        'post_content'  => '[uni_lms_student_dashboard]',
        'post_status'   => 'publish'
        );

        if(uni_lms_get_url_by_shortcode_std('[uni_lms_student_dashboard]') == ""){
            wp_insert_post( $student_dash );
        }
    }
    register_activation_hook( __FILE__, 'add_uni_lms_pages_std' );


}else{
    //this code runs only on the public side
}

/*Adding Required Classes for different modules of plugin and settings*/

//custom functions for our plugin
require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/settings/custom_functions.php');

/*Post duplications Settings*/
require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/settings/uni_lms_posts_duplicate.php');

/*Register custom post types*/
require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/courses/courses.php');

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/classes/classes.php');

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/students/students.php');

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/attendances/attendances.php');

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/lectures/lectures.php');

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/quizzes/quizzes.php');

require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/custom_posts/course_files/course_files.php');

/*Manage plugin scripts and styles*/
function uni_lms_scripts_styles_std()
{
    wp_register_style( 'uni_lms_tabs_style', plugins_url( '/css/uni_lms_tabs.css', __FILE__ ) );
    wp_register_style( 'uni_lms_styles', plugins_url( '/css/uni_lms_styles.css', __FILE__ ) );
    wp_register_style( 'uni_lms_print_style', plugins_url( '/css/uni_lms_print.css', __FILE__ ) );

    wp_register_script( 'uni_lms_tabs_script', plugins_url( '/js/uni_lms_tabs.js', __FILE__ ), array(), '', true);

    if( is_single() && (get_post_type()=='uni_lms_courses' || 
        get_post_type()=='uni_lms_quizzes'||
        get_post_type()=='uni_lms_course_files'||
        get_post_type()=='uni_lms_classes') ){
            wp_enqueue_style( 'uni_lms_tabs_style' );
            wp_enqueue_style( 'uni_lms_print_style' );
            wp_enqueue_script( 'uni_lms_tabs_script' );
    }
    wp_enqueue_style( 'uni_lms_styles' );
}
add_action( 'wp_enqueue_scripts', 'uni_lms_scripts_styles_std' );

//student dashboard shortcode
require_once( plugin_dir_path( __FILE__ ) . 'plugin_pages/includes/settings/student_dashboard.php');

/*translations*/
add_action('plugins_loaded', 'uni_lms_load_textdomain_std');
function uni_lms_load_textdomain_std() {
    load_plugin_textdomain( 'unilms', false, UNI_LMS_BASE_DIR . '/lang/' );
}


