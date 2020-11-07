<?php
/*create custom post type uni_lms_attendances*/

function create_post_uni_lms_attendances_std() {
    register_post_type( 'uni_lms_attendances',
        array(
            'labels' => array(
                'name' => __('Attendances', 'unilms'),
                'singular_name' => __('Attendance', 'unilms'),
                'add_new' => __('Add New', 'unilms'),
                'add_new_item' => __('Add New Attendance', 'unilms'),
                'edit' => __('Edit', 'unilms'),
                'edit_item' => __('Edit Attendance', 'unilms'),
                'new_item' => __('New Attendance', 'unilms'),
                'view' => __('View', 'unilms'),
                'view_item' => __('View Attendance', 'unilms'),
                'search_items' => __('Search Attendances', 'unilms'),
                'not_found' => __('No Attendance found', 'unilms'),
                'not_found_in_trash' => __('No Attendances found in Trash', 'unilms'),
                'parent' => __('Parent Attendance', 'unilms')
            ),
 
            'public' => true,
            'supports' => array( 'title' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false,
        )
    );
}

add_action( 'init', 'create_post_uni_lms_attendances_std' );

function display_uni_lms_attendances_meta_box_std( $uni_lms_attendances ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_attendances_meta_box');
    }

    // Enqueue Datepicker + jQuery UI CSS
    wp_enqueue_script( 'jquery-ui-datepicker' );
    wp_enqueue_style( 'jquery-ui-style', UNI_LMS_PLUGIN_URL. '/css/unilms-jquery-ui.css', true);

    ?>
    <style>
    .ui-datepicker {
        margin-left: -50px !important;
        background-color: #f1f1f1 !important;
        border: none !important;
    }
    .ui-widget-content {
        background-color: #f1f1f1 !important;
    }
    </style>
    <script>
    jQuery(document).ready(function(){
        jQuery('#uni_lms_attendances_date').datepicker({
            dateFormat : 'dd/mm/yy'
        });
    });
    </script>
    <?php
    $attendance_course = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_course', true ));
    $attendance_class = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_class', true ));
    $attendance_lecture = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_lecture', true ));
    $attendance_quiz = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_quiz', true ));
    $attendance_assignment = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_assignment', true ));
    $attendance_date = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_date', true ));
    ?>
    <table>
        <tr>
            <td><?php _e('Attendance Date', 'unilms'); ?></td>
            <td>
                <input type="text" name="uni_lms_attendances_date" id="uni_lms_attendances_date" value="<?php echo esc_attr($attendance_date); ?>" />
            </td>
        </tr>
        <tr>
            <td><?php _e('Select Course', 'unilms'); ?></td>
            <td>
                <?php 
                $user_id = get_current_user_id();
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
                <select name="uni_lms_attendances_course">
                    <option value="0" <?php if($attendance_course == 0){echo 'selected';}?> ><?php _e('Select Course', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($attendance_course == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Courses Found. Please create new courses by going into courses tab to see a dropdown list 
                    of all courses here', 'unilms');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Select Class', 'unilms'); ?></td>
            <td>
                <?php 
                $args = array( 'post_type' => 'uni_lms_classes', 'posts_per_page' => -1);
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_attendances_class">
                    <option value="0" <?php if($attendance_class == 0){echo 'selected';}?> ><?php _e('Select Class', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($attendance_class == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Classes created by admin yet!', 'unilms');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Select Lecture', 'unilms'); ?></td>
            <td>
                <?php
                global $user_ID;
                if ( current_user_can( 'administrator' ) ) {
                    $args = array( 
                    'post_type' => 'uni_lms_lectures',
                    'posts_per_page' => -1
                    );
                }else{
                    $args = array( 
                    'post_type' => 'uni_lms_lectures',
                    'posts_per_page' => -1,
                    'author' => $user_id
                    );
                } 
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_attendances_lecture">
                    <option value="0" <?php if($attendance_lecture == 0){echo 'selected';}?> ><?php _e('Select Lecture', 'unilms');?></option>
                    <?php
                        $args = array( 
                            'post_type' => 'uni_lms_lectures',
                            'posts_per_page' => -1,
                            'author' => $user_id
                            );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($attendance_lecture == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Lectures Found. Please create new lectures by going into lectures tab to see a dropdown list 
                    of all lectures here', 'unilms');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Select Quiz', 'unilms'); ?></td>
            <td>
                <?php 
                global $user_ID;
                if ( current_user_can( 'administrator' ) ) {
                    $args = array( 
                        'post_type' => array('uni_lms_quizzes'),
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key' => 'quiz_type',
                                'value' => 'class_quiz',
                                'compare' => '=',
                                'type' => 'CHAR'       
                            )
                        )
                    );
                }else{
                    $args = array( 
                        'post_type' => array('uni_lms_quizzes'),
                        'posts_per_page' => -1,
                        'author' => $user_id,
                        'meta_query' => array(
                            array(
                                'key' => 'quiz_type',
                                'value' => 'class_quiz',
                                'compare' => '=',
                                'type' => 'CHAR'       
                            )
                        )
                    );
                }
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_attendances_quiz">
                    <option value="0" <?php if($attendance_quiz == 0){echo 'selected';}?> ><?php _e('Select Quiz', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($attendance_quiz == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Quizzes Found. Please create new quizzes by going into activities tab to see a dropdown list 
                    of all quizzes here', 'unilms');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Select Assignment', 'unilms'); ?></td>
            <td>
                <?php 
                global $user_ID;
                if ( current_user_can( 'administrator' ) ) {
                    $args = array( 
                        'post_type' => array('uni_lms_quizzes'),
                        'posts_per_page' => -1,
                        'meta_query' => array(
                            array(
                                'key' => 'quiz_type',
                                'value' => 'class_assignment',
                                'compare' => '=',
                                'type' => 'CHAR'       
                            )
                        )
                    );
                }else{
                    $args = array( 
                        'post_type' => array('uni_lms_quizzes'),
                        'posts_per_page' => -1,
                        'author' => $user_id,
                        'meta_query' => array(
                            array(
                                'key' => 'quiz_type',
                                'value' => 'class_assignment',
                                'compare' => '=',
                                'type' => 'CHAR'       
                            )
                        )
                    );
                }
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_attendances_assignment">
                    <option value="0" <?php if($attendance_assignment == 0){echo 'selected';}?> ><?php _e('Select Assignment', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($attendance_assignment == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Assignments Found. Please create new assignments by going into activities tab to see a dropdown list 
                    of all assignments here', 'unilms');
                }
                ?>
            </td>
        </tr>
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_attendances_std() {
    add_meta_box( 'uni_lms_attendances_meta_box',
        __('Details','unilms'),
        'display_uni_lms_attendances_meta_box_std',
        'uni_lms_attendances', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_attendances_std' );

function add_uni_lms_attendances_fields_std( $uni_lms_attendances_id, $uni_lms_attendances ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_attendances_id );
    $is_revision = wp_is_post_revision( $uni_lms_attendances_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_attendances_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_attendances_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_attendances->post_type == 'uni_lms_attendances' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_attendances_course'] ) && $_POST['uni_lms_attendances_course'] != '' ) {
            update_post_meta( $uni_lms_attendances_id, 'attendance_course', intval($_POST['uni_lms_attendances_course']) );
        }
        if ( isset( $_POST['uni_lms_attendances_class'] ) && $_POST['uni_lms_attendances_class'] != '' ) {
            update_post_meta( $uni_lms_attendances_id, 'attendance_class', intval($_POST['uni_lms_attendances_class']) );
        }
        if ( isset( $_POST['uni_lms_attendances_lecture'] ) && $_POST['uni_lms_attendances_lecture'] != '' ) {
            update_post_meta( $uni_lms_attendances_id, 'attendance_lecture', intval($_POST['uni_lms_attendances_lecture']) );
        }
        if ( isset( $_POST['uni_lms_attendances_quiz'] ) && $_POST['uni_lms_attendances_quiz'] != '' ) {
            update_post_meta( $uni_lms_attendances_id, 'attendance_quiz', intval($_POST['uni_lms_attendances_quiz']) );
        }
        if ( isset( $_POST['uni_lms_attendances_assignment'] ) && $_POST['uni_lms_attendances_assignment'] != '' ) {
            update_post_meta( $uni_lms_attendances_id, 'attendance_assignment', intval($_POST['uni_lms_attendances_assignment']) );
        }
        if ( isset( $_POST['uni_lms_attendances_date'] ) && $_POST['uni_lms_attendances_date'] != '' ) {
            update_post_meta( $uni_lms_attendances_id, 'attendance_date', sanitize_text_field($_POST['uni_lms_attendances_date']) );
        }
    }
}

add_action( 'save_post', 'add_uni_lms_attendances_fields_std', 10, 2 );


function display_uni_lms_class_attendances_meta_box_std( $uni_lms_attendances ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_class_attendances_meta_box');
    }
    $attendance_class = esc_html (get_post_meta( $uni_lms_attendances->ID, 'attendance_class', true ));
    ?>
    <table>
        <tr>
            <td>
                <?php
                    $args = array( 
                        'post_type' => 'uni_lms_students',
                        'posts_per_page' => -1,
                        'meta_key' => 'student_reg_no',
                        'orderby' => 'meta_value',
                        'order' => 'ASC',
                        'meta_query' => array(
                            array(
                                'key' => 'student_class',
                                'value' => $attendance_class,
                                'compare' => '=',
                                'type' => 'CHAR'       
                            )
                        )
                    );
                    $loop = new WP_Query( $args );
                    $student_ids = '';
                    while ( $loop->have_posts() ) : $loop->the_post();
                        $student_ids .= get_the_ID().'-';
                        $student_attendance = get_post_meta( $uni_lms_attendances->ID, 'uni_lms_attendance_student-'.get_the_ID(), true );
                        //echo $student_attendance;
                    ?>
                        <label for="uni_lms_attendance_student-<?php echo esc_attr(get_the_ID());?>">
                            <?php echo the_title() . ' - ' . esc_html(get_post_meta( get_the_ID(), 'student_reg_no', true ));?>
                            <input type="checkbox" name="uni_lms_attendance_student-<?php echo esc_attr(get_the_ID());?>" id="uni_lms_attendance_student-<?php echo get_the_ID();?>" value="no" <?php if ( isset ( $student_attendance )) checked( $student_attendance, 'yes' ); ?> />
                        </label><br>
                    <?php
                    endwhile; 
                ?>
                    <input type="hidden" name="student_ids" value="<?php echo esc_attr($student_ids); ?>">
            </td>
        </tr>
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_class_attendances_std() {
    add_meta_box( 'uni_lms_class_attendances_meta_box',
        __('Mark Attendance', 'unilms'),
        'display_uni_lms_class_attendances_meta_box_std',
        'uni_lms_attendances', 'normal', 'low'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_class_attendances_std' );

function add_uni_lms_class_attendances_fields_std( $uni_lms_attendances_id, $uni_lms_attendances ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_attendances_id );
    $is_revision = wp_is_post_revision( $uni_lms_attendances_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_class_attendances_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_class_attendances_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_attendances->post_type == 'uni_lms_attendances' ) {
        // Store data in post meta table if present in post data
        if(isset( $_POST[ 'student_ids' ]) && $_POST['student_ids'] != ''){
            $student_ids = $_POST['student_ids'];
            $student_ids_array = explode('-', $student_ids);
            foreach ($student_ids_array as $key => $value) {
                if($value != ''){
                    if( isset( $_POST[ 'uni_lms_attendance_student-'. $value ] ) ) {
                        update_post_meta( $uni_lms_attendances_id, 'uni_lms_attendance_student-'.$value, 'yes' );
                    }else{
                        update_post_meta( $uni_lms_attendances_id, 'uni_lms_attendance_student-'.$value, '' );
                    }
                }
            }
        }

    }
}

add_action( 'save_post', 'add_uni_lms_class_attendances_fields_std', 10, 2 );

function uni_lms_attendances_columns_std( $columns ) {
    $columns['uni_lms_attendances_course'] = __('Course', 'unilms');
    $columns['uni_lms_attendances_class'] = __('Class', 'unilms');
    unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_attendances_columns', 'uni_lms_attendances_columns_std' );

function uni_lms_attendances_populate_columns_std( $column ) {
    if ( 'uni_lms_attendances_course' == $column ) {
        $attendance_course = esc_html( get_post_meta( get_the_ID(), 'attendance_course', true ) );
        $attendance_course = esc_html( get_the_title($attendance_course) );
        echo esc_html($attendance_course);
    }
    elseif ( 'uni_lms_attendances_class' == $column ) {
        $attendance_class = get_post_meta( get_the_ID(), 'attendance_class', true );
        $attendance_class = esc_html( get_the_title($attendance_class) );
        echo esc_html($attendance_class);
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_attendances_populate_columns_std' );


function uni_lms_attendances_sort_columns_std( $columns ) {
    $columns['uni_lms_attendances_course'] = 'uni_lms_attendances_course';
    $columns['uni_lms_attendances_class'] = 'uni_lms_attendances_class';
 
    return $columns;
}

add_filter( 'manage_edit-uni_lms_attendances_sortable_columns', 'uni_lms_attendances_sort_columns_std' );

function uni_lms_attendances_column_orderby_std ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'uni_lms_attendances_course' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'attendance_course', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_attendances_class' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'attendance_class', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}
add_filter( 'request', 'uni_lms_attendances_column_orderby_std' );

/*Meta Values in Filter List*/

add_action('restrict_manage_posts','uni_lms_attendances_class_filter_std',10);

function uni_lms_attendances_class_filter_std($post_type){
    if('uni_lms_attendances' !== $post_type){
      return; //filter your post
    }

    $selected = 0;
    $request_attr = 'attendances_class';
    if ( isset($_REQUEST[$request_attr]) ) {
      $selected = $_REQUEST[$request_attr];
    }else{
        $selected = 0;
    }
    //get unique values of the meta field to filer by.
    $meta_key = 'attendance_class';
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
        <select name="attendances_class">
            <option value="0" <?php if($selected == ''){echo 'selected';}?> >
                <?php _e( 'Show all Attendances', 'unilms' );?>
            </option>
            <?php 
            foreach($results as $attendance_class){
              $class_title = esc_html( get_the_title($attendance_class) );
            ?>
            <option value="<?php echo $attendance_class;?>" <?php if($selected == $attendance_class){echo 'selected';}?> >
                <?php echo $class_title;?> 
            </option>

            <?php } ?>
        </select>
    <?php
}

add_filter( 'parse_query', 'uni_lms_attendances_class_filter_request_query_std' , 10);
function uni_lms_attendances_class_filter_request_query_std($query){
    //modify the query only if it admin and main query.
    if( !(is_admin() AND $query->is_main_query()) ){ 
      return $query;
    }
    //we want to modify the query for the targeted custom post and filter option
    if( !('uni_lms_attendances' == $query->query['post_type'] AND isset($_REQUEST['attendances_class']) ) ){
      return $query;
    }
    //for the default value of our filter no modification is required
    if(0 == $_REQUEST['attendances_class']){
      return $query;
    }
   //modify the query_vars.
    $query->query_vars = array(
        'post_type' => 'uni_lms_attendances',
        'meta_query' => array(
            array(
                'key' => 'attendance_class',
                'value' => $_REQUEST['attendances_class'],
                'compare' => '=',
                'type' => 'CHAR'       
            )
        )
    );
    return $query;
}

function include_template_function_uni_lms_attendances_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_attendances' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_attendances_get_template_hierarchy_std( 'single-uni_lms_attendances' );
    }elseif (is_archive()) {
        return uni_lms_attendances_get_template_hierarchy_std( 'archive-uni_lms_attendances' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_attendances_get_template_hierarchy_std( $template ) {
 
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
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/attendances/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_attendances_std', 1 );

?>