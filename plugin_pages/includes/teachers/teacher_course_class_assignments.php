<?php
if(isset($student_reg_no) && $student_reg_no != ""){
	$args = array( 
		'post_type' => 'uni_lms_students',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation' => 'AND',
		    array(
                'key' => 'student_class',
                'value' => $class_id,
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'student_reg_no',
                'value' => $student_reg_no,
                'compare' => '=',
                'type' => 'CHAR'       
            )
		)
	);
}else{
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
}

	$loop = new WP_Query( $args );

	$quiz_args = array( 
		'post_type' => 'uni_lms_quizzes',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'AND',
		    array(
                'key' => 'quiz_class',
                'value' => $class_id,
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'quiz_type',
                'value' => 'class_assignment',
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'quiz_course',
                'value' => $course_id,
                'compare' => '=',
                'type' => 'CHAR'       
            )
		)
	);
	$inner_query = new WP_Query($quiz_args);
	$total_quizzes = $inner_query->found_posts;
	?>
	<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>
	<table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Assignments Record', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Name-Roll No', 'unilms-pro');?></strong></th>
		        <?php 
		        	for ($i=1; $i <= $total_quizzes; $i++) { 
				?>
						<th><strong><?php printf(__('Assignment %s', 'unilms-pro'), $i);?></strong></th>
				<?php
					}
		        ?>
		    </tr>
		</thead>
		<tbody>
	<?php
	if($loop->have_posts()){

		while ($loop->have_posts()) : $loop->the_post();
			$student_id = get_the_ID();
	?>
			<tr>
				<td><?php echo the_title() . ' - ' . get_post_meta( get_the_ID(), 'student_reg_no', true );?></td>
	<?php
		    while ($inner_query->have_posts()) : $inner_query->the_post();
		        $quiz_id = get_the_ID();
		        $quiz_marks = get_post_meta( $quiz_id , 'uni_lms_quiz_marks-'.$student_id, true );
	?>
				<td><?php echo esc_html($quiz_marks) . ' '; ?><a href="<?php echo get_permalink(); ?>">View Assignment</a></td>
	<?php
		    endwhile;
	?>
			</tr>
	<?php
		endwhile;

	}else{
	?>
			<tr><td colspan="16"><?php _e('Sorry no data to show', 'unilms-pro');?></td></tr>
	<?php
	}
	?>
		</tbody>
	</table>
	<?php //global $wp_query;
// }else{
// 	echo 'Cannot access this page directlty';
// }
?>