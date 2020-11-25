<?php
/**
 * The template for displaying single attendance.
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
                    <strong><?php _e('Course:', 'unilms');?> </strong>
                    <?php echo esc_html( get_the_title (get_post_meta( get_the_ID(), 'attendance_course', true ) ) ); ?>
                    </br>
                    <strong><?php _e('Class:', 'unilms');?> </strong>
                    <?php echo esc_html( get_the_title (get_post_meta( get_the_ID(), 'attendance_class', true ) ) ); ?>
                    </br>
                    <strong><?php _e('Date:', 'unilms');?> </strong>
                    <?php echo esc_html( get_post_meta( get_the_ID(), 'attendance_date', true ) ); ?>
                </div><!-- .entry-header -->

                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <?php 
                        $attendance_class = esc_html (get_post_meta( $attendance_id, 'attendance_class', true ));
                        ?>
                        <table>
                            <tr>
                                <th style="text-align:left;"><?php _e('Student', 'unilms');?></th>
                                <th style="text-align:left;"><?php _e('Attendance', 'unilms');?></th>
                            </tr>
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
                                            'value' => $attendance_class,
                                            'compare' => '=',
                                            'type' => 'CHAR'       
                                        )
                                    )
                                );
                                $loop = new WP_Query( $args );
                                $student_ids = '';
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    $student_attendance = get_post_meta( $attendance_id, 'uni_lms_attendance_student-'.get_the_ID(), true );
                                    echo '<tr>';
                                    //echo $student_attendance;
                                    if($student_attendance == 'yes'){
                                        echo '<td>';
                                        echo the_title() . ' - ' . esc_html(get_post_meta( get_the_ID(), 'student_reg_no', true ));
                                        echo '</td>';
                                        echo '<td>'. __('Present', 'unilms'). '</td>';
                                
                                    }else{
                                        echo '<td>';
                                        echo the_title() . ' - ' . esc_html(get_post_meta( get_the_ID(), 'student_reg_no', true ));
                                        echo '</td>';
                                        echo '<td>' . __('Absent', 'unilms'). '</td>';
                                    }
                                    echo '</tr>';
                                endwhile; 
                            ?>
                        </table>
                        
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
