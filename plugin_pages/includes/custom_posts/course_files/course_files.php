<?php
/*create custom post type uni_lms_course_files*/

function create_post_uni_lms_course_files_std() {
    register_post_type( 'uni_lms_course_files',
        array(
            'labels' => array(
                'name' => __('Course Files', 'unilms'),
                'singular_name' => __('Course File', 'unilms'),
                'add_new' => __('Add New', 'unilms'),
                'add_new_item' => __('Add New Course File', 'unilms'),
                'edit' => __('Edit', 'unilms'),
                'edit_item' => __('Edit Course File', 'unilms'),
                'new_item' => __('New Course File', 'unilms'),
                'view' => __('View', 'unilms'),
                'view_item' => __('View Course File', 'unilms'),
                'search_items' => __('Search Course Files', 'unilms'),
                'not_found' => __('No Course File found', 'unilms'),
                'not_found_in_trash' => __('No Course Files found in Trash', 'unilms'),
                'parent' => __('Parent Course File', 'unilms')
            ),
 
            'public' => true,
            'supports' => array( 'title' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false,
        )
    );
}

add_action( 'init', 'create_post_uni_lms_course_files_std' );

function display_uni_lms_course_files_meta_box_std( $uni_lms_course_files ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_course_files_meta_box');
    }

    $course_file_course = esc_html (get_post_meta( $uni_lms_course_files->ID, 'course_file_course', true ));
    $course_file_class = esc_html (get_post_meta( $uni_lms_course_files->ID, 'course_file_class', true ));
    ?>
    <table>
        <tr>
            <td><?php _e('Select Course', 'unilms'); ?></td>
            <td>
                <?php 
                global $user_ID;
                if ( current_user_can( 'administrator' ) ) {
                    $args = array( 
                    'post_type' => 'uni_lms_courses',
                    'posts_per_page' => -1
                    );
                }else{
                    $args = array( 
                    'post_type' => 'uni_lms_courses',
                    'posts_per_page' => -1,
                    'author' => get_current_user_id()
                    );
                }
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_course_files_course">
                    <option value="0" <?php if($course_file_course == 0){echo 'selected';}?> ><?php _e('Select Course', 'unilms');?></option>
                    <?php

                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($course_file_course == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Courses Found. Please create new courses by visiting courses tab to see a dropdown list 
                    of all courses here', 'unilms');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Select Class', 'unilms'); ?></td>
            <td>
                <?php 
                $args = array( 
                    'post_type' => 'uni_lms_classes',
                    'posts_per_page' => -1
                );
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_course_files_class">
                    <option value="0" <?php if($course_file_class == 0){echo 'selected';}?> ><?php _e('Select Class', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($course_file_class == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No classes created by admin yet!', 'unilms');
                }
                ?>
            </td>
        </tr>
        
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_course_files_std() {
    add_meta_box( 'uni_lms_course_files_meta_box',
        __('Details', 'unilms'),
        'display_uni_lms_course_files_meta_box_std',
        'uni_lms_course_files', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_course_files_std' );

function add_uni_lms_course_files_fields_std( $uni_lms_course_files_id, $uni_lms_course_files ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_course_files_id );
    $is_revision = wp_is_post_revision( $uni_lms_course_files_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_course_files_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_course_files_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_course_files->post_type == 'uni_lms_course_files' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_course_files_course'] ) && $_POST['uni_lms_course_files_course'] != '' ) {
            update_post_meta( $uni_lms_course_files_id, 'course_file_course', intval($_POST['uni_lms_course_files_course'] ));
        }
        if ( isset( $_POST['uni_lms_course_files_class'] ) && $_POST['uni_lms_course_files_class'] != '' ) {
            update_post_meta( $uni_lms_course_files_id, 'course_file_class', intval($_POST['uni_lms_course_files_class'] ));
        }
    }
}

add_action( 'save_post', 'add_uni_lms_course_files_fields_std', 10, 2 );


function display_uni_lms_course_files_contents_meta_box_std( $uni_lms_course_files ) {
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_course_files_contents_meta_box');
    }
    $class_id = intval(get_post_meta( $uni_lms_course_files->ID, 'course_file_class', true ));
    $course_id = intval(get_post_meta( $uni_lms_course_files->ID, 'course_file_course', true ));
    
    //echo $course_id;
    $active_sub_tab = isset( $_GET[ 'sub_tab' ] ) ? $_GET[ 'sub_tab' ] : 'grad_policy';
    if($course_id != 0 && $class_id != 0):
        
    ?>
        <h2 class="nav-tab-wrapper">
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=grad_policy');?>" class="nav-tab <?php echo $active_sub_tab == 'grad_policy' ? 'nav-tab-active' : ''; ?>">Grad Policy</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=course_outline');?>" class="nav-tab <?php echo $active_sub_tab == 'course_outline' ? 'nav-tab-active' : ''; ?>">Course Outline</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=course_plan');?>" class="nav-tab <?php echo $active_sub_tab == 'course_plan' ? 'nav-tab-active' : ''; ?>">Course Plan</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=inst_log');?>" class="nav-tab <?php echo $active_sub_tab == 'inst_log' ? 'nav-tab-active' : ''; ?>">Instructor Log</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=stud_log');?>" class="nav-tab <?php echo $active_sub_tab == 'stud_log' ? 'nav-tab-active' : ''; ?>">Student Log</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=attendance');?>" class="nav-tab <?php echo $active_sub_tab == 'attendance' ? 'nav-tab-active' : ''; ?>">Attendance</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=quizzes');?>" class="nav-tab <?php echo $active_sub_tab == 'quizzes' ? 'nav-tab-active' : ''; ?>">Quizzes</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=assignments');?>" class="nav-tab <?php echo $active_sub_tab == 'assignments' ? 'nav-tab-active' : ''; ?>">Assignments</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=sessionals');?>" class="nav-tab <?php echo $active_sub_tab == 'sessionals' ? 'nav-tab-active' : ''; ?>">Sessionals</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=mid_term');?>" class="nav-tab <?php echo $active_sub_tab == 'mid_term' ? 'nav-tab-active' : ''; ?>">Mid Term</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=final_term');?>" class="nav-tab <?php echo $active_sub_tab == 'final_term' ? 'nav-tab-active' : ''; ?>">Final Term</a>
            <a href="<?php echo esc_url('?post='. esc_attr($uni_lms_course_files->ID). '&action=edit&sub_tab=final_result');?>" class="nav-tab <?php echo $active_sub_tab == 'final_result' ? 'nav-tab-active' : ''; ?>">Final Result</a>
        </h2>
        <?php
        if($active_sub_tab == 'grad_policy'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_grad_policy.php');
        }elseif($active_sub_tab == 'course_outline'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_course_outline.php');
        }elseif($active_sub_tab == 'course_plan'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_course_plan.php');
        }elseif($active_sub_tab == 'inst_log'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_inst_log.php');
        }elseif($active_sub_tab == 'stud_log'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_student_log.php');
        }elseif($active_sub_tab == 'attendance'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_attendance.php');
        }elseif($active_sub_tab == 'quizzes'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_quizzes.php');
        }elseif($active_sub_tab == 'assignments'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_assignments.php');
        }elseif($active_sub_tab == 'sessionals'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_sessionals.php');
        }elseif($active_sub_tab == 'mid_term'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_mid_term.php');
        }elseif($active_sub_tab == 'final_term'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_term.php');
        }elseif($active_sub_tab == 'final_result'){
            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_result.php');
        }

    endif;

}

