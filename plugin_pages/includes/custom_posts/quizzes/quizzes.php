<?php
/*create custom post type uni_lms_quizzes*/

function create_post_uni_lms_quizzes_std() {
    register_post_type( 'uni_lms_quizzes',
        array(
            'labels' => array(
                'name' => __('Activities', 'unilms'),
                'singular_name' => __('Activity', 'unilms'),
                'add_new' => __('Add New', 'unilms'),
                'add_new_item' => __('Add New Activity', 'unilms'),
                'edit' => __('Edit', 'unilms'),
                'edit_item' => __('Edit Activity', 'unilms'),
                'new_item' => __('New Activity', 'unilms'),
                'view' => __('View', 'unilms'),
                'view_item' => __('View Activity', 'unilms'),
                'search_items' => __('Search Activities', 'unilms'),
                'not_found' => __('No Activity found', 'unilms'),
                'not_found_in_trash' => __('No Activities found in Trash', 'unilms'),
                'parent' => __('Parent Activity', 'unilms')
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false,
        )
    );
}

add_action( 'init', 'create_post_uni_lms_quizzes_std' );

function display_uni_lms_quizzes_meta_box_std( $uni_lms_quizzes ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_quizzes_meta_box');
    }
    $quiz_course = esc_html( get_post_meta( $uni_lms_quizzes->ID, 'quiz_course', true ));
    $quiz_type = esc_html( get_post_meta( $uni_lms_quizzes->ID, 'quiz_type', true ));
    $quiz_class = esc_html( get_post_meta( $uni_lms_quizzes->ID, 'quiz_class', true ));
    $quiz_max_marks = esc_html( get_post_meta( $uni_lms_quizzes->ID, 'quiz_max_marks', true ));
    ?>
    <table>
        <tr>
            <td><?php _e('Max Marks', 'unilms'); ?></td>
            <td>
                <input type="text" name="uni_lms_quizzes_max_marks" value="<?php echo esc_attr($quiz_max_marks);?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label for="uni_lms_quizzes_for_sessionals">
                    <?php 
                        $quiz_for_sessionals = get_post_meta( $uni_lms_quizzes->ID, 'quiz_for_sessionals', true );
                        if($quiz_for_sessionals == "yes"){
                            $field_is_checked = 'checked="checked"';
                        }else{
                            $field_is_checked = '';
                        }
                    ?>
                    <input type="checkbox" name="uni_lms_quizzes_for_sessionals" id="uni_lms_quizzes_for_sessionals" value="<?php echo $quiz_for_sessionals; ?>" <?php echo $field_is_checked; ?> />
                    <span><?php _e('Do you want to count this activity in sessional marks?', 'unilms'); ?></span>
                </label><br>
            </td>
        </tr>
        <tr>
            <td><?php _e('Activity Type', 'unilms'); ?></td>
            <td>
                <select name="uni_lms_quizzes_type">
                    <option value="class_quiz" <?php if($quiz_type == 'class_quiz'){echo 'selected';}?> ><?php _e('Class Quiz', 'unilms');?></option>
                    <option value="class_assignment" <?php if($quiz_type == 'class_assignment'){echo 'selected';}?> ><?php _e('Class Assignment', 'unilms');?></option>
                    <option value="mid_term" <?php if($quiz_type == 'mid_term'){echo 'selected';}?> ><?php _e('Mid Term', 'unilms');?></option>
                    <option value="final_term" <?php if($quiz_type == 'final_term'){echo 'selected';}?> ><?php _e('Final Term', 'unilms');?></option>
                    <option value="project" <?php if($quiz_type == 'project'){echo 'selected';}?> ><?php _e('Project', 'unilms');?></option>
                    <option value="presentation" <?php if($quiz_type == 'presentation'){echo 'selected';}?> ><?php _e('Presentation', 'unilms');?></option>
                    <option value="class_part" <?php if($quiz_type == 'class_part'){echo 'selected';}?> ><?php _e('Class Participation', 'unilms');?></option>
                </select>
            </td>
        </tr>
        <?php
            if($quiz_type == 'class_assignment'){
                $assignment_submission_date = esc_html( get_post_meta( $uni_lms_quizzes->ID, 'quiz_submission_date', true ));
                // Enqueue Datepicker + jQuery UI CSS
                wp_enqueue_script( 'jquery-ui-datepicker' );
                wp_enqueue_style( 'jquery-ui-style', UNI_LMS_PLUGIN_URL. '/css/unilms-jquery-ui.css', true);
        ?>
        <script>
        jQuery(document).ready(function(){
            jQuery('#uni_lms_quizzes_submission_date').datepicker({
                dateFormat : 'dd/mm/yy'
            });
        });
        </script>
        <tr>
            <td><?php _e('Submission Date', 'unilms'); ?></td>
            <td>
                <input type="text" name="uni_lms_quizzes_submission_date" id="uni_lms_quizzes_submission_date" value="<?php echo esc_attr($assignment_submission_date); ?>" />
            </td>
        </tr>
        <?php
            }
        ?>
        <tr>
            <td><?php _e('Assign Course', 'unilms'); ?></td>
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
                    'author' => $user_id
                    );
                }
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_quizzes_course">
                    <option value="" <?php if($quiz_course == 0){echo 'selected';}?> ><?php _e('Select Course', 'unilms'); ?></option>
                    <?php

                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($quiz_course == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
                <?php 
                }else{
                    _e('No Courses Found. Please create new courses by going into courses tab to see a dropdown list 
                    of all courses here','unilms');
                }
                ?>
            </td>
        </tr>
        <tr>
            <td><?php _e('Assign Class', 'unilms'); ?></td>
            <td>
                <select name="uni_lms_quizzes_class">
                    <option value="" <?php if($quiz_class == 0){echo 'selected';}?> ><?php _e('Select Class', 'unilms'); ?></option>
                    <?php
                        $args = array( 'post_type' => 'uni_lms_classes', 'posts_per_page' => -1);
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($quiz_class == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_quizzes_std() {
    add_meta_box( 'uni_lms_quizzes_meta_box',
        __('Details', 'unilms'),
        'display_uni_lms_quizzes_meta_box_std',
        'uni_lms_quizzes', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_quizzes_std' );

function add_uni_lms_quizzes_fields_std( $uni_lms_quizzes_id, $uni_lms_quizzes ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_quizzes_id );
    $is_revision = wp_is_post_revision( $uni_lms_quizzes_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_quizzes_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_quizzes_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }

    // Check post type
    if ( $uni_lms_quizzes->post_type == 'uni_lms_quizzes' ) {
        //die(var_dump($_POST));
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_quizzes_course'] ) && $_POST['uni_lms_quizzes_course'] != '' ) {
            update_post_meta( $uni_lms_quizzes_id, 'quiz_course', intval($_POST['uni_lms_quizzes_course']) );
        }
        if ( isset( $_POST['uni_lms_quizzes_for_sessionals'] ) ) {
            update_post_meta( $uni_lms_quizzes_id, 'quiz_for_sessionals', 'yes' );
        }else{
            update_post_meta( $uni_lms_quizzes_id, 'quiz_for_sessionals', 'no' );
        }
        if ( isset( $_POST['uni_lms_quizzes_type'] ) && $_POST['uni_lms_quizzes_type'] != '' ) {
            update_post_meta( $uni_lms_quizzes_id, 'quiz_type', sanitize_text_field($_POST['uni_lms_quizzes_type']) );
        }
        if ( isset( $_POST['uni_lms_quizzes_submission_date'] ) && $_POST['uni_lms_quizzes_submission_date'] != '' ) {
            update_post_meta( $uni_lms_quizzes_id, 'quiz_submission_date', sanitize_text_field($_POST['uni_lms_quizzes_submission_date']) );
        }
        if ( isset( $_POST['uni_lms_quizzes_class'] ) && $_POST['uni_lms_quizzes_class'] != '' ) {
            update_post_meta( $uni_lms_quizzes_id, 'quiz_class', intval($_POST['uni_lms_quizzes_class']) );
        }
        if ( isset( $_POST['uni_lms_quizzes_max_marks'] ) && $_POST['uni_lms_quizzes_max_marks'] != '' ) {
            update_post_meta( $uni_lms_quizzes_id, 'quiz_max_marks', sanitize_text_field($_POST['uni_lms_quizzes_max_marks']) );
        }
    }
}

add_action( 'save_post', 'add_uni_lms_quizzes_fields_std', 10, 2 );

function display_uni_lms_quiz_marks_meta_box_std( $uni_lms_quizzes ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_quiz_marks_meta_box');
    }
    $quiz_class = esc_html(get_post_meta( $uni_lms_quizzes->ID, 'quiz_class', true ));
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
                                'value' => $quiz_class,
                                'compare' => '=',
                                'type' => 'CHAR'       
                            )
                        )
                    );
                    $loop = new WP_Query( $args );
                    $student_ids = '';
                    while ( $loop->have_posts() ) : $loop->the_post();
                        $student_ids .= get_the_ID().'-';
                        $quiz_marks = get_post_meta( $uni_lms_quizzes->ID, 'uni_lms_quiz_marks-'.get_the_ID(), true );
                        //echo $student_attendance;
                    ?>
                        <label for="uni_lms_quiz_marks-<?php echo get_the_ID();?>">
                            <?php echo the_title() . ' - ' . get_post_meta( get_the_ID(), 'student_reg_no', true );?>
                            <input type="text" name="uni_lms_quiz_marks-<?php echo get_the_ID();?>" id="uni_lms_quiz_marks-<?php echo get_the_ID();?>" value="<?php echo esc_attr($quiz_marks);?>" />
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

