<?php
/*create custom post type uni_lms_students*/

function create_post_uni_lms_students_std() {
    register_post_type( 'uni_lms_students',
        array(
            'labels' => array(
                'name' => __('Students', 'unilms'),
                'singular_name' => __('Student', 'unilms'),
                'add_new' => __('Add New', 'unilms'),
                'add_new_item' => __('Add New Student', 'unilms'),
                'edit' => __('Edit', 'unilms'),
                'edit_item' => __('Edit Student', 'unilms'),
                'new_item' => __('New Student', 'unilms'),
                'view' => __('View', 'unilms'),
                'view_item' => __('View Student', 'unilms'),
                'search_items' => __('Search Students', 'unilms'),
                'not_found' => __('No Student found', 'unilms'),
                'not_found_in_trash' => __('No Students found in Trash', 'unilms'),
                'parent' => __('Parent Student', 'unilms')
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false,
        )
    );
}

add_action( 'init', 'create_post_uni_lms_students_std' );

function display_uni_lms_students_meta_box_std( $uni_lms_students ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_students_meta_box');
    }
    $student_reg_no = get_post_meta( $uni_lms_students->ID, 'student_reg_no', true );
    $student_dpt = get_post_meta( $uni_lms_students->ID, 'student_dpt', true );
    $student_group = esc_html (get_post_meta( $uni_lms_students->ID, 'student_group', true ));
    $student_class = esc_html (get_post_meta( $uni_lms_students->ID, 'student_class', true ));
    ?>
    <table>
        <tr>
            <td style="width: 100%"><?php _e('Registration No (Complete)', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_students_reg_no" value="<?php echo esc_attr($student_reg_no); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Department', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_students_dpt" value="<?php echo esc_attr($student_dpt); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Group (Networks or Web etc.)', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_students_group" value="<?php echo esc_attr($student_group); ?>" /></td>
        </tr>
        <tr>
            <td><?php _e('Assign Class', 'unilms'); ?></td>
            <td>
                <?php 
                $args = array( 
                    'post_type' => 'uni_lms_classes',
                    'posts_per_page' => -1
                    );
                $loop = new WP_Query( $args );
                if($loop->have_posts()){
                ?>
                <select name="uni_lms_students_class">
                    <option value="" <?php if($student_class == 0){echo 'selected';}?> ><?php _e('Select Class', 'unilms'); ?></option>
                    <?php

                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($student_class == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
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

function register_meta_boxes_for_uni_lms_students_std() {
    add_meta_box( 'uni_lms_students_meta_box',
        __('Student Details'),
        'display_uni_lms_students_meta_box_std',
        'uni_lms_students', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_students_std' );

function add_uni_lms_students_fields_std( $uni_lms_students_id, $uni_lms_students ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_students_id );
    $is_revision = wp_is_post_revision( $uni_lms_students_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_students_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_students_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_students->post_type == 'uni_lms_students' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_students_reg_no'] ) && $_POST['uni_lms_students_reg_no'] != '' ) {
            update_post_meta( $uni_lms_students_id, 'student_reg_no', sanitize_text_field($_POST['uni_lms_students_reg_no']) );
        }
        if ( isset( $_POST['uni_lms_students_dpt'] ) && $_POST['uni_lms_students_dpt'] != '' ) {
            update_post_meta( $uni_lms_students_id, 'student_dpt', sanitize_text_field($_POST['uni_lms_students_dpt']) );
        }
        if ( isset( $_POST['uni_lms_students_group'] ) && $_POST['uni_lms_students_group'] != '' ) {
            update_post_meta( $uni_lms_students_id, 'student_group', sanitize_text_field($_POST['uni_lms_students_group']) );
        }
        if ( isset( $_POST['uni_lms_students_class'] ) && $_POST['uni_lms_students_class'] != '' ) {
            update_post_meta( $uni_lms_students_id, 'student_class', intval($_POST['uni_lms_students_class']) );
        }
    }
}

add_action( 'save_post', 'add_uni_lms_students_fields_std', 10, 2 );


function uni_lms_students_columns_std( $columns ) {
    $columns['uni_lms_students_reg_no'] = __('Reg No','unilms');
    $columns['uni_lms_students_dpt'] = __('Department','unilms');
    $columns['uni_lms_students_group'] = __('Group','unilms');
    unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_students_columns', 'uni_lms_students_columns_std' );

function uni_lms_students_populate_columns_std( $column ) {
    if ( 'uni_lms_students_reg_no' == $column ) {
        $student_reg_no = esc_html( get_post_meta( get_the_ID(), 'student_reg_no', true ) );
        echo $student_reg_no;
    }
    elseif ( 'uni_lms_students_dpt' == $column ) {
        $student_dpt = esc_html(get_post_meta( get_the_ID(), 'student_dpt', true ));
        echo $student_dpt;
    }
    elseif ( 'uni_lms_students_group' == $column ) {
        $student_group = esc_html(get_post_meta( get_the_ID(), 'student_group', true ));
        echo $student_group;
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_students_populate_columns_std' );


function uni_lms_students_sort_columns_std( $columns ) {
    $columns['uni_lms_students_reg_no'] = 'uni_lms_students_reg_no';
    $columns['uni_lms_students_dpt'] = 'uni_lms_students_dpt';
    $columns['uni_lms_students_group'] = 'uni_lms_students_group';
 
    return $columns;
}

add_filter( 'manage_edit-uni_lms_students_sortable_columns', 'uni_lms_students_sort_columns_std' );

function uni_lms_students_column_orderby_std ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'uni_lms_students_reg_no' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'student_reg_no', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_students_dpt' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'student_dpt', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_students_group' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'student_group', 'orderby' => 'meta_value' ) );
    }
    return $vars;
}
add_filter( 'request', 'uni_lms_students_column_orderby_std' );

function include_template_function_uni_lms_students_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_students' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_students_get_template_hierarchy_std( 'single-uni_lms_students' );
    }elseif (is_archive()) {
        return uni_lms_students_get_template_hierarchy_std( 'archive-uni_lms_students' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_students_get_template_hierarchy_std( $template ) {
 
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
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/students/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_students_std', 1 );

?>