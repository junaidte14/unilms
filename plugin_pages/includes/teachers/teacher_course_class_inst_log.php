<?php
// if(isset($_GET['course_id']) && $_GET['course_id'] != '' && isset($_GET['class_id']) && $_GET['class_id'] != ''){
// 	$course_id = $_GET['course_id'];
// 	$class_id = $_GET['class_id'];

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
	$total_class_students = $loop->found_posts;

	$attendance_args = array( 
		'post_type' => 'uni_lms_attendances',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'AND',
		    array(
                'key' => 'attendance_class',
                'value' => $class_id,
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'attendance_course',
                'value' => $course_id,
                'compare' => '=',
                'type' => 'CHAR'       
            )
		)
	);
	$inner_query = new WP_Query($attendance_args);
	$total_attendances = $inner_query->found_posts;

	?>
	<style>
	.widefat td, .widefat th {
	    border: 1px solid;
	}
	</style>
	<table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Instructor Log', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Week', 'unilms-pro');?></strong></th>
				<th><strong><?php _e('Sr. No', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Date', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Lecture', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('No of Students Attended', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Signatures', 'unilms-pro');?></strong></th>
		    </tr>
		</thead>
		<tbody>
	<?php
	if($inner_query->have_posts()){
		$week = 1;
		$sr_no = 1;
		while ($inner_query->have_posts()) : $inner_query->the_post();
			$attend_id = get_the_ID();
			$presents = 0;
	?>
			<tr>
				<td><?php echo esc_html($week);?></td>
				<td><?php echo esc_html($sr_no);?></td>
				<td><?php echo get_post_meta( $attend_id , 'attendance_date', true );?></td>
				<td><?php echo get_the_title( get_post_meta( $attend_id , 'attendance_lecture', true ) );?></td>
	<?php
		    	while ($loop->have_posts()) : $loop->the_post();
		        	$student_id = get_the_ID();
		        	$student_attendance = get_post_meta( $attend_id , 'uni_lms_attendance_student-'.$student_id, true );
		        	if($student_attendance == 'yes'){
		        		$attendance = "Present";
		        		$presents += 1;
		        	}else{
		        		$attendance = "Absent";
		        	}
		    	endwhile;
	?>
					<td><?php echo esc_html($presents . '/' . $total_class_students); ?></td>
					<td></td>
		</tr>
	<?php
		if($sr_no % 2 == 0){
        	$week += 1;
    	}
		$sr_no += 1;
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