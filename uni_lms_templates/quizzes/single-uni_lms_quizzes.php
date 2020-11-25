<?php
/**
 * The template for displaying all single quizzes.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>
<div class="codoswp-container">
	<div class="row">
		<main id="primary" class="site-main col-sm-12 col-md-12">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php $quiz_type = get_post_meta( get_the_ID(), 'quiz_type', true );?>
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
                    <strong><?php _e('Max Marks:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'quiz_max_marks', true ) ); ?>
                    <br />
                    <strong><?php _e('Course:', 'unilms');?> </strong>
                    <?php echo esc_html( get_the_title( get_post_meta( get_the_ID(), 'quiz_course', true ) ) ); ?>
                    <br />
                    <strong><?php _e('Class:', 'unilms');?> </strong>
                    <?php echo esc_html( get_the_title( get_post_meta( get_the_ID(), 'quiz_class', true ) ) ); ?>
                    <?php if($quiz_type == 'class_assignment'):?>
                    <br />
                    <strong><?php _e('Submission Date:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'quiz_submission_date', true ) ); ?>
                    <?php endif;?>
                </div><!-- .entry-header -->

                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <div class="uni_lms_course_tabs">
                        <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_overview')"><?php _e('Details', 'unilms');?></button>
                        <button class="tablinks" onclick="openCourseSections(event, 'course_contents')"><?php _e('Results', 'unilms');?></button>
                        </div>
                        <div id="course_overview" class="uni_lms_course_tabcontent">
                            <?php the_content(); ?>
                        </div>
                        <div id="course_contents" class="uni_lms_course_tabcontent">
                            <?php
                                $quiz_class = get_post_meta( get_the_ID(), 'quiz_class', true );
                                $quiz_id = get_the_ID();
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
                                $sr_no = 1;
                                ?>
                                <table>
                                    <tr>
                                        <th><?php _e('Sr#', 'unilms');?></th>
                                        <th><?php _e('Name', 'unilms');?></th>
                                        <th><?php _e('Roll No', 'unilms');?></th>
                                        <th><?php _e('Marks', 'unilms');?></th>
                                    </tr>
                                <?php
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    $quiz_marks = get_post_meta( $quiz_id , 'uni_lms_quiz_marks-'.get_the_ID(), true );
                                ?>
                                    <tr>
                                        <td><?php echo esc_html($sr_no); ?></td>
                                        <td><?php echo the_title(); ?></td>
                                        <td><?php echo get_post_meta( get_the_ID(), 'student_reg_no', true );?></td>
                                        <td><?php echo esc_html($quiz_marks);?></td>
                                    </tr>
                                <?php
                                $sr_no += 1;
                                endwhile; 
                                echo '</table>';
                            ?>
                        </div>
                        
                    </div><!-- .entry-content -->
                </div><!-- .entry-content-wrapper -->

            </article><!-- #post-## -->

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>

        <?php endwhile; // End of the loop. ?>

        </main><!-- #main -->
	</div><!-- .row -->
</div><!-- .codoswp-container -->
<?php
get_footer();
