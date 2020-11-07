<?php
/**
 * The template for displaying all single course.
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
                <strong><?php _e('Course Code:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'course_code', true ) ); ?>
                <br />
                <strong><?php _e('Class:', 'unilms');?> </strong>
                <a href="<?php echo get_permalink(get_post_meta( get_the_ID(), 'course_class', true ));?>" target="_blank">
                <?php echo esc_html( get_the_title ( get_post_meta( get_the_ID(), 'course_class', true ) ) ); ?>
                </a>
                <br />
                <strong><?php _e('Credit Hours:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'credit_hours', true ) ); ?>
                <br />
                <strong><?php _e('Course Duration (Weeks):', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'course_duration', true ) ); ?>
                <br />
                <strong><?php _e('Lectures Per Week:', 'unilms');?> </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'course_lectures_per_week', true ) ); ?>
            </header><!-- .entry-header -->

            <div class="entry-content-wrapper">
                <div class="entry-content">
                    <div class="uni_lms_course_tabs">
                      <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_overview')"><?php _e('Overview', 'unilms');?></button>
                      <button class="tablinks" onclick="openCourseSections(event, 'course_contents')"><?php _e('Contents', 'unilms');?></button>
                      </div>
                    <div id="course_overview" class="uni_lms_course_tabcontent">
                        <h3><?php _e('Course Overview', 'unilms');?></h3>
                        <?php the_content(); ?>
                    </div>
                    <div id="course_contents" class="uni_lms_course_tabcontent">
                        <h3><?php _e('Course Contents', 'unilms');?></h3>
                        <?php 
                            $repeatable_fields_unilms_coursecont = get_post_meta(get_the_ID(), 'repeatable_fields_unilms_coursecont', true);
    
                            if ( $repeatable_fields_unilms_coursecont ){
                                $i = 1;
                                foreach ( $repeatable_fields_unilms_coursecont as $field ) {
                        ?>     
                                <h5><?php _e('Day ', 'unilms'); echo '-'. $i; ?></h5> 
                                <?php if(array_key_exists('unilms_coursecont_lecture', $field) && $field['unilms_coursecont_lecture'] != ''): ?>
                                <strong><?php _e('Lecture: ', 'unilms');?></strong>
                                <span><a href="<?php the_permalink($field['unilms_coursecont_lecture']); ?>"><?php echo esc_html(get_the_title($field['unilms_coursecont_lecture']));?></a></span><br>
                                <?php endif;?>
                                <?php if(array_key_exists('unilms_coursecont_assign', $field) && $field['unilms_coursecont_assign'] != ''): ?>
                                <strong><?php _e('Assignment: ', 'unilms');?></strong>
                                <span><a href="<?php the_permalink($field['unilms_coursecont_assign']); ?>"><?php echo esc_html(get_the_title($field['unilms_coursecont_assign']));?></a></span><br>
                                <?php endif;?>
                                <?php if(array_key_exists('unilms_coursecont_quiz', $field) && $field['unilms_coursecont_quiz'] != ''): ?>
                                <strong><?php _e('Quiz: ', 'unilms');?></strong>
                                <span><a href="<?php the_permalink($field['unilms_coursecont_quiz']); ?>"><?php echo esc_html(get_the_title($field['unilms_coursecont_quiz']));?></a></span><br>
                                <?php endif;?>
                                <br>
                        <?php
                                $i++;
                                }
                            }
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
