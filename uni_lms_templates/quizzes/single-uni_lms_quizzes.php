<?php
/**
 * The template for displaying all single quizzes.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>
        <?php $quiz_type = get_post_meta( get_the_ID(), 'quiz_type', true );?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
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
            </header><!-- .entry-header -->

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
                        <h3><?php _e('Results', 'unilms');?></h3>
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
                                //echo $student_attendance;
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
</div><!-- #primary -->
<?php get_sidebar(); ?>

<?php get_footer(); ?>
