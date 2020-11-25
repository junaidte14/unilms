<?php get_header(); ?>
<div class="codoswp-container">
	<div class="row">
		<main id="primary" class="site-main col-sm-12 col-md-12">
        <?php if ( have_posts() ) : ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header alignwide">
                    <div class="codoswp-container">
                        <div class="page-title">
                            <h1><?php _e('Lectures', 'unilms');?></h1>
                        </div>
                    </div>
                </header>
                <table>
                    <tr>
                        <th><strong><?php _e('Title', 'unilms');?></strong></th>
                        <th><strong><?php _e('Course', 'unilms');?></strong></th>
                    </tr>
                    <?php while ( have_posts() ) : the_post(); ?>
                        <tr>
                            <td><a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?></a></td>
                            <td><?php echo esc_html( get_the_title ( get_post_meta( get_the_ID(), 'lecture_course', true ) ) ); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
                <?php global $wp_query;
                if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) { ?>
                    <nav style="overflow: hidden;">
                        <div class="nav-previous alignleft"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older Lectures', $wp_query->max_num_pages); ?></div>
                        <div class="nav-next alignright"><?php previous_posts_link( 'Newer Lectures <span class= "meta-nav">&rarr;</span>' ); ?></div>
                    </nav>
                <?php };?>
            </article>
            <?php
        endif; ?>
        </main><!-- #main -->
	</div><!-- .row -->
</div><!-- .codoswp-container -->
<?php
get_footer();