function register_meta_boxes_for_uni_lms_quiz_marks_std() {
    add_meta_box( 'uni_lms_quiz_marks_meta_box',
        __('Activity Marks', 'unilms'),
        'display_uni_lms_quiz_marks_meta_box_std',
        'uni_lms_quizzes', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_quiz_marks_std' );

function add_uni_lms_quiz_marks_fields_std( $uni_lms_quizzes_id, $uni_lms_quizzes ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_quizzes_id );
    $is_revision = wp_is_post_revision( $uni_lms_quizzes_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_quiz_marks_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_quiz_marks_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_quizzes->post_type == 'uni_lms_quizzes' ) {
        // Store data in post meta table if present in post data
        if(isset( $_POST[ 'student_ids' ]) && $_POST['student_ids'] != ''){
            $student_ids = $_POST['student_ids'];
            $student_ids_array = explode('-', $student_ids);
            foreach ($student_ids_array as $key => $value) {
                if($value != ''){
                    if( isset( $_POST[ 'uni_lms_quiz_marks-'. $value ] ) ) {
                        update_post_meta( $uni_lms_quizzes_id, 'uni_lms_quiz_marks-'.$value, sanitize_text_field($_POST[ 'uni_lms_quiz_marks-'. $value ]) );
                    }
                }
            }
        }

    }
}

add_action( 'save_post', 'add_uni_lms_quiz_marks_fields_std', 10, 2 );


function include_template_function_uni_lms_quizzes_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_quizzes' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_quizzes_get_template_hierarchy_std( 'single-uni_lms_quizzes' );
    }elseif (is_archive()) {
        return uni_lms_quizzes_get_template_hierarchy_std( 'archive-uni_lms_quizzes' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_quizzes_get_template_hierarchy_std( $template ) {
 
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
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/quizzes/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_quizzes_std', 1 );

function uni_lms_quizzes_columns_std( $columns ) {
    $columns['uni_lms_quizzes_course'] = __('Course', 'unilms');
    unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_quizzes_columns', 'uni_lms_quizzes_columns_std' );

function uni_lms_quizzes_populate_columns_std( $column ) {
    if ( 'uni_lms_quizzes_course' == $column ) {
        $quiz_course = esc_html( get_post_meta( get_the_ID(), 'quiz_course', true ) );
        $quiz_course = esc_html( get_the_title($quiz_course) );
        echo $quiz_course;
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_quizzes_populate_columns_std' );

/*Meta Values in Filter List*/

add_action('restrict_manage_posts','uni_lms_quizzes_type_filter_std',10);

function uni_lms_quizzes_type_filter_std($post_type){
    if('uni_lms_quizzes' !== $post_type){
      return; //filter your post
    }

    $selected = 0;
    $request_attr = 'quizzes_type';
    if ( isset($_REQUEST[$request_attr]) ) {
      $selected = $_REQUEST[$request_attr];
    }else{
        $selected = '';
    }
    //get unique values of the meta field to filer by.
    $meta_key = 'quiz_type';
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
        <select name="quizzes_type">
            <option value="" <?php if($selected == ''){echo 'selected';}?> >
                <?php _e( 'Show all Activities', 'unilms' );?>
            </option>
            <?php 
            foreach($results as $quiz_type){
            ?>
            <option value="<?php echo $quiz_type;?>" <?php if($selected == $quiz_type){echo 'selected';}?> >
                <?php echo $quiz_type;?> 
            </option>

            <?php } ?>
        </select>
    <?php
}

add_filter( 'parse_query', 'uni_lms_quizzes_type_filter_request_query_std' , 10);
function uni_lms_quizzes_type_filter_request_query_std($query){
    //modify the query only if it admin and main query.
    if( !(is_admin() AND $query->is_main_query()) ){ 
      return $query;
    }
    //we want to modify the query for the targeted custom post and filter option
    if( !('uni_lms_quizzes' == $query->query['post_type'] AND isset($_REQUEST['quizzes_type']) ) ){
      return $query;
    }
    //for the default value of our filter no modification is required
    if('' == $_REQUEST['quizzes_type']){
      return $query;
    }
   //modify the query_vars.
    $query->query_vars = array(
        'post_type' => 'uni_lms_quizzes',
        'meta_query' => array(
            array(
                'key' => 'quiz_type',
                'value' => $_REQUEST['quizzes_type'],
                'compare' => '=',
                'type' => 'CHAR'       
            )
        )
    );
    return $query;
}

?>