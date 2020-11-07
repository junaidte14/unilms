<?php
/*create custom post type uni_lms_classes*/

function create_post_uni_lms_classes_std() {
    register_post_type( 'uni_lms_classes',
        array(
            'labels' => array(
                'name' => __('Classes','unilms'),
                'singular_name' => __('Class','unilms'),
                'add_new' => __('Add New','unilms'),
                'add_new_item' => __('Add New Class','unilms'),
                'edit' => __('Edit','unilms'),
                'edit_item' => __('Edit Class','unilms'),
                'new_item' => __('New Class','unilms'),
                'view' => __('View','unilms'),
                'view_item' => __('View Class','unilms'),
                'search_items' => __('Search Classes','unilms'),
                'not_found' => __('No Class found','unilms'),
                'not_found_in_trash' => __('No Classes found in Trash','unilms'),
                'parent' => __('Parent Class','unilms')
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false
        )
    );
}

add_action( 'init', 'create_post_uni_lms_classes_std' );

function display_uni_lms_classes_meta_box_std( $uni_lms_classes ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_classes_meta_box');
    }
    $class_semester = intval( get_post_meta( $uni_lms_classes->ID, 'class_semester', true ) );
    $class_session = intval( get_post_meta( $uni_lms_classes->ID, 'class_session', true ) );
    $class_fall_spring = esc_html (get_post_meta( $uni_lms_classes->ID, 'class_fall_spring', true ));
    ?>
    <table>
        <tr>
            <td style="width: 100%"><?php _e('Class Semester', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_classes_class_semester" value="<?php echo esc_attr($class_semester); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Class Session', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_classes_class_session" value="<?php echo esc_attr($class_session); ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Fall / Spring', 'unilms'); ?></td>
            <td>
                <select name="uni_lms_classes_class_fall_spring">
                    <option value="0" <?php if($class_fall_spring == ''){echo 'selected';}?> ><?php _e('Select Option', 'unilms');?></option>
                    <option value="fall" <?php if($class_fall_spring == 'fall'){echo 'selected';}?> ><?php _e('Fall', 'unilms');?></option>
                    <option value="spring" <?php if($class_fall_spring == 'spring'){echo 'selected';}?> ><?php _e('Spring', 'unilms');?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_classes_std() {
    add_meta_box( 'uni_lms_classes_meta_box',
        __('Class Details', 'unilms'),
        'display_uni_lms_classes_meta_box_std',
        'uni_lms_classes', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_classes_std' );

function add_uni_lms_classes_fields_std( $uni_lms_classes_id, $uni_lms_classes ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_classes_id );
    $is_revision = wp_is_post_revision( $uni_lms_classes_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_classes_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_classes_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_classes->post_type == 'uni_lms_classes' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_classes_class_semester'] ) && $_POST['uni_lms_classes_class_semester'] != '' ) {
            update_post_meta( $uni_lms_classes_id, 'class_semester', intval($_POST['uni_lms_classes_class_semester']) );
        }
        if ( isset( $_POST['uni_lms_classes_class_session'] ) && $_POST['uni_lms_classes_class_session'] != '' ) {
            update_post_meta( $uni_lms_classes_id, 'class_session', intval($_POST['uni_lms_classes_class_session']) );
        }
        if ( isset( $_POST['uni_lms_classes_class_fall_spring'] ) && $_POST['uni_lms_classes_class_fall_spring'] != '' ) {
            update_post_meta( $uni_lms_classes_id, 'class_fall_spring', esc_html($_POST['uni_lms_classes_class_fall_spring']) );
        }
    }
}

add_action( 'save_post', 'add_uni_lms_classes_fields_std', 10, 2 );

function display_uni_lms_class_courses_meta_box_std( $uni_lms_classes ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_class_courses_meta_box');
    }

    ?>
    <table>
        <tr>
            <?php
                $args = array( 
                    'post_type' => 'uni_lms_courses',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC'
                );
                $loop = new WP_Query( $args );
                $courses_ids = '';
                $i = 1;
                echo '<tr>';
                while ( $loop->have_posts() ) : $loop->the_post();
                    $courses_ids .= get_the_ID().'-';
                    $class_course = get_post_meta( $uni_lms_classes->ID, 'uni_lms_class_course-'.get_the_ID(), true );
                ?>
                <td>
                    <label for="uni_lms_class_course-<?php echo esc_attr(get_the_ID());?>">
                        <input type="checkbox" name="uni_lms_class_course-<?php echo esc_attr(get_the_ID());?>" id="uni_lms_class_course-<?php echo esc_attr(get_the_ID());?>" value="no" <?php if ( isset ( $class_course )) checked( $class_course, 'yes' ); ?> />
                        <?php echo the_title();?>
                    </label>
                </td>
                <?php
                    if($i%4 == 0){
                        echo '</tr><tr>';
                    }
                    $i++;
                endwhile; 
                echo '</tr>';
            ?>
            <input type="hidden" name="courses_ids" value="<?php echo esc_attr($courses_ids); ?>">
        
        </tr>
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_class_courses_std() {
    add_meta_box( 'uni_lms_class_courses_meta_box',
        __('Assign Courses', 'unilms'),
        'display_uni_lms_class_courses_meta_box_std',
        'uni_lms_classes', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_class_courses_std' );

function add_uni_lms_class_courses_fields_std( $uni_lms_classes_id, $uni_lms_classes ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_classes_id );
    $is_revision = wp_is_post_revision( $uni_lms_classes_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_class_courses_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_class_courses_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_classes->post_type == 'uni_lms_classes' ) {
        // Store data in post meta table if present in post data
        if(isset( $_POST[ 'courses_ids' ]) && $_POST['courses_ids'] != ''){
            $courses_ids = $_POST['courses_ids'];
            $courses_ids_array = explode('-', $courses_ids);
            foreach ($courses_ids_array as $key => $value) {
                if($value != ''){
                    if( isset( $_POST[ 'uni_lms_class_course-'. $value ] ) ) {
                        update_post_meta( $uni_lms_classes_id, 'uni_lms_class_course-'.$value, 'yes' );
                    }else{
                        update_post_meta( $uni_lms_classes_id, 'uni_lms_class_course-'.$value, '' );
                    }
                }
            }
        }

    }
}

add_action( 'save_post', 'add_uni_lms_class_courses_fields_std', 10, 2 );

function uni_lms_classes_columns_std( $columns ) {
    $columns['uni_lms_classes_class_semester'] = __('Semester', 'unilms');
    $columns['uni_lms_classes_class_session'] = __('Session', 'unilms');
    $columns['uni_lms_classes_class_fall_spring'] = __('Fall/Spring', 'unilms');
    unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_classes_columns', 'uni_lms_classes_columns_std' );

function uni_lms_classes_populate_columns_std( $column ) {
    if ( 'uni_lms_classes_class_semester' == $column ) {
        $class_semester = esc_html( get_post_meta( get_the_ID(), 'class_semester', true ) );
        echo esc_html($class_semester);
    }
    elseif ( 'uni_lms_classes_class_session' == $column ) {
        $class_session = get_post_meta( get_the_ID(), 'class_session', true );
        echo esc_html($class_session);
    }
    elseif ( 'uni_lms_classes_class_fall_spring' == $column ) {
        $class_fall_spring = get_post_meta( get_the_ID(), 'class_fall_spring', true );
        echo esc_html($class_fall_spring);
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_classes_populate_columns_std' );


function uni_lms_classes_sort_columns_std( $columns ) {
    $columns['uni_lms_classes_class_semester'] = 'uni_lms_classes_class_semester';
    $columns['uni_lms_classes_class_session'] = 'uni_lms_classes_class_session';
    $columns['uni_lms_classes_class_fall_spring'] = 'uni_lms_classes_class_fall_spring';
 
    return $columns;
}

add_filter( 'manage_edit-uni_lms_classes_sortable_columns', 'uni_lms_classes_sort_columns_std' );

function uni_lms_classes_column_orderby_std ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'uni_lms_classes_class_semester' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'class_semester', 'orderby' => 'meta_value_num' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_classes_class_session' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'class_session', 'orderby' => 'meta_value_num' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_classes_class_fall_spring' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'class_fall_spring', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}
add_filter( 'request', 'uni_lms_classes_column_orderby_std' );

function include_template_function_uni_lms_classes_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_classes' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_classes_get_template_hierarchy_std( 'single-uni_lms_classes' );
    }elseif (is_archive()) {
        return uni_lms_classes_get_template_hierarchy_std( 'archive-uni_lms_classes' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_classes_get_template_hierarchy_std( $template ) {
 
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
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/classes/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_classes_std', 1 );

?>