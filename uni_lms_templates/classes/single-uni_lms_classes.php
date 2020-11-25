<?php
/**
 * The template for displaying a single class.
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
                    $class_id = get_the_ID();
                    $class_title = get_the_title();
                    ?>
                    <div class="course-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <strong><?php _e('Semester:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'class_semester', true ) ); ?>
                    <br />
                    <strong><?php _e('Session:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'class_session', true ) ); ?>
                    <br />
                    <strong><?php _e('Fall / Spring:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'class_fall_spring', true ) ); ?>
                </div><!-- .entry-header -->

                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <div class="uni_lms_course_tabs">
                        <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_overview')"><?php _e('Courses', 'unilms');?></button>
                        <button class="tablinks" onclick="openCourseSections(event, 'class_students')"><?php _e('Students', 'unilms');?></button>
                        </div>
                        <div id="course_overview" class="uni_lms_course_tabcontent">
                            <ol>
                            <?php 
                            $args = array( 
                                'post_type' => 'uni_lms_courses',
                                'posts_per_page' => -1
                            );
                            $loop = new WP_Query( $args );
                            while ( $loop->have_posts() ) : $loop->the_post();
                                $class_course = get_post_meta( $class_id, 'uni_lms_class_course-'.get_the_ID(), true );
                                if($class_course == 'yes'){
                                ?>
                                <li>
                                    <a href="<?php the_permalink(get_the_ID()); ?>" target="_blank"><?php echo get_the_title();?></a>
                                </li>
                                <?php
                                }
                            endwhile;
                            ?>
                            </ol>
                        </div>
                        <div id="class_students" class="uni_lms_course_tabcontent">
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
                                        'value' => $class_id,
                                        'compare' => '=',
                                        'type' => 'CHAR'       
                                    )
                                )
                            );
                            $loop = new WP_Query( $args );
                            if ( $loop->have_posts() ) :
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    $reg_no = get_post_meta( get_the_ID(), 'student_reg_no', true );
                                    ?>
                                    <p>
                                        <?php echo the_title() . ' - ' . get_post_meta( get_the_ID(), 'student_reg_no', true );?>
                                        <a href="<?php echo get_home_url(); ?>/uni_lms_students/<?php echo $reg_no;?>" target="_blank"><?php _e('Performance Report', 'unilms');?></a>
                                    </p>
                                    <?php
                                endwhile; 
                            else: ?>
                                <p><?php _e('Nothing found!', 'unilms');?></p>
                            <?php endif; ?>
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
