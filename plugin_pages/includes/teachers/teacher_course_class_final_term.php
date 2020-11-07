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
                'value' => 'final_term',
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

	$course_result = get_post_meta( $course_id, 'uni_lms_course_result', true );
	global $user_ID;
	?>
	<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>
	<table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Final Exam Result', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Name-Roll No', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Final Term', 'unilms-pro');?></strong></th>
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
			if($inner_query->have_posts()){
			    while ($inner_query->have_posts()) : $inner_query->the_post();
			        $quiz_id = get_the_ID();
			        $quiz_marks = get_post_meta( $quiz_id , 'uni_lms_quiz_marks-'.$student_id, true );
			        $quiz_max_marks = get_post_meta( $quiz_id , 'quiz_max_marks', true );
					//if ( (current_user_can( 'uni_lms_teacher' ) && is_user_logged_in() && is_author(get_current_user_id())) || current_user_can('administrator') || $course_result == 'yes') {
		?>
					<td><?php echo esc_html($quiz_marks . '/'. $quiz_max_marks); ?><a href="<?php echo get_permalink(); ?>"><?php _e('View Exam', 'unilms-pro');?></a></td>
		<?php
					//}else{
					?>
					<!--<td>NA</td>-->
					<?php
					//}
			    endwhile;
			}else{
				echo '<td></td>';
			}
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
			<tr>
				<td colspan="16">Teacher's Name:                      _______________________________________<br>Signatures:                          _______________________________________<br>Date:                                _______________________________________<br>Incharge Examination Sign and Stamp: _______________________________________</td></tr>
		</tbody>
	</table>
	<?php //global $wp_query;
// }else{
// 	echo 'Cannot access this page directlty';
// }
?>