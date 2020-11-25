<?php
/**
 * The template for displaying all single course files.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>
<div class="codoswp-container">
	<div class="row">
		<main id="primary" class="site-main col-sm-12 col-md-12">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header alignwide">
                    <div class="codoswp-container">
                        <div class="page-title">
                            <?php
                                the_title( '<h1>', '</h1>' );
                            ?>
                        </div>
                    </div>
                </header>
                <div class="entry-header" style="text-align: center;">
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
                </div><!-- .entry-header -->
                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <div class="uni_lms_course_tabs">
                        <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_grad_policy')"><?php _e('Grad Policy', 'unilms');?></button>
                        <button class="tablinks" onclick="openCourseSections(event, 'course_outline')"><?php _e('Course Outline', 'unilms');?></button>
                        <button class="tablinks" onclick="openCourseSections(event, 'course_plan')"><?php _e('Course Plan', 'unilms');?></button>
                        <button class="tablinks" onclick="openCourseSections(event, 'course_inst_log')"><?php _e('Instructor Log', 'unilms');?></button>
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
        <?php endwhile; // End of the loop. ?>
        </main><!-- #main -->
	</div><!-- .row -->
</div><!-- .codoswp-container -->
<?php
get_footer();