function register_meta_boxes_for_uni_lms_course_files_contents_std() {
    add_meta_box( 'uni_lms_course_files_contents_meta_box',
        __('Course File Contents', 'unilms'),
        'display_uni_lms_course_files_contents_meta_box_std',
        'uni_lms_course_files', 'normal', 'low'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_course_files_contents_std' );

function add_uni_lms_course_files_contents_fields_std( $uni_lms_course_files_id, $uni_lms_course_files ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_course_files_id );
    $is_revision = wp_is_post_revision( $uni_lms_course_files_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_course_files_contents_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_class_course_files_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_course_files->post_type == 'uni_lms_course_files' ) {
        // Store data in post meta table if present in post data
        if(isset( $_POST[ 'student_ids' ]) && $_POST['student_ids'] != ''){
            
        }

    }
}

add_action( 'save_post', 'add_uni_lms_course_files_contents_fields_std', 10, 2 );

function uni_lms_course_files_columns_std( $columns ) {
    $columns['uni_lms_course_files_course'] = __('Course', 'unilms');
    $columns['uni_lms_course_files_class'] = __('Class','unilms');
    unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_course_files_columns', 'uni_lms_course_files_columns_std' );

function uni_lms_course_files_populate_columns_std( $column ) {
    if ( 'uni_lms_course_files_course' == $column ) {
        $course_file_course = esc_html( get_post_meta( get_the_ID(), 'course_file_course', true ) );
        $course_file_course = esc_html( get_the_title($course_file_course) );
        echo esc_html($course_file_course);
    }
    elseif ( 'uni_lms_course_files_class' == $column ) {
        $course_file_class = get_post_meta( get_the_ID(), 'course_file_class', true );
        $course_file_class = esc_html( get_the_title($course_file_class) );
        echo esc_html($course_file_class);
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_course_files_populate_columns_std' );


function uni_lms_course_files_sort_columns_std( $columns ) {
    $columns['uni_lms_course_files_course'] = 'uni_lms_course_files_course';
    $columns['uni_lms_course_files_class'] = 'uni_lms_course_files_class';
 
    return $columns;
}

add_filter( 'manage_edit-uni_lms_course_files_sortable_columns', 'uni_lms_course_files_sort_columns_std' );

function uni_lms_course_files_column_orderby_std ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'uni_lms_course_files_course' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'course_file_course', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_course_files_class' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'course_file_class', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}
add_filter( 'request', 'uni_lms_course_files_column_orderby_std' );

/*Meta Values in Filter List*/

add_action('restrict_manage_posts','uni_lms_course_files_class_filter_std',10);

function uni_lms_course_files_class_filter_std($post_type){
    if('uni_lms_course_files' !== $post_type){
      return; //filter your post
    }

    $selected = 0;
    $request_attr = 'course_files_class';
    if ( isset($_REQUEST[$request_attr]) ) {
      $selected = $_REQUEST[$request_attr];
    }else{
        $selected = 0;
    }
    //get unique values of the meta field to filer by.
    $meta_key = 'course_file_class';
    global $wpdb;
    $results = $wpdb->get_col( 
        $wpdb->prepare( "
            SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
            LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
            WHERE pm.meta_key = '%s'
            AND p.post_status IN ('publish', 'draft')
            ORDER BY pm.meta_value", 
            $meta_key
        ) 
    );
    //echo $selected;
   //build a custom dropdown list of values to filter by
    ?>
        <select name="course_files_class">
            <option value="0" <?php if($selected == ''){echo 'selected';}?> >
                <?php _e( 'Show all Course Files', 'unilms' );?>
            </option>
            <?php 
            foreach($results as $course_file_class){
              $class_title = esc_html( get_the_title($course_file_class) );
            ?>
            <option value="<?php echo $course_file_class;?>" <?php if($selected == $course_file_class){echo 'selected';}?> >
                <?php echo $class_title;?> 
            </option>

            <?php } ?>
        </select>
    <?php
}

add_filter( 'parse_query', 'uni_lms_course_files_class_filter_request_query_std' , 10);
function uni_lms_course_files_class_filter_request_query_std($query){
    //modify the query only if it admin and main query.
    if( !(is_admin() AND $query->is_main_query()) ){ 
      return $query;
    }
    //we want to modify the query for the targeted custom post and filter option
    if( !('uni_lms_course_files' == $query->query['post_type'] AND isset($_REQUEST['course_files_class']) ) ){
      return $query;
    }
    //for the default value of our filter no modification is required
    if(0 == $_REQUEST['course_files_class']){
      return $query;
    }
   //modify the query_vars.
    $query->query_vars = array(
        'post_type' => 'uni_lms_course_files',
        'meta_query' => array(
            array(
                'key' => 'course_file_class',
                'value' => $_REQUEST['course_files_class'],
                'compare' => '=',
                'type' => 'CHAR'       
            )
        )
    );
    return $query;
}

function include_template_function_uni_lms_course_files_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_course_files' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_course_files_get_template_hierarchy_std( 'single-uni_lms_course_files' );
    }elseif (is_archive()) {
        return uni_lms_course_files_get_template_hierarchy_std( 'archive-uni_lms_course_files' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_course_files_get_template_hierarchy_std( $template ) {
 
    // Get the template slug
    $template_slug = rtrim( $template, '.php' );
    $template = $template_slug . '.php';
 
    // Check if a custom template exists in the theme folder, if not, load the plugin template file
    //To override default single course template of plugin, create new folder in your theme directory
    // and create new file named as single-uni_lms_courses.php and define your new layout there
    if ( $theme_file = locate_template( array( 'uni_lms_templates/' . $template ) ) ) {
        $file = $theme_file;
    }
    else {
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/course_files/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_course_files_std', 1 );


?>