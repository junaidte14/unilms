<?php
/**
 * The template for displaying all single course files.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>


<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header" style="text-align: center;">
                <?php 
                $options = get_option('uni_lms_options');
                if(!empty($options)){
                    if(array_key_exists('uni_lms_inst_logo', $options)){
                        $current_logo = $options['uni_lms_inst_logo'];
                    }else{
                        $current_logo = '';
                    }
                }else{
                    $current_logo = '';
                }
                if($current_logo != ""){
                ?>
                <img class="uni_lms_inst_logo" src="<?php echo esc_url($current_logo); ?>" height="150" width="150"/>
                <?php 
                }
                ?>
                <div class="course-thumbnail">
                    <?php the_post_thumbnail(); ?>
                </div>
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <?php 
                    $course_id = intval( get_post_meta( get_the_ID(), 'course_file_course', true ) );
                    $class_id = intval( get_post_meta( get_the_ID(), 'course_file_class', true ) );
                 ?>
                </br>
                <strong><?php _e('Course Title:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( $course_id, 'course_title', true ) ); ?>
                <br />
                <strong><?php _e('Course Code:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( $course_id, 'course_code', true ) ); ?>
                <br />
                <strong><?php _e('Credit Hours:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( $course_id, 'credit_hours', true ) ); ?>
                <br />
                <strong><?php _e('Course Duration:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( $course_id, 'course_duration', true ) ); ?>
                <br />
                <strong><?php _e('Lectures Per Week:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( $course_id, 'course_lectures_per_week', true ) ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content-wrapper">
                <div class="entry-content">
                    <div class="uni_lms_course_tabs">
                      <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_grad_policy')"><?php _e('Grad Policy', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_outline')"><?php _e('Course Outline', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_plan')"><?php _e('Course Plan', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_inst_log')"><?php _e('Instructor Log', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_stud_log')"><?php _e('Student Log', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_attendance')"><?php _e('Attendance', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_quizzes')"><?php _e('Quizzes', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_assignments')"><?php _e('Assignments', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_sessionals')"><?php _e('Sessionals', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_mid_term')"><?php _e('Mid Term', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_final_term')"><?php _e('Final Term', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_final_result')"><?php _e('Final Result', 'unilms');?></button>
                    </div>
                    <div id="course_grad_policy" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_grad_policy.php');
                        ?>
                    </div>
                    <div id="course_outline" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_course_outline.php');
                        ?>
                    </div>
                    <div id="course_plan" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_course_plan.php');
                        ?>
                    </div>
                    <div id="course_inst_log" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_inst_log.php');
                        ?>
                    </div>
                    <div id="course_stud_log" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_student_log.php');
                        ?>
                    </div>
                    <div id="course_attendance" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_attendance.php');
                        ?>
                    </div>
                    <div id="course_quizzes" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_quizzes.php');
                        ?>
                    </div>
                    <div id="course_assignments" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_assignments.php');
                        ?>
                    </div>
                    <div id="course_sessionals" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_sessionals.php');
                        ?>
                    </div>
                    <div id="course_mid_term" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_mid_term.php');
                        ?>
                    </div>
                    <div id="course_final_term" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_term.php');
                        ?>
                    </div>
                    <div id="course_final_result" class="uni_lms_course_tabcontent">
                        <?php 
                            include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_result.php');
                        ?>
                    </div>
                    
                </div><!-- .entry-content -->
            </div><!-- .entry-content-wrapper -->

        </article><!-- #post-## -->
        <div class="uni_lms_print_comments">
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </div>

    <?php endwhile; // End of the loop. ?>

    </main><!-- #main -->
</div><!-- #primary -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>

