<?php
/*create custom post type course*/

function create_post_uni_lms_courses_std() {
    register_post_type( 'uni_lms_courses',
        array(
            'labels' => array(
                'name' => __('Courses', 'unilms'),
                'singular_name' => __('Course', 'unilms'),
                'add_new' => __('Add New', 'unilms'),
                'add_new_item' => __('Add New Course', 'unilms'),
                'edit' => __('Edit', 'unilms'),
                'edit_item' => __('Edit Course', 'unilms'),
                'new_item' => __('New Course', 'unilms'),
                'view' => __('View', 'unilms'),
                'view_item' => __('View Course', 'unilms'),
                'search_items' => __('Search Courses', 'unilms'),
                'not_found' => __('No Course found', 'unilms'),
                'not_found_in_trash' => __('No Courses found in Trash', 'unilms'),
                'parent' => __('Parent Course', 'unilms')
            ),
 
            'public' => true,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
            'taxonomies' => array( '' ),
            'has_archive' => true,
            'show_in_menu' => false,
        )
    );
}

add_action( 'init', 'create_post_uni_lms_courses_std' );

function display_uni_lms_course_meta_box_std( $uni_lms_course ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_course_meta_box');
    }
    $course_code = esc_html( get_post_meta( $uni_lms_course->ID, 'course_code', true ) );
    $course_title = esc_html( get_post_meta( $uni_lms_course->ID, 'course_title', true ) );
    $credit_hours = intval( get_post_meta( $uni_lms_course->ID, 'credit_hours', true ) );
    $course_class = intval( get_post_meta( $uni_lms_course->ID, 'course_class', true ) );
    $course_duration = intval( get_post_meta( $uni_lms_course->ID, 'course_duration', true ) );
    $course_lecture_duration = get_post_meta( $uni_lms_course->ID, 'course_lecture_duration', true );
    $course_pre_requisite = get_post_meta( $uni_lms_course->ID, 'course_pre_requisite', true );
    $course_aims_obj = get_post_meta( $uni_lms_course->ID, 'course_aims_obj', true );
    $course_learning_outcomes = get_post_meta( $uni_lms_course->ID, 'course_learning_outcomes', true );
    $course_txt_books_ref = get_post_meta( $uni_lms_course->ID, 'course_txt_books_ref', true );
    $course_tools_soft = get_post_meta( $uni_lms_course->ID, 'course_tools_soft', true );
    $course_lectures_per_week = intval( get_post_meta( $uni_lms_course->ID, 'course_lectures_per_week', true ) );
    $course_teacher = intval( get_post_meta( $uni_lms_course->ID, 'course_teacher', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%"><?php _e('Course Title', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_course_title" value="<?php echo esc_attr($course_title); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%"><?php _e('Course Code', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_course_course_code" value="<?php echo esc_attr($course_code); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Credit Hours', 'unilms'); ?></td>
            <td><input type="text" size="80" name="uni_lms_course_credit_hours" value="<?php echo esc_attr($credit_hours); ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Course Duration', 'unilms'); ?></td>
            <td>
                <input type="text"  name="uni_lms_course_duration" value="<?php echo esc_attr($course_duration); ?>" />
                <?php _e(' Weeks', 'unilms'); ?>
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Lectures Per Week', 'unilms'); ?></td>
            <td>
                <input type="text" size="80" name="uni_lms_course_lectures_per_week" value="<?php echo esc_attr($course_lectures_per_week); ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Lecture Duration', 'unilms'); ?></td>
            <td>
                <input type="text"  name="uni_lms_course_lecture_duration" value="<?php echo esc_attr($course_lecture_duration); ?>" />
                <?php _e(' hours', 'unilms'); ?>
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Pre-Requisite', 'unilms'); ?></td>
            <td>
                <input type="text"  name="uni_lms_course_pre_requisite" value="<?php echo esc_attr($course_pre_requisite); ?>" />
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Aims & Objectives', 'unilms'); ?></td>
            <td>
                <textarea name="uni_lms_course_aims_obj" cols="70" rows="5"><?php echo esc_textarea($course_aims_obj); ?></textarea>
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Learning Outcomes', 'unilms'); ?></td>
            <td>
                <textarea name="uni_lms_course_learning_outcomes" cols="70" rows="5"><?php echo esc_textarea($course_learning_outcomes); ?></textarea>
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Text Books & Reference Materials', 'unilms'); ?></td>
            <td>
                <textarea name="uni_lms_course_txt_books_ref" cols="70" rows="5"><?php echo esc_textarea($course_txt_books_ref); ?></textarea>
            </td>
        </tr>
        <tr>
            <td style="width: 150px"><?php _e('Tools / Softwares', 'unilms'); ?></td>
            <td>
                <textarea name="uni_lms_course_tools_soft" cols="70" rows="5"><?php echo esc_textarea($course_tools_soft); ?></textarea>
            </td>
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
                <select name="uni_lms_course_class">
                    <option value="0" <?php if($course_class == 0){echo 'selected';}?> ><?php _e('Select Class', 'unilms');?></option>
                    <?php
                        
                        while ( $loop->have_posts() ) : $loop->the_post();
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if($course_class == get_the_ID()){echo 'selected';}?> ><?php echo esc_html(the_title());?></option>
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

function register_meta_boxes_for_uni_lms_course_std() {
    add_meta_box( 'uni_lms_course_meta_box',
        __('Course Details', 'unilms'),
        'display_uni_lms_course_meta_box_std',
        'uni_lms_courses', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_course_std' );

function add_uni_lms_course_fields_std( $uni_lms_course_id, $uni_lms_course ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_course_id );
    $is_revision = wp_is_post_revision( $uni_lms_course_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_course_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_course_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_course->post_type == 'uni_lms_courses' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['uni_lms_course_course_code'] ) && $_POST['uni_lms_course_course_code'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_code', sanitize_text_field($_POST['uni_lms_course_course_code']) );
        }
        if ( isset( $_POST['uni_lms_course_title'] ) && $_POST['uni_lms_course_title'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_title', sanitize_text_field($_POST['uni_lms_course_title']) );
        }
        if ( isset( $_POST['uni_lms_course_class'] ) && $_POST['uni_lms_course_class'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_class', intval($_POST['uni_lms_course_class']) );
        }
        if ( isset( $_POST['uni_lms_course_credit_hours'] ) && $_POST['uni_lms_course_credit_hours'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'credit_hours', intval($_POST['uni_lms_course_credit_hours']) );
        }
        if ( isset( $_POST['uni_lms_course_duration'] ) && $_POST['uni_lms_course_duration'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_duration', sanitize_text_field($_POST['uni_lms_course_duration']) );
        }
        if ( isset( $_POST['uni_lms_course_pre_requisite'] ) && $_POST['uni_lms_course_pre_requisite'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_pre_requisite', sanitize_text_field($_POST['uni_lms_course_pre_requisite']) );
        }
        if ( isset( $_POST['uni_lms_course_aims_obj'] ) && $_POST['uni_lms_course_aims_obj'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_aims_obj', sanitize_text_field($_POST['uni_lms_course_aims_obj']) );
        }
        if ( isset( $_POST['uni_lms_course_learning_outcomes'] ) && $_POST['uni_lms_course_learning_outcomes'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_learning_outcomes', sanitize_text_field($_POST['uni_lms_course_learning_outcomes']) );
        }
        if ( isset( $_POST['uni_lms_course_txt_books_ref'] ) && $_POST['uni_lms_course_txt_books_ref'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_txt_books_ref', sanitize_text_field($_POST['uni_lms_course_txt_books_ref']) );
        }
        if ( isset( $_POST['uni_lms_course_tools_soft'] ) && $_POST['uni_lms_course_tools_soft'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_tools_soft', sanitize_text_field($_POST['uni_lms_course_tools_soft']) );
        }
        if ( isset( $_POST['uni_lms_course_lecture_duration'] ) && $_POST['uni_lms_course_lecture_duration'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_lecture_duration', sanitize_text_field($_POST['uni_lms_course_lecture_duration']) );
        }
        if ( isset( $_POST['uni_lms_course_lectures_per_week'] ) && $_POST['uni_lms_course_lectures_per_week'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_lectures_per_week', intval($_POST['uni_lms_course_lectures_per_week']) );
        }
        
    }
}

add_action( 'save_post', 'add_uni_lms_course_fields_std', 10, 2 );


function display_uni_lms_course_contents_meta_box_std( $uni_lms_course ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_course_contents_meta_box');
    }
    $repeatable_fields_unilms_coursecont = get_post_meta($uni_lms_course->ID, 'repeatable_fields_unilms_coursecont', true);
    
    ?>
    <?php
        wp_enqueue_script('unilms-repeatablefields' ,  UNI_LMS_PLUGIN_URL. 'js/unilmsrep-script.js',  array(), false, true);
    ?>
    
    <h2><strong><?php _e('Course Outline - Daily Activities', 'unilms'); ?></strong></h2>
    <table id="repeatable-fieldset-unilms-coursecont" width="100%">
        <thead>
            <tr>
                <th width="2%">Remove</th>
                <th width="30%">Lecture</th>
                <th width="30%">Assignment</th>
                <th width="30%">Quiz</th>
                <th width="2%">Sort</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if ( $repeatable_fields_unilms_coursecont ) :
            foreach ( $repeatable_fields_unilms_coursecont as $field ) {
    ?>
        <tr class="courseconsec">
            <td><a class="button remove-row-unilms-coursecont" href="#">&times;</a></td>
            <td>
                <select name="unilms_coursecont_lecture[]" class="widefat">
                    <option value="" <?php if(array_key_exists('unilms_coursecont_lecture', $field) && $field['unilms_coursecont_lecture'] == ''){echo 'selected';}?> ><?php _e('Select Lecture', 'unilms'); ?></option>
                    <?php
                        $args = array( 
                            'post_type' => array('uni_lms_lectures'),
                            'posts_per_page' => -1
                        );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if(array_key_exists('unilms_coursecont_lecture', $field) && $field['unilms_coursecont_lecture'] == get_the_ID()){echo 'selected';}?> ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td>
                <select name="unilms_coursecont_assign[]" class="widefat">
                    <option value="" <?php if(array_key_exists('unilms_coursecont_assign', $field) && $field['unilms_coursecont_assign'] == ''){echo 'selected';}?> ><?php _e('Select Assignment', 'unilms'); ?></option>
                    <?php
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
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                           
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if(array_key_exists('unilms_coursecont_assign', $field) && $field['unilms_coursecont_assign'] == get_the_ID()){echo 'selected';}?> ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td>
                <select name="unilms_coursecont_quiz[]" class="widefat">
                    <option value="" <?php if(array_key_exists('unilms_coursecont_quiz', $field) && $field['unilms_coursecont_quiz'] == ''){echo 'selected';}?> ><?php _e('Select Quiz', 'unilms'); ?></option>
                    <?php
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
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" <?php if(array_key_exists('unilms_coursecont_quiz', $field) && $field['unilms_coursecont_quiz'] == get_the_ID()){echo 'selected';}?> ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
            
        </tr>
        <?php
            }
        else :
            // show a blank one
        ?>
        <tr class="courseconsec">
            <td><a class="button remove-row-unilms-coursecont" href="#">&times;</a></td>
            <td>
                <select name="unilms_coursecont_lecture[]" class="widefat">
                    <option value="" <?php echo 'selected';?> ><?php _e('Select Lecture', 'unilms'); ?></option>
                    <?php
                        $args = array( 
                            'post_type' => array('uni_lms_lectures'),
                            'posts_per_page' => -1
                        );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td>
                <select name="unilms_coursecont_assign[]" class="widefat">
                    <option value="" <?php echo 'selected';?> ><?php _e('Select Assignment', 'unilms'); ?></option>
                    <?php
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
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                           
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td>
                <select name="unilms_coursecont_quiz[]" class="widefat">
                    <option value="" <?php echo 'selected';?> ><?php _e('Select Quiz', 'unilms'); ?></option>
                    <?php
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
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();   
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
            
        </tr>
        <?php endif; ?>

        <!-- empty hidden one for jQuery -->
        <tr class="empty-unilms-coursecont-row screen-reader-text">
            <td><a class="button remove-row-unilms-coursecont" href="#">&times;</a></td>
            <td>
                <select name="unilms_coursecont_lecture[]" class="widefat">
                    <option value="" <?php echo 'selected';?> ><?php _e('Select Lecture', 'unilms'); ?></option>
                    <?php
                        $args = array( 
                            'post_type' => array('uni_lms_lectures'),
                            'posts_per_page' => -1
                        );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td>
                <select name="unilms_coursecont_assign[]" class="widefat">
                    <option value="" <?php echo 'selected';?> ><?php _e('Select Assignment', 'unilms'); ?></option>
                    <?php
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
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                           
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td>
                <select name="unilms_coursecont_quiz[]" class="widefat">
                    <option value="" <?php echo 'selected';?> ><?php _e('Select Quiz', 'unilms'); ?></option>
                    <?php
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
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            
                        ?>
                            <option value="<?php echo esc_attr(get_the_ID());?>" ><?php echo  esc_html(the_title());?></option>
                        <?php
                        endwhile; 
                    ?>
                </select>
            </td>
            <td><a class="sort"><span class="dashicons dashicons-move"></span></a></td>
            
        </tr>
        </tbody>
    </table>

    <p><a id="add-unilms-coursecont-row" class="button" href="#"><?php _e('Add Section', 'unilms');?></a>
    </p><hr>
    <input type="submit" class="unilms_coursecont_data_submit" value="Save" />
    
    <?php
}

function register_meta_boxes_for_uni_lms_course_contents_std() {
    add_meta_box( 'uni_lms_course_contents_meta_box',
        __('Course Contents', 'unilms'),
        'display_uni_lms_course_contents_meta_box_std',
        'uni_lms_courses', 'normal', 'high'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_course_contents_std' );

function add_uni_lms_course_contents_fields_std( $uni_lms_course_id, $uni_lms_course ) {
    // Checks save status

    $is_autosave = wp_is_post_autosave( $uni_lms_course_id );
    $is_revision = wp_is_post_revision( $uni_lms_course_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_course_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_course_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_course->post_type == 'uni_lms_courses' ) {
        if ( isset( $_POST['unilms_coursecont_lecture'] ) &&
         isset( $_POST['unilms_coursecont_assign'] ) &&
         isset( $_POST['unilms_coursecont_quiz'] )
         ){
            $unilms_coursecont_lecture = $_POST['unilms_coursecont_lecture'];
            $unilms_coursecont_assign = $_POST['unilms_coursecont_assign'];
            $unilms_coursecont_quiz = $_POST['unilms_coursecont_quiz'];
            
            $array_lectures = array();
            $array_lectures = $_POST['unilms_coursecont_lecture'];
            $count = count( $array_lectures );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $array_lectures[$i] != '' ) :
                    $new_array_contents[$i]['unilms_coursecont_lecture'] = $array_lectures[$i];
                endif;
            }

            $array_assigns = array();
            $array_assigns = $_POST['unilms_coursecont_assign'];
            $count = count( $array_assigns );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $array_assigns[$i] != '' ) :
                    $new_array_contents[$i]['unilms_coursecont_assign'] = $array_assigns[$i];
                endif;
            }

            $array_quizzes = array();
            $array_quizzes = $_POST['unilms_coursecont_quiz'];
            $count = count( $array_quizzes );
            for ( $i = 0; $i < $count; $i++ ) {
                if ( $array_quizzes[$i] != '' ) :
                    $new_array_contents[$i]['unilms_coursecont_quiz'] = $array_quizzes[$i];
                endif;
            }
            if ( !empty( $new_array_contents )){
                update_post_meta( $uni_lms_course_id, 'repeatable_fields_unilms_coursecont', $new_array_contents );
            }  
        }   
    }

    
}

add_action( 'save_post', 'add_uni_lms_course_contents_fields_std', 10, 2 );

function display_uni_lms_course_settings_meta_box_std( $uni_lms_course ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    if ( function_exists('wp_nonce_field') ){
        wp_nonce_field( basename( __FILE__ ), 'uni_lms_course_settings_meta_box');
    }
    $course_sessionals_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_sessionals_marks', true ) );
    $course_mid_term_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_mid_term_marks', true ) );
    $course_final_term_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_final_term_marks', true ) );

    $course_quizzes_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_quizzes_marks', true ) );
    $course_assignments_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_assignments_marks', true ) );
    $course_projects_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_projects_marks', true ) );
    $course_classpart_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_classpart_marks', true ) );
    $course_attend_marks = intval( get_post_meta( $uni_lms_course->ID, 'course_attend_marks', true ) );

    $course_grad_ap = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_ap', true ) );
    $course_grad_a = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_a', true ) );
    $course_grad_bp = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_bp', true ) );
    $course_grad_b = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_b', true ) );
    $course_grad_bn = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_bn', true ) );
    $course_grad_cp = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_cp', true ) );
    $course_grad_c = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_c', true ) );
    $course_grad_cn = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_cn', true ) );
    $course_grad_d = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_d', true ) );
    $course_grad_f = intval( get_post_meta( $uni_lms_course->ID, 'course_grad_f', true ) );
    ?>
    <table class="widefat">
        <tr><td><strong><?php _e('Mid Term Settings', 'unilms'); ?></strong></td></tr>
        <tr>
            <td>
                <label><?php _e('Mid Term % Marks', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_mid_term_marks" value="<?php echo esc_attr($course_mid_term_marks); ?>" />
            </td>
        </tr>
        <tr><td><strong><?php _e('Final Term Settings', 'unilms'); ?></strong></td></tr>
        <tr>
            <td>
                <label><?php _e('Final Term % Marks', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_final_term_marks" value="<?php echo esc_attr($course_final_term_marks); ?>" />
            </td>
        </tr>
        <tr><td><strong><?php _e('Sessionals Settings', 'unilms'); ?></strong></td></tr>
        <tr>
            <td>
                <label><?php _e('Sessionals % Marks', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_sessionals_marks" value="<?php echo esc_attr($course_sessionals_marks); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('Activities included in sessionals', 'unilms'); ?></label></br>
                <label for="uni_lms_course_sessionals_activities_quizzes">
                    <?php 
                        $activity_quizzes = get_post_meta( $uni_lms_course->ID, 'uni_lms_course_sessionals_activities_quizzes', true );
                        if($activity_quizzes == "yes"){
                            $field_is_checked = 'checked="checked"';
                        }else{
                            $field_is_checked = '';
                        }
                    ?>
                    <input type="checkbox" name="uni_lms_course_sessionals_activities_quizzes" id="uni_lms_course_sessionals_activities_quizzes" value="<?php echo $activity_quizzes; ?>" <?php echo $field_is_checked; ?> />
                    <span><?php _e('Quizzes', 'uni_lms'); ?></span>
                </label><br>
                <label for="uni_lms_course_sessionals_activities_assignments">
                    <?php 
                        $activity_assignments = get_post_meta( $uni_lms_course->ID, 'uni_lms_course_sessionals_activities_assignments', true );
                        if($activity_assignments == "yes"){
                            $field_is_checked = 'checked="checked"';
                        }else{
                            $field_is_checked = '';
                        }
                    ?>
                    <input type="checkbox" name="uni_lms_course_sessionals_activities_assignments" id="uni_lms_course_sessionals_activities_assignments" value="<?php echo $activity_assignments; ?>" <?php echo $field_is_checked; ?> />
                    <span><?php _e('Assignments', 'unilms'); ?></span>
                </label><br>
                <label for="uni_lms_course_sessionals_activities_projects">
                    <?php 
                        $activity_projects = get_post_meta( $uni_lms_course->ID, 'uni_lms_course_sessionals_activities_projects', true );
                        if($activity_projects == "yes"){
                            $field_is_checked = 'checked="checked"';
                        }else{
                            $field_is_checked = '';
                        }
                    ?>
                    <input type="checkbox" name="uni_lms_course_sessionals_activities_projects" id="uni_lms_course_sessionals_activities_projects" value="<?php echo $activity_projects; ?>" <?php echo $field_is_checked; ?> />
                    <span><?php _e('Projects', 'unilms'); ?></span>
                </label><br>
                <label for="uni_lms_course_sessionals_activities_classpart">
                    <?php 
                        $activity_classpart = get_post_meta( $uni_lms_course->ID, 'uni_lms_course_sessionals_activities_classpart', true );
                        if($activity_classpart == "yes"){
                            $field_is_checked = 'checked="checked"';
                        }else{
                            $field_is_checked = '';
                        }
                    ?>
                    <input type="checkbox" name="uni_lms_course_sessionals_activities_classpart" id="uni_lms_course_sessionals_activities_classpart" value="<?php echo $activity_classpart; ?>" <?php echo $field_is_checked; ?> />
                    <span><?php _e('Class Participation', 'unilms'); ?></span>
                </label><br>
                <label for="uni_lms_course_sessionals_activities_attend">
                    <?php 
                        $activity_attend = get_post_meta( $uni_lms_course->ID, 'uni_lms_course_sessionals_activities_attend', true );
                        if($activity_attend == "yes"){
                            $field_is_checked = 'checked="checked"';
                        }else{
                            $field_is_checked = '';
                        }
                    ?>
                    <input type="checkbox" name="uni_lms_course_sessionals_activities_attend" id="uni_lms_course_sessionals_activities_attend" value="<?php echo $activity_attend; ?>" <?php echo $field_is_checked; ?> />
                    <span><?php _e('Class Attendance', 'unilms'); ?></span>
                </label><br>
            </td>
        </tr>
        <?php if($activity_quizzes == 'yes'):?>
        <tr>
            <td>
                <label><?php printf( __('Quizzes perc Marks (out of %s perc)', 'unilms'), $course_sessionals_marks); ?></label>
                </br>
                <input type="text" name="uni_lms_course_quizzes_marks" value="<?php echo esc_attr($course_quizzes_marks); ?>" />
            </td>
        </tr>
        <?php endif;?>
        <?php if($activity_assignments == 'yes'):?>
        <tr>
            <td>
                <label><?php printf(__('Assignments per Marks (out of %s perc)', 'unilms'), $course_sessionals_marks); ?></label>
                </br>
                <input type="text" name="uni_lms_course_assignments_marks" value="<?php echo esc_attr($course_assignments_marks); ?>" />
            </td>
        </tr>
        <?php endif;?>
        <?php if($activity_projects == 'yes'):?>
        <tr>
            <td>
                <label><?php printf(__('Projects perc Marks (out of %s perc)', 'unilms'), $course_sessionals_marks); ?></label>
                </br>
                <input type="text" name="uni_lms_course_projects_marks" value="<?php echo esc_attr($course_projects_marks); ?>" />
            </td>
        </tr>
        <?php endif;?>
        <?php if($activity_classpart == 'yes'):?>
        <tr>
            <td>
                <label><?php printf(__('Class Participation perc Marks (out of %s perc)', 'unilms'), $course_sessionals_marks); ?></label>
                </br>
                <input type="text" name="uni_lms_course_classpart_marks" value="<?php echo esc_attr($course_classpart_marks); ?>" />
            </td>
        </tr>
        <?php endif;?>
        <?php if($activity_attend == 'yes'):?>
        <tr>
            <td>
                <label><?php printf(__('Attendance perc Marks (out of %s perc)', 'unilms'), $course_sessionals_marks); ?></label>
                </br>
                <input type="text" name="uni_lms_course_attend_marks" value="<?php echo esc_attr($course_attend_marks); ?>" />
            </td>
        </tr>
        <?php endif;?>
        <tr><td><strong><?php _e('Grad Settings', 'unilms');?></strong></td></tr>
        <tr>
            <td>
                <label><?php _e('A+ For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_ap" value="<?php echo esc_attr($course_grad_ap); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('A For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_a" value="<?php echo esc_attr($course_grad_a); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('B+ For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_bp" value="<?php echo esc_attr($course_grad_bp); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('B For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_b" value="<?php echo esc_attr($course_grad_b); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('B- For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_bn" value="<?php echo esc_attr($course_grad_bn); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('C+ For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_cp" value="<?php echo esc_attr($course_grad_cp); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('C For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_c" value="<?php echo esc_attr($course_grad_c); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('C- For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_cn" value="<?php echo esc_attr($course_grad_cn); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('D For Marks >=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_d" value="<?php echo esc_attr($course_grad_d); ?>" />
            </td>
        </tr>
        <tr>
            <td>
                <label><?php _e('F For Marks <=', 'unilms'); ?></label>
                <input type="text" name="uni_lms_course_grad_f" value="<?php echo esc_attr($course_grad_f); ?>" />
            </td>
        </tr>
    </table>
    <?php
}

function register_meta_boxes_for_uni_lms_course_settings_std() {
    add_meta_box( 'uni_lms_course_settings_meta_box',
        __('Course Settings', 'unilms'),
        'display_uni_lms_course_settings_meta_box_std',
        'uni_lms_courses', 'side', 'low'
    );
}

add_action( 'admin_init', 'register_meta_boxes_for_uni_lms_course_settings_std' );

function add_uni_lms_course_settings_fields_std( $uni_lms_course_id, $uni_lms_course ) {
    // Checks save status
    $is_autosave = wp_is_post_autosave( $uni_lms_course_id );
    $is_revision = wp_is_post_revision( $uni_lms_course_id );
    $is_valid_nonce = ( isset( $_POST[ 'uni_lms_course_meta_box' ] ) && wp_verify_nonce( $_POST[ 'uni_lms_course_meta_box' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    // Check post type
    if ( $uni_lms_course->post_type == 'uni_lms_courses' ) {
        // Store data in post meta table if present in post data
        
        if ( isset( $_POST['uni_lms_course_sessionals_marks'] ) && $_POST['uni_lms_course_sessionals_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_sessionals_marks', sanitize_text_field($_POST['uni_lms_course_sessionals_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_mid_term_marks'] ) && $_POST['uni_lms_course_mid_term_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_mid_term_marks', sanitize_text_field($_POST['uni_lms_course_mid_term_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_final_term_marks'] ) && $_POST['uni_lms_course_final_term_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_final_term_marks', sanitize_text_field($_POST['uni_lms_course_final_term_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_quizzes_marks'] ) && $_POST['uni_lms_course_quizzes_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_quizzes_marks', sanitize_text_field($_POST['uni_lms_course_quizzes_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_assignments_marks'] ) && $_POST['uni_lms_course_assignments_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_assignments_marks', sanitize_text_field($_POST['uni_lms_course_assignments_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_projects_marks'] ) && $_POST['uni_lms_course_projects_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_projects_marks', sanitize_text_field($_POST['uni_lms_course_projects_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_classpart_marks'] ) && $_POST['uni_lms_course_classpart_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_classpart_marks', sanitize_text_field($_POST['uni_lms_course_classpart_marks']) );
        }
        if ( isset( $_POST['uni_lms_course_attend_marks'] ) && $_POST['uni_lms_course_attend_marks'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_attend_marks', sanitize_text_field($_POST['uni_lms_course_attend_marks']) );
        }

        if ( isset( $_POST['uni_lms_course_grad_ap'] ) && $_POST['uni_lms_course_grad_ap'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_ap', sanitize_text_field($_POST['uni_lms_course_grad_ap']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_a'] ) && $_POST['uni_lms_course_grad_a'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_a', sanitize_text_field($_POST['uni_lms_course_grad_a']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_bp'] ) && $_POST['uni_lms_course_grad_bp'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_bp', sanitize_text_field($_POST['uni_lms_course_grad_bp']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_b'] ) && $_POST['uni_lms_course_grad_b'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_b', sanitize_text_field($_POST['uni_lms_course_grad_b']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_bn'] ) && $_POST['uni_lms_course_grad_bn'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_bn', sanitize_text_field($_POST['uni_lms_course_grad_bn']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_cp'] ) && $_POST['uni_lms_course_grad_cp'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_cp', sanitize_text_field($_POST['uni_lms_course_grad_cp']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_c'] ) && $_POST['uni_lms_course_grad_c'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_c', sanitize_text_field($_POST['uni_lms_course_grad_c']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_cn'] ) && $_POST['uni_lms_course_grad_cn'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_cn', sanitize_text_field($_POST['uni_lms_course_grad_cn']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_d'] ) && $_POST['uni_lms_course_grad_d'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_d', sanitize_text_field($_POST['uni_lms_course_grad_d']) );
        }
        if ( isset( $_POST['uni_lms_course_grad_f'] ) && $_POST['uni_lms_course_grad_f'] != '' ) {
            update_post_meta( $uni_lms_course_id, 'course_grad_f', sanitize_text_field($_POST['uni_lms_course_grad_f']) );
        }

        if ( isset( $_POST['uni_lms_course_sessionals_activities_quizzes'] ) ) {
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_quizzes', 'yes' );
        }else{
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_quizzes', 'no' );
        }
        if ( isset( $_POST['uni_lms_course_sessionals_activities_assignments'] ) ) {
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_assignments', 'yes' );
        }else{
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_assignments', 'no' );
        }
        if ( isset( $_POST['uni_lms_course_sessionals_activities_projects'] ) ) {
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_projects', 'yes' );
        }else{
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_projects', 'no' );
        }
        if ( isset( $_POST['uni_lms_course_sessionals_activities_classpart'] ) ) {
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_classpart', 'yes' );
        }else{
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_classpart', 'no' );
        }
        if ( isset( $_POST['uni_lms_course_sessionals_activities_attend'] ) ) {
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_attend', 'yes' );
        }else{
            update_post_meta( $uni_lms_course_id, 'uni_lms_course_sessionals_activities_attend', 'no' );
        }
    }
}

add_action( 'save_post', 'add_uni_lms_course_settings_fields_std', 10, 2 );

function include_template_function_uni_lms_courses_std( $template ) {
     // Post ID
    $post_id = get_the_ID();
 
    // For all other CPT
    if ( get_post_type( $post_id ) != 'uni_lms_courses' ) {
        return $template;
    }
 
    // Else use custom template
    if ( is_single() ) {
        return uni_lms_courses_get_template_hierarchy_std( 'single-uni_lms_courses' );
    }elseif (is_archive()) {
        return uni_lms_courses_get_template_hierarchy_std( 'archive-uni_lms_courses' );
    }
}

/**
 * Get the custom template if is set
 *
 * @since 1.0
 */
 
function uni_lms_courses_get_template_hierarchy_std( $template ) {
 
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
        $file = UNI_LMS_BASE_DIR . '/uni_lms_templates/courses/' . $template;
    }
 
    return apply_filters( 'rc_repl_template_' . $template, $file );
}

add_filter( 'template_include', 'include_template_function_uni_lms_courses_std', 1 );

function uni_lms_courses_columns_std( $columns ) {
    $columns['uni_lms_course_code'] = __('Course Code','unilms');
    $columns['uni_lms_course_class'] = __('Course Class','unilms');
    $columns['uni_lms_course_credit_hours'] = __('Credit Hours','unilms');
    unset( $columns['comments'] );
    return $columns;
}
add_filter( 'manage_edit-uni_lms_courses_columns', 'uni_lms_courses_columns_std' );

function uni_lms_course_populate_columns_std( $column ) {
    if ( 'uni_lms_course_code' == $column ) {
        $course_code = esc_html( get_post_meta( get_the_ID(), 'course_code', true ) );
        echo $course_code;
    }
    if ( 'uni_lms_course_class' == $column ) {
        $course_class = esc_html( get_post_meta( get_the_ID(), 'course_class', true ) );
        echo get_the_title($course_class);
    }
    elseif ( 'uni_lms_course_credit_hours' == $column ) {
        $credit_hours = intval(get_post_meta( get_the_ID(), 'credit_hours', true ));
        echo $credit_hours;
    }
}
add_action( 'manage_posts_custom_column', 'uni_lms_course_populate_columns_std' );


function uni_lms_course_sort_columns_std( $columns ) {
    $columns['uni_lms_course_code'] = 'uni_lms_course_code';
    $columns['uni_lms_course_credit_hours'] = 'uni_lms_course_credit_hours';
 
    return $columns;
}

add_filter( 'manage_edit-uni_lms_courses_sortable_columns', 'uni_lms_course_sort_columns_std' );

function uni_lms_course_column_orderby_std ( $vars ) {
    if ( !is_admin() )
        return $vars;
    if ( isset( $vars['orderby'] ) && 'uni_lms_course_code' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'course_code', 'orderby' => 'meta_value' ) );
    }
    elseif ( isset( $vars['orderby'] ) && 'uni_lms_course_credit_hours' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array( 'meta_key' => 'credit_hours', 'orderby' => 'meta_value_num' ) );
    }
    return $vars;
}
add_filter( 'request', 'uni_lms_course_column_orderby_std' );

/*Meta Values in Filter List*/

add_action('restrict_manage_posts','uni_lms_courses_class_filter_std',10);

function uni_lms_courses_class_filter_std($post_type){
    if('uni_lms_courses' !== $post_type){
      return; //filter your post
    }

    $selected = 0;
    $request_attr = 'courses_class';
    if ( isset($_REQUEST[$request_attr]) ) {
      $selected = $_REQUEST[$request_attr];
    }else{
        $selected = '';
    }
    //get unique values of the meta field to filer by.
    $meta_key = 'course_class';
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
        <select name="courses_class">
            <option value="0" <?php if($selected == ''){echo 'selected';}?> >
                <?php _e( 'Show all Courses', 'unilms' );?>
            </option>
            <?php 
            foreach($results as $course_class){
            ?>
            <option value="<?php echo $course_class;?>" <?php if($selected == $course_class){echo 'selected';}?> >
                <?php echo get_the_title($course_class);?> 
            </option>

            <?php } ?>
        </select>
    <?php
}

add_filter( 'parse_query', 'uni_lms_courses_class_filter_request_query_std' , 10);
function uni_lms_courses_class_filter_request_query_std($query){
    //modify the query only if it admin and main query.
    if( !(is_admin() AND $query->is_main_query()) ){ 
      return $query;
    }
    //we want to modify the query for the targeted custom post and filter option
    if( !('uni_lms_courses' == $query->query['post_type'] AND isset($_REQUEST['courses_class']) ) ){
      return $query;
    }
    //for the default value of our filter no modification is required
    if('' == $_REQUEST['courses_class']){
      return $query;
    }
   //modify the query_vars.
    $query->query_vars = array(
        'post_type' => 'uni_lms_courses',
        'meta_query' => array(
            array(
                'key' => 'course_class',
                'value' => $_REQUEST['courses_class'],
                'compare' => '=',
                'type' => 'CHAR'       
            )
        )
    );
    return $query;
}

/*create shortcode to display all courses*/
function uni_lms_courses_list_shortcode_std() {
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array( 'post_type' => 'uni_lms_courses', 'posts_per_page' => 10, 'paged' => $paged);
    $loop = new WP_Query( $args );
    ob_start();
    if($loop->have_posts()){
        ?>
        <table>
            <!-- Display table headers -->
            <tr>
                <th><strong><?php _e('Title','unilms');?></strong></th>
                <th><strong><?php _e('Course Code','unilms');?></strong></th>
                <th><strong><?php _e('Credit Hours','unilms');?></strong></th>
            </tr>
        <?php
        while ( $loop->have_posts() ) : $loop->the_post();
        ?>
            <tr>
                <td>
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </td>
                <td><?php echo esc_html( get_post_meta( get_the_ID(), 'course_code', true ) ); ?></td>
                <td><?php echo esc_html( get_post_meta( get_the_ID(), 'credit_hours', true ) ); ?></td>
            </tr>
        <?php
        endwhile;
        ?>
        </table>
        <?php //global $wp_query;
        if ( isset( $loop->max_num_pages ) && $loop->max_num_pages > 1 ) { ?>
            <nav style="overflow: hidden;">
                <div class="nav-previous alignleft">
                    <?php next_posts_link( '<span class="meta-nav">&larr;</span> Older Courses', $loop->max_num_pages); ?>
                </div>
                <div class="nav-next alignright">
                    <?php previous_posts_link( 'Newer Courses <span class= "meta-nav">&rarr;</span>' ); ?>
                </div>
            </nav>
        <?php };?>
    <?php
    }else{
    ?>
    <p><?php _e('Nothing found!', 'unilms');?></p>
    <?php    
    }
    return ob_get_clean();
}
add_shortcode( 'uni_lms_courses_list', 'uni_lms_courses_list_shortcode_std' );

function uni_lms_courses_list_query_std( $query ){
    if( ! is_admin()
        && $query->is_post_type_archive( 'uni_lms_courses' )
        && $query->is_main_query() ){
            $query->set( 'posts_per_page', 10 );
    }
}
add_action( 'pre_get_posts', 'uni_lms_courses_list_query_std' );

?>