<?php
/**
 * The template for displaying single student.
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
                <div class="entry-header">
                    <?php 
                    $attendance_id = get_the_ID();
                    ?>
                    <strong><?php _e('Registration Number:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'student_reg_no', true ) ); ?>
                    </br>
                    <strong><?php _e('Class:', 'unilms');?> </strong>
                    <?php echo esc_html( get_the_title (get_post_meta( get_the_ID(), 'student_class', true ) ) ); ?>
                </div><!-- .entry-header -->

                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <h2><?php echo _e('Student Result Card', 'unilms');?></h2>
                        <?php 
                        $current_user_id = get_the_ID();
                        $student_reg_no = get_post_meta( get_the_ID(), 'student_reg_no', true );
                        $class_id = intval(get_post_meta( get_the_ID(), 'student_class', true ));
                        $courses_args = array( 
                            'post_type' => 'uni_lms_courses',
                            'posts_per_page' => -1,
                            'orderby'        => 'title',
                            'order'          => 'ASC'
                        );
                        $courses_loop = new WP_Query( $courses_args );
                        
                        while ( $courses_loop->have_posts() ) : $courses_loop->the_post();
                            
                            $class_course = get_post_meta( $class_id, 'uni_lms_class_course-'.get_the_ID(), true );
                            $course_title = get_the_title();
                            if($class_course == "yes"):
                                $course_id = get_the_ID();
                                //echo $course_id. '</br>';
                                ?>
                                <h3><?php printf(__('Quizzes Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
                                <?php 
                                
                                if($student_reg_no != "" && $class_id != 0){
                                    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_quizzes.php');
                                }
                                ?>
                                <h3><?php printf(__('Assignments Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
                                <?php 
                                if($student_reg_no != "" && $class_id != 0){
                                    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_assignments.php');
                                }
                                ?>
                                <h3><?php printf(__('Attendances for (%s)', 'unilms'), esc_html($course_title));?></h3>
                                <?php 
                                if($student_reg_no != "" && $class_id != 0){
                                    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_attendance.php');
                                }
                                ?>
                                <h3><?php printf(__('Mid Term Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
                                <?php 
                                if($student_reg_no != "" && $class_id != 0){
                                    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_mid_term.php');
                                }
                                ?>
                                <h3><?php printf(__('Final Term Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
                                <?php 
                                if($student_reg_no != "" && $class_id != 0){
                                    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_term.php');
                                }
                                ?>
                                <h3><?php printf(__('Final Result for (%s)', 'unilms'), esc_html($course_title));?></h3>
                                <?php 
                                if($student_reg_no != "" && $class_id != 0){
                                    include( UNI_LMS_BASE_DIR . '/plugin_pages/includes/teachers/teacher_course_class_final_result.php');
                                }
                                ?>
                        <?php
                            endif;
                        endwhile;
                        ?>
                    </div><!-- .entry-content -->
                </div><!-- .entry-content-wrapper -->
            </article><!-- #post-## -->
        <?php endwhile; // End of the loop. ?>
        </main><!-- #main -->
	</div><!-- .row -->
</div><!-- .codoswp-container -->
<?php
get_footer();
