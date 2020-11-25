<?php
/**
 * The template for displaying all single lectures.
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
                    <?php echo esc_html( get_the_title (get_post_meta( get_the_ID(), 'lecture_course', true ) ) ); ?>
                </div><!-- .entry-header -->

                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <?php the_content(); ?>  
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
