<?php
/*create custom post type uni_lms_lectures*/

function create_post_uni_lms_lectures_std() {
    register_post_type( 'uni_lms_lectures',
        array(
            'labels' => array(
                'name' => __('Lectures', 'unilms'),
                'singular_name' => __('Lecture', 'unilms'),
                'add_new' => __('Add New', 'unilms'),
                'add_new_item' => __('Add New Lecture', 'unilms'),
                'edit' => __('Edit', 'unilms'),
                'edit_item' => __('Edit Lecture', 'unilms'),
                'new_item' => __('New Lecture', 'unilms'),
                'view' => __('View', 'unilms'),
                'view_item' => __('View Lecture', 'unilms'),
                'search_items' => __('Search Lectures', 'unilms'),
                'not_found' => __('No Lecture found', 'unilms'),
                'not_found_in_trash' => __('No Lectures found in Trash', 'unilms'),
                'parent' => __('Parent Lecture', 'unilms')
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false,
        )
    );
}

add_action( 'init', 'create_post_uni_lms_lectures_std' );

function display_uni_lms_lectures_meta_box_std( $uni_lms_lectures ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_lectures_meta_box');
    }
    $lecture_course = get_post_meta( $uni_lms_lectures->ID, 'lecture_course', true );
    $lecture_topics = get_post_meta( $uni_lms_lectures->ID, 'lecture_topics', true );
    ?>
    <table>
        <tr>
            <td style="width: 100%"><?php _e('Lecture topics', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_lecture_topics" value="<?php echo esc_attr($lecture_topics); ?>" /></td>
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
                    'author' => $user_id
                    );
                }
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_lectures_course">
                    <option value="0" <?php if($lecture_course == 0){echo 'selected';}?> ><?php _e('Select Course', 'unilms');?></option>
                    <?php

                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($lecture_course == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
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
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_lectures_std() {
    add_meta_box( 'uni_lms_lectures_meta_box',
        __('Assign To Course','unilms'),
        'display_uni_lms_lectures_meta_box_std',
        'uni_lms_lectures', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_lectures_std' );

function add_uni_lms_lectures_fields_std( $uni_lms_lectures_id, $uni_lms_lectures ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_lectures_id );
    $is_revision = wp_is_post_revision( $uni_lms_lectures_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_lectures_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_lectures_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_lectures->post_type == 'uni_lms_lectures' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_lectures_course'] ) && $_POST['uni_lms_lectures_course'] != '' ) {
            update_post_meta( $uni_lms_lectures_id, 'lecture_course', intval($_POST['uni_lms_lectures_course']) );
        }
        if ( isset( $_POST['uni_lms_lecture_topics'] ) && $_POST['uni_lms_lecture_topics'] != '' ) {
            update_post_meta( $uni_lms_lectures_id, 'lecture_topics', sanitize_text_field($_POST['uni_lms_lecture_topics']) );
        }
    }
}

add_action( 'save_post', 'add_uni_lms_lectures_fields_std', 10, 2 );


function include_template_function_uni_lms_lectures_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_lectures' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_lectures_get_template_hierarchy_std( 'single-uni_lms_lectures' );
    }elseif (is_archive()) {
        return uni_lms_lectures_get_template_hierarchy_std( 'archive-uni_lms_lectures' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_lectures_get_template_hierarchy_std( $template ) {
 
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
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/lectures/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_lectures_std', 1 );

function uni_lms_lectures_columns_std( $columns ) {
    $columns['uni_lms_lectures_course'] = __('Course', 'unilms');
    //unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_lectures_columns', 'uni_lms_lectures_columns_std' );

function uni_lms_lectures_populate_columns_std( $column ) {
    if ( 'uni_lms_lectures_course' == $column ) {
        $lecture_course = esc_html( get_post_meta( get_the_ID(), 'lecture_course', true ) );
        $lecture_course = esc_html( get_the_title($lecture_course) );
        echo $lecture_course;
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_lectures_populate_columns_std' );


/*Meta Values in Filter List*/

add_action('restrict_manage_posts','uni_lms_lectures_course_filter_std',10);

function uni_lms_lectures_course_filter_std($post_type){
    if('uni_lms_lectures' !== $post_type){
      return; //filter your post
    }

    $selected = 0;
    $request_attr = 'lectures_course';
    if ( isset($_REQUEST[$request_attr]) ) {
      $selected = $_REQUEST[$request_attr];
    }else{
        $selected = 0;
    }
    //get unique values of the meta field to filer by.
    $meta_key = 'lecture_course';
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
        <select name="lectures_course">
            <option value="0" <?php if($selected == 0){echo 'selected';}?> >
                <?php _e( 'Show all Lectures', 'unilms' );?>
            </option>
            <?php 
            foreach($results as $lecture_course){
              $course_title = esc_html( get_the_title($lecture_course) );
            ?>
            <option value="<?php echo $lecture_course;?>" <?php if($selected == $lecture_course){echo 'selected';}?> >
                <?php echo $course_title;?> 
            </option>

            <?php } ?>
        </select>
    <?php
}

add_filter( 'parse_query', 'uni_lms_lectures_course_filter_request_query_std' , 10);
function uni_lms_lectures_course_filter_request_query_std($query){
    //modify the query only if it admin and main query.
    if( !(is_admin() AND $query->is_main_query()) ){ 
      return $query;
    }
    //we want to modify the query for the targeted custom post and filter option
    if( !('uni_lms_lectures' == $query->query['post_type'] AND isset($_REQUEST['lectures_course']) ) ){
      return $query;
    }
    //for the default value of our filter no modification is required
    if(0 == $_REQUEST['lectures_course']){
      return $query;
    }
   //modify the query_vars.
    $query->query_vars = array(
        'post_type' => 'uni_lms_lectures',
        'meta_query' => array(
            array(
                'key' => 'lecture_course',
                'value' => $_REQUEST['lectures_course'],
                'compare' => '=',
                'type' => 'CHAR'       
            )
        )
    );
    return $query;
}

?>