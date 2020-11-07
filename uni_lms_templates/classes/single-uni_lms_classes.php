<?php
/**
 * The template for displaying a single class.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php 
                $class_id = get_the_ID();
                $class_title = get_the_title();
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
                <strong><?php _e('Semester:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'class_semester', true ) ); ?>
                <br />
                <strong><?php _e('Session:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'class_session', true ) ); ?>
                <br />
                <strong><?php _e('Fall / Spring:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'class_fall_spring', true ) ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content-wrapper">
                <div class="entry-content">
                    <div class="uni_lms_course_tabs">
                      <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_overview')"><?php _e('Courses', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'class_students')"><?php _e('Students', 'unilms');?></button>
                    </div>
                    <div id="course_overview" class="uni_lms_course_tabcontent">
                        <h3><?php _e('Class Courses', 'unilms');?></h3>
                        <?php 
                        $args = array( 
                                'post_type' => 'uni_lms_courses',
                                'posts_per_page' => -1
                            );
                        $loop = new WP_Query( $args );
                        while ( $loop->have_posts() ) : $loop->the_post();
                            $class_course = get_post_meta( $class_id, 'uni_lms_class_course-'.get_the_ID(), true );
                            $class_teacher = intval(get_post_meta( get_the_ID(), 'course_teacher', true ));
                            //echo $class_teacher;
                            if($class_teacher == 0){
                                $teacher_id = 1;
                            }else{
                                $teacher_id = $class_teacher;
                            }
                            $user = get_user_by( 'id', $teacher_id );
                            if(!empty($user)){
                                if($user->display_name != ''){
                                    $class_teacher = $user->display_name;
                                }else{
                                    $class_teacher = $user->user_login;
                                }
                            }
                            if($class_course == 'yes'){
                            ?>
                            <p><?php echo get_the_title();?> <strong><?php _e('Instructor:', 'unilms');?> </strong><?php echo $class_teacher;?></p>
                            <?php
                            }
                        endwhile;
                        ?>
                    </div>
                    <div id="class_students" class="uni_lms_course_tabcontent">
                        <h3><?php _e('Class Students', 'unilms');?></h3>
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
                            
                            while ( $loop->have_posts() ) : $loop->the_post();
                                
                                $reg_no = get_post_meta( get_the_ID(), 'student_reg_no', true );
                                //echo $student_attendance;
                            ?>
                                <p>
                                    <?php echo the_title() . ' - ' . get_post_meta( get_the_ID(), 'student_reg_no', true );?>
                                    <a href="<?php echo get_home_url(); ?>/uni_lms_students/<?php echo $reg_no;?>" target="_blank"><?php _e('Performance Report', 'unilms');?></a>
                                </p>
                            <?php
                            endwhile; 
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
