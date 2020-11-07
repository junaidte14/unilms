<?php get_header(); ?>
<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
    <?php if ( have_posts() ) : ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="page-header">
                <h1 class="page-title"><?php _e('Students', 'unilms');?></h1>
            </header>
            <table>
                <!-- Display table headers -->
                <tr>
                    <th><strong><?php _e('Name', 'unilms');?></strong></th>
                    <th><strong><?php _e('Reg No', 'unilms');?></strong></th>
                    <th><strong><?php _e('Class', 'unilms');?></strong></th>
                </tr>
                <!-- Start the Loop -->
                <?php while ( have_posts() ) : the_post(); ?>
                    <!-- Display review title and author -->
                    <tr>
                        <td style="text-align: center;"><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?></a></td>
                        <td style="text-align: center;"><?php echo esc_html(  get_post_meta( get_the_ID(), 'student_reg_no', true )  ); ?></td>
                        <td style="text-align: center;"><?php echo esc_html( get_the_title ( get_post_meta( get_the_ID(), 'student_class', true ) ) ); ?></td>
                    </tr>
                <?php endwhile; ?>
     
                <!-- Display page navigation -->
     
            </table>
            <?php global $wp_query;
            if ( isset( $wp_query->max_num_pages ) && $wp_query->max_num_pages > 1 ) { ?>
                <nav style="overflow: hidden;">
                    <div class="nav-previous alignleft"><?php next_posts_link( '<span class="meta-nav">&larr;</span> Older Courses', $wp_query->max_num_pages); ?></div>
                    <div class="nav-next alignright"><?php previous_posts_link( 'Newer Courses <span class= "meta-nav">&rarr;</span>' ); ?></div>
                </nav>
            <?php };?>
        </article>
        <?php
    endif; ?>
    </main>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>