<?php
// if(isset($_GET['course_id']) && $_GET['course_id'] != '' && isset($_GET['class_id']) && $_GET['class_id'] != ''){
// 	$course_id = $_GET['course_id'];
	$activity_quizzes = get_post_meta( $course_id, 'uni_lms_course_sessionals_activities_quizzes', true );
	$activity_assignments = get_post_meta( $course_id, 'uni_lms_course_sessionals_activities_assignments', true );
	$activity_projects = get_post_meta( $course_id, 'uni_lms_course_sessionals_activities_projects', true );
    $activity_lab = get_post_meta( $course_id, 'uni_lms_course_sessionals_activities_lab', true );
	$activity_classpart = get_post_meta( $course_id, 'uni_lms_course_sessionals_activities_classpart', true );
	$activity_attend = get_post_meta( $course_id, 'uni_lms_course_sessionals_activities_attend', true );

	$course_sessionals_marks = intval( get_post_meta( $course_id, 'course_sessionals_marks', true ) );
    $course_quizzes_marks = intval( get_post_meta( $course_id, 'course_quizzes_marks', true ) );
    $course_assignments_marks = intval( get_post_meta( $course_id, 'course_assignments_marks', true ) );
    $course_projects_marks = intval( get_post_meta( $course_id, 'course_projects_marks', true ) );
    $course_lab_marks = intval( get_post_meta( $course_id, 'course_lab_marks', true ) );
    $course_classpart_marks = intval( get_post_meta( $course_id, 'course_classpart_marks', true ) );
    $course_attend_marks = intval( get_post_meta( $course_id, 'course_attend_marks', true ) );
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
                'value' => 'class_quiz',
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'quiz_for_sessionals',
                'value' => 'yes',
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

	$assignment_args = array( 
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
                'key' => 'quiz_for_sessionals',
                'value' => 'yes',
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
	$inner_query_assignment = new WP_Query($assignment_args);
	$total_assignments = $inner_query_assignment->found_posts;

	$project_args = array( 
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
                'value' => 'project',
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'quiz_for_sessionals',
                'value' => 'yes',
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
	$inner_query_project = new WP_Query($project_args);
	$total_projects = $inner_query_project->found_posts;
	
	$lab_args = array( 
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
                'value' => 'lab',
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'quiz_for_sessionals',
                'value' => 'yes',
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
	$inner_query_lab = new WP_Query($lab_args);
	$total_lab = $inner_query_lab->found_posts;
	
	$classpart_args = array( 
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
                'value' => 'class_part',
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'quiz_for_sessionals',
                'value' => 'yes',
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
	$inner_query_classpart = new WP_Query($classpart_args);
	$total_classpart = $inner_query_classpart->found_posts;

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
	$inner_query_attendance = new WP_Query($attendance_args);
	$total_attendances = $inner_query_attendance->found_posts;

	$course_quiz_percentage_marks = ($course_quizzes_marks/100)*$course_sessionals_marks;
	$course_assignment_percentage_marks = ($course_assignments_marks/100)*$course_sessionals_marks;
	$course_project_percentage_marks = ($course_projects_marks/100)*$course_sessionals_marks;
    $course_lab_percentage_marks = ($course_lab_marks/100)*$course_sessionals_marks;
	$course_classpart_percentage_marks = ($course_classpart_marks/100)*$course_sessionals_marks;
	$course_attend_percentage_marks = ($course_attend_marks/100)*$course_sessionals_marks;
	?>
	<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>
<div style="overflow-x:auto;" id="table-overflow">
	<table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Sessional Marks', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Student', 'unilms-pro');?></strong></th>
		        <?php 
		        	if($activity_quizzes == 'yes'){
		        		for ($i=1; $i <= $total_quizzes; $i++) { 
				?>
				<!--<th><strong>Quiz <?php //echo $i; ?></strong></th>-->
				<?php
						}
				?>
				<!--<th><strong><?php _e('Quiz Total', 'unilms-pro');?></strong></th>-->
				<th><strong><?php printf(__('Quiz Total(%s', 'unilms-pro'), esc_html($course_quizzes_marks));?>%)</strong></th>
				<?php
					}
		         
		        	if($activity_assignments == 'yes'){
		        		for ($j=1; $j <= $total_assignments; $j++) { 
				?>
				<!--<th><strong>Assignment <?php //echo $j; ?></strong></th>-->
				<?php
						}
				?>
				<!--<th><strong><?php _e('Assignments Total', 'unilms-pro');?></strong></th>-->
		        <th><strong><?php printf(__('Assignment Total(%s', 'unilms-pro'), esc_html($course_assignments_marks));?>%)</strong></th>
				<?php
					}
		         
		        	if($activity_projects == 'yes'){
		        		for ($k=1; $k <= $total_projects; $k++) { 
				?>
				<!--<th><strong>Project <?php //echo $k; ?></strong></th>-->
				<?php
						}
				?>
				<!--<th><strong><?php _e('Projects Total', 'unilms-pro');?></strong></th>-->
		        <th><strong><?php printf(__('Projects Total(%s', 'unilms-pro'), esc_html($course_projects_marks));?>%)</strong></th>
				<?php
					}
		         
		        	if($activity_lab == 'yes'){
		        		for ($k=1; $k <= $total_lab; $k++) { 
				?>
				<!--<th><strong>Lab <?php //echo $k; ?></strong></th>-->
				<?php
						}
				?>
				<!--<th><strong><?php _e('Lab Total', 'unilms-pro');?></strong></th>-->
		        <th><strong><?php printf(__('Lab Total(%s', 'unilms-pro'), esc_html($course_lab_marks));?>%)</strong></th>
				<?php
					}
		         
		        	if($activity_classpart == 'yes'){
		        		for ($l=1; $l <= $total_classpart; $l++) { 
				?>
				<!--<th><strong>Class Part <?php //echo $l; ?></strong></th>-->
				<?php
						}
				?>
				<!--<th><strong><?php _e('Class Part Total', 'unilms-pro');?></strong></th>-->
		        <th><strong><?php printf(__('Class Part Total(%s', 'unilms-pro'), esc_html($course_classpart_marks));?>%)</strong></th>
				<?php
					}
					if($activity_attend == 'yes'){
				?>
				<!--<th><strong><?php _e('Attendance Total', 'unilms-pro');?></strong></th>-->
		        <th><strong><?php printf(__('Attendance Total(%s', 'unilms-pro'), esc_html($course_attend_marks));?>%)</strong></th>
		        <?php 
		        	}
		        ?>
		        <th><strong><?php printf(__('Sessionals Total(%s', 'unilms-pro'), esc_html($course_sessionals_marks));?>%)</strong></th>
		    </tr>
		</thead>
		<tbody>
	<?php
	if($loop->have_posts()){

		while ($loop->have_posts()) : $loop->the_post();
			$student_id = get_the_ID();
			$total_quiz_marks = $total_quiz_max_marks = $quiz_max_marks = $quizzes_final_total = 0;
			$assignments_final_total = $total_assignment_marks = $assignment_max_marks = $total_assignment_max_marks = 0;
			$total_project_marks = $total_project_max_marks = $project_max_marks = $projects_final_total = 0;
		    $total_lab_marks = $total_lab_max_marks = $lab_max_marks = $lab_final_total = 0;
			$total_classpart_marks = $total_classpart_max_marks = $classpart_max_marks = $classpart_final_total = 0;
			$total_attend_marks = $total_attend_max_marks = $attend_max_marks = $attend_final_total = 0;
			$total_sessionals_marks = 0;
	?>
			<tr>
				<td><?php echo the_title() . ' - ' . get_post_meta( get_the_ID(), 'student_reg_no', true );?></td>
	<?php
			if($activity_quizzes == 'yes'){
		    	while ($inner_query->have_posts()) : $inner_query->the_post();
		        	$quiz_id = get_the_ID();
		        	$quiz_marks = get_post_meta( $quiz_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        	$quiz_max_marks = get_post_meta( $quiz_id , 'quiz_max_marks', true );
		        	$total_quiz_marks += $quiz_marks;
		        	$total_quiz_max_marks += $quiz_max_marks;
		        	$quizzes_final_total = ($total_quiz_marks/$total_quiz_max_marks)*$course_quizzes_marks;
				    //$quizzes_final_total = ceil($quizzes_final_total);
				    $quizzes_final_total = round($quizzes_final_total, 2);
	?>
					<!--<td><?php //echo $quiz_marks . ' '; ?><a href="<?php //echo get_permalink(); ?>">View</a></td>-->
	<?php
		    	endwhile;
	?>
				<!--<td><?php //echo esc_html($total_quiz_marks . '/' . $total_quiz_max_marks); ?></td>-->
				<td><?php echo esc_html($quizzes_final_total); ?></td>
	<?php
			}
	
			if($activity_assignments == 'yes'){
		    while ($inner_query_assignment->have_posts()) : $inner_query_assignment->the_post();
		        $assignment_id = get_the_ID();
		        $assignment_marks = get_post_meta( $assignment_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $assignment_max_marks = get_post_meta( $assignment_id , 'quiz_max_marks', true );
		        $total_assignment_marks += $assignment_marks;
		        $total_assignment_max_marks += $assignment_max_marks;
		        $assignments_final_total = ($total_assignment_marks/$total_assignment_max_marks)*$course_assignments_marks;
				//$assignments_final_total = ceil($assignments_final_total);
				$assignments_final_total = round($assignments_final_total, 2);
	?>
				<!--<td><?php //echo $assignment_marks . ' '; ?><a href="<?php //echo get_permalink(); ?>">View</a></td>-->
	<?php
		    endwhile;
	?>
				<!--<td><?php //echo esc_html($total_assignment_marks . '/' . $total_assignment_max_marks); ?></td>-->
				<td><?php echo esc_html($assignments_final_total); ?></td>
	<?php
			}
	
			if($activity_projects == 'yes'){
		    while ($inner_query_project->have_posts()) : $inner_query_project->the_post();
		        $project_id = get_the_ID();
		        $project_marks = get_post_meta( $project_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $project_max_marks = get_post_meta( $project_id , 'quiz_max_marks', true );
		        $total_project_marks += $project_marks;
		        $total_project_max_marks += $project_max_marks;
		        $projects_final_total = ($total_project_marks/$total_project_max_marks)*$course_projects_marks;
				//$projects_final_total = ceil($projects_final_total);
				$projects_final_total = round($projects_final_total, 2);
	?>
				<!--<td><?php //echo $project_marks . ' '; ?><a href="<?php //echo get_permalink(); ?>">View</a></td>-->
	<?php
		    endwhile;
	?>
				<!--<td><?php //echo esc_html($total_project_marks . '/' . $total_project_max_marks); ?></td>-->
				<td><?php echo esc_html($projects_final_total); ?></td>
	<?php
			}
		
			if($activity_lab == 'yes'){
		    while ($inner_query_lab->have_posts()) : $inner_query_lab->the_post();
		        $lab_id = get_the_ID();
		        $lab_marks = get_post_meta( $lab_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $lab_max_marks = get_post_meta( $lab_id , 'quiz_max_marks', true );
		        $total_lab_marks += $lab_marks;
		        $total_lab_max_marks += $lab_max_marks;
		        $lab_final_total = ($total_lab_marks/$total_lab_max_marks)*$course_lab_marks;
				//$lab_final_total = ceil($lab_final_total);
				$lab_final_total = round($lab_final_total, 2);
	?>
				<!--<td><?php //echo $lab_marks . ' '; ?><a href="<?php //echo get_permalink(); ?>">View</a></td>-->
	<?php
		    endwhile;
	?>
				<!--<td><?php //echo esc_html($total_lab_marks . '/' . $total_lab_max_marks); ?></td>-->
				<td><?php echo esc_html($lab_final_total); ?></td>
	<?php
			}
		
			if($activity_classpart == 'yes'){
		    while ($inner_query_classpart->have_posts()) : $inner_query_classpart->the_post();
		        $classpart_id = get_the_ID();
		        $classpart_marks = get_post_meta( $classpart_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $classpart_max_marks = get_post_meta( $classpart_id , 'quiz_max_marks', true );
		        $total_classpart_marks += $classpart_marks;
		        $total_classpart_max_marks += $classpart_max_marks;
		        $classpart_final_total = ($total_classpart_marks/$total_classpart_max_marks)*$course_classpart_marks;
				//$classpart_final_total = ceil($classpart_final_total);
				$classpart_final_total = round($classpart_final_total, 2);
	?>
				<!--<td><?php //echo $classpart_marks . ' '; ?><a href="<?php //echo get_permalink(); ?>">View</a></td>-->
	<?php
		    endwhile;
	?>
				<!--<td><?php //echo esc_html($total_classpart_marks . '/' . $total_classpart_max_marks); ?></td>-->
				<td><?php echo esc_html($classpart_final_total); ?></td>
	<?php
			}

			if($activity_attend == 'yes'){
				$presents = 0;
		    	while ($inner_query_attendance->have_posts()) : $inner_query_attendance->the_post();
		        	$attendance_id = get_the_ID();
		        	$student_attendance = get_post_meta( $attendance_id , 'uni_lms_attendance_student-'.$student_id, true );
		        	if($student_attendance == 'yes'){
		        		$attendance = "Present";
		        		$presents += 1;
		        	}else{
		        		$attendance = "Absent";
		        	}
		    	endwhile;
		    	$attend_final_total = ($presents/$total_attendances)*$course_attend_marks;
				//$attend_final_total = ceil($attend_final_total);
				$attend_final_total = round($attend_final_total, 2);
			?>
				<!--<td><?php //echo esc_html($presents) . '/' . esc_html($total_attendances); ?></td>-->
				<td><?php echo esc_html($attend_final_total); ?></td>
		<?php
			}
		$total_sessionals_marks = $quizzes_final_total + $assignments_final_total + $projects_final_total + $lab_final_total + $classpart_final_total + $attend_final_total;
		$total_sessionals_marks = ceil($total_sessionals_marks);
	?>
			<td><?php echo esc_html($total_sessionals_marks); ?></td>
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
</div>
	<?php //global $wp_query;
// }else{
// 	echo 'Cannot access this page directlty';
// }
?>