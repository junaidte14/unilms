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
	$course_mid_term_marks = intval( get_post_meta( $course_id, 'course_mid_term_marks', true ) );
	$course_final_term_marks = intval( get_post_meta( $course_id, 'course_final_term_marks', true ) );

	//echo $course_mid_term_marks;echo $course_final_term_marks;

    $course_quizzes_marks = intval( get_post_meta( $course_id, 'course_quizzes_marks', true ) );
    $course_assignments_marks = intval( get_post_meta( $course_id, 'course_assignments_marks', true ) );
    $course_projects_marks = intval( get_post_meta( $course_id, 'course_projects_marks', true ) );
    $course_lab_marks = intval( get_post_meta( $course_id, 'course_lab_marks', true ) );
    $course_classpart_marks = intval( get_post_meta( $course_id, 'course_classpart_marks', true ) );
    $course_attend_marks = intval( get_post_meta( $course_id, 'course_attend_marks', true ) );

    $course_grad_ap = intval( get_post_meta( $course_id, 'course_grad_ap', true ) );
    $course_grad_a = intval( get_post_meta( $course_id, 'course_grad_a', true ) );
    $course_grad_bp = intval( get_post_meta( $course_id, 'course_grad_bp', true ) );
    $course_grad_b = intval( get_post_meta( $course_id, 'course_grad_b', true ) );
    $course_grad_bn = intval( get_post_meta( $course_id, 'course_grad_bn', true ) );
    $course_grad_cp = intval( get_post_meta( $course_id, 'course_grad_cp', true ) );
    $course_grad_c = intval( get_post_meta( $course_id, 'course_grad_c', true ) );
    $course_grad_cn = intval( get_post_meta( $course_id, 'course_grad_cn', true ) );
    $course_grad_d = intval( get_post_meta( $course_id, 'course_grad_d', true ) );
    $course_grad_f = intval( get_post_meta( $course_id, 'course_grad_f', true ) );

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

	$mid_term_args = array( 
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
                'value' => 'mid_term',
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
	$inner_query_mid_term = new WP_Query($mid_term_args);
	$total_mid_term = $inner_query_mid_term->found_posts;

	//echo 'total mid term for class found: '. $total_mid_term;

	$final_term_args = array( 
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
	$inner_query_final_term = new WP_Query($final_term_args);
	$total_final_term = $inner_query_final_term->found_posts;

	$course_quiz_percentage_marks = ($course_quizzes_marks/100)*$course_sessionals_marks;
	$course_assignment_percentage_marks = ($course_assignments_marks/100)*$course_sessionals_marks;
	$course_project_percentage_marks = ($course_projects_marks/100)*$course_sessionals_marks;
    $course_lab_percentage_marks = ($course_lab_marks/100)*$course_sessionals_marks;
	$course_classpart_percentage_marks = ($course_classpart_marks/100)*$course_sessionals_marks;
	$course_attend_percentage_marks = ($course_attend_marks/100)*$course_sessionals_marks;
	$course_mid_term_percentage_marks = $course_mid_term_marks;
	$course_final_term_percentage_marks = $course_final_term_marks;

	$course_result = get_post_meta( $course_id, 'uni_lms_course_result', true );
	global $user_ID;
    $total_ap = $total_a = $total_bp = $total_b = $total_bn = $total_cp = $total_c = $total_cn = $total_d = $total_f = $total_na = 0;
	?>
	<style>
.widefat td, .widefat th {
    border: 1px solid  #000;
}
</style>
	<table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Complete Result', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Roll No', 'unilms-pro');?></strong></th>
				<th><strong><?php _e('Name', 'unilms-pro');?></strong></th>
		        <th><strong><?php printf(__('Sessionals(out of %s perc)','unilms-pro'), esc_html($course_sessionals_marks));?></strong></th>
		        <th><strong><?php printf(__('Mid Term(out of %s perc)', 'unilms-pro'), esc_html($course_mid_term_marks));?></strong></th>
		        <th><strong><?php printf(__('Final Term(out of %s perc)', 'unilms-pro'), esc_html($course_final_term_marks));?></strong></th>
		        <th><strong><?php _e('Total(out of 100%)', 'unilms-pro');?></strong></th>
				<th><strong><?php _e('Points', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Grad', 'unilms-pro');?></strong></th>
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
			$total_mid_term_marks = $total_mid_term_max_marks = $mid_term_max_marks = $mid_term_final_total = 0;
			$total_final_term_marks = $total_final_term_max_marks = $final_term_max_marks = $final_term_final_total = 0;
			$total_sessionals_marks = 0;
			$total_final_result= 0;
	?>
			<tr>
				<td><?php echo get_post_meta( get_the_ID(), 'student_reg_no', true );?></td>
				<td><?php echo the_title();?></td>
	<?php
			if($activity_quizzes == 'yes'){
		    	while ($inner_query->have_posts()) : $inner_query->the_post();
		        	$quiz_id = get_the_ID();
		        	$quiz_marks = get_post_meta( $quiz_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        	$quiz_max_marks = get_post_meta( $quiz_id , 'quiz_max_marks', true );
		        	$total_quiz_marks += $quiz_marks;
		        	$total_quiz_max_marks += $quiz_max_marks;
		        	$quizzes_final_total = ($total_quiz_marks/$total_quiz_max_marks)*$course_quizzes_marks;
	
		    	endwhile;
			}
	
			if($activity_assignments == 'yes'){
		    while ($inner_query_assignment->have_posts()) : $inner_query_assignment->the_post();
		        $assignment_id = get_the_ID();
		        $assignment_marks = get_post_meta( $assignment_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $assignment_max_marks = get_post_meta( $assignment_id , 'quiz_max_marks', true );
		        $total_assignment_marks += $assignment_marks;
		        $total_assignment_max_marks += $assignment_max_marks;
		        $assignments_final_total = ($total_assignment_marks/$total_assignment_max_marks)*$course_assignments_marks;
	
		    endwhile;
	
			}
	
			if($activity_projects == 'yes'){
		    while ($inner_query_project->have_posts()) : $inner_query_project->the_post();
		        $project_id = get_the_ID();
		        $project_marks = get_post_meta( $project_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $project_max_marks = get_post_meta( $project_id , 'quiz_max_marks', true );
		        $total_project_marks += $project_marks;
		        $total_project_max_marks += $project_max_marks;
		        $projects_final_total = ($total_project_marks/$total_project_max_marks)*$course_projects_marks;
	
		    endwhile;
	
			}
		
			if($activity_lab == 'yes'){
		    while ($inner_query_lab->have_posts()) : $inner_query_lab->the_post();
		        $lab_id = get_the_ID();
		        $lab_marks = get_post_meta( $lab_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $lab_max_marks = get_post_meta( $lab_id , 'quiz_max_marks', true );
		        $total_lab_marks += $lab_marks;
		        $total_lab_max_marks += $lab_max_marks;
		        $lab_final_total = ($total_lab_marks/$total_lab_max_marks)*$course_lab_marks;
	
		    endwhile;
	
			}
	
			if($activity_classpart == 'yes'){
		    while ($inner_query_classpart->have_posts()) : $inner_query_classpart->the_post();
		        $classpart_id = get_the_ID();
		        $classpart_marks = get_post_meta( $classpart_id , 'uni_lms_quiz_marks-'.$student_id, true );
		        $classpart_max_marks = get_post_meta( $classpart_id , 'quiz_max_marks', true );
		        $total_classpart_marks += $classpart_marks;
		        $total_classpart_max_marks += $classpart_max_marks;
		        $classpart_final_total = ($total_classpart_marks/$total_classpart_max_marks)*$course_classpart_marks;
	
		    endwhile;
	
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
			}
	
		$total_sessionals_marks = $quizzes_final_total + $assignments_final_total + $projects_final_total + $lab_final_total + $classpart_final_total + $attend_final_total;
	?>
			<td><?php echo esc_html(ceil($total_sessionals_marks)); ?></td>
			<?php 
			if($inner_query_mid_term->have_posts()){
				//echo 'hello';
				while ($inner_query_mid_term->have_posts()) : $inner_query_mid_term->the_post();
			        $mid_term_id = get_the_ID();
			        $mid_term_marks = get_post_meta( $mid_term_id , 'uni_lms_quiz_marks-'.$student_id, true );
			        $mid_term_max_marks = get_post_meta( $mid_term_id , 'quiz_max_marks', true );
			        $total_mid_term_marks += $mid_term_marks;
			        $total_mid_term_max_marks += $mid_term_max_marks;
			        $mid_term_final_total = ($total_mid_term_marks/$total_mid_term_max_marks) * $course_mid_term_percentage_marks;
				?>
					<td><?php echo esc_html(ceil($mid_term_final_total)) . ' '; ?><!--<a href="<?php //echo get_permalink(); ?>"><?php //_e('View', 'unilms-pro');?></a>--></td>
				<?php
			    endwhile;
			}else{
			?>
					<td><?php echo esc_html(ceil($mid_term_final_total)) . ' '; ?></td>
			<?php
			}
		    if($inner_query_final_term->have_posts()){
			    while ($inner_query_final_term->have_posts()) : $inner_query_final_term->the_post();
			        $final_term_id = get_the_ID();
			        $final_term_marks = get_post_meta( $final_term_id , 'uni_lms_quiz_marks-'.$student_id, true );
			        $final_term_max_marks = get_post_meta( $final_term_id , 'quiz_max_marks', true );
			        $total_final_term_marks += $final_term_marks;
			        $total_final_term_max_marks += $final_term_max_marks;
			        $final_term_final_total = ($total_final_term_marks/$total_final_term_max_marks)*$course_final_term_percentage_marks;
				    if ( (current_user_can( 'uni_lms_teacher' ) && is_user_logged_in() && is_author(get_current_user_id())) || current_user_can('administrator') || $course_result == 'yes') {
				?>
					<td><?php echo esc_html(ceil($final_term_final_total)) . ' '; ?><!--<a href="<?php //echo get_permalink(); ?>"><?php //_e('View', 'unilms-pro');?></a>--></td>
				<?php
					}else{
				?>
					<td>NA</td>
				<?php
					}
			    endwhile;
		    }else{
		    ?>
		    		<td><?php echo esc_html(ceil($final_term_final_total)) . ' '; ?></td>
		    <?php
		    }
		    $total_final_result = ceil($total_sessionals_marks) + ceil($mid_term_final_total) + ceil($final_term_final_total);
		    //$total_final_result = ceil($total_final_result);
		    if($final_term_final_total == 0){
				$total_na++;
			}
			
		    if($total_final_result !=0){
			    if($total_final_result >= $course_grad_ap){
			    	$student_grad = "A+";
					$student_points = '4.00';
					$total_ap++;
			    }elseif ($total_final_result >= $course_grad_a) {
			    	$student_grad = "A";
					$student_points = '3.70';
					$total_a++;
			    }elseif ($total_final_result >= $course_grad_bp) {
			    	$student_grad = "B+";
					$student_points = '3.30';
					$total_bp++;
			    }elseif ($total_final_result >= $course_grad_b) {
			    	$student_grad = "B";
					$student_points = '3.00';
					$total_b++;
			    }elseif ($total_final_result >= $course_grad_bn) {
			    	$student_grad = "B-";
					$student_points = '2.70';
					$total_bn++;
			    }elseif ($total_final_result >= $course_grad_cp) {
			    	$student_grad = "C+";
					$student_points = '2.30';
					$total_cp++;
			    }elseif ($total_final_result >= $course_grad_c) {
			    	$student_grad = "C";
					$student_points = '2.00';
					$total_c++;
			    }elseif ($total_final_result >= $course_grad_cn) {
			    	$student_grad = "C-";
					$student_points = '1.70';
					$total_cn++;
			    }elseif ($total_final_result >= $course_grad_d) {
			    	$student_grad = "D";
					$student_points = '1.00';
					$total_d++;
			    }else{
			    	$student_grad = "F";
					$student_points = '0.00';
					$total_f++;
			    }
			}else{
				$student_grad = "F";
				$student_points = '0.00';
			}
			
			if ( (current_user_can( 'uni_lms_teacher' ) && is_user_logged_in() && is_author(get_current_user_id())) || current_user_can('administrator') || $course_result == 'yes') {
			?>
			<td><?php echo esc_html($total_final_result); ?></td>
			<td><?php echo esc_html($student_points); ?></td>
			<td><?php echo esc_html($student_grad); ?></td>
			<?php 
			}else{
			?>
			<td>NA</td>
			<td>NA</td>
			<td>NA</td>
			<?php
			}	
			?>
		</tr>
	<?php
		endwhile;
		if ( (current_user_can( 'uni_lms_teacher' ) && is_user_logged_in() && is_author(get_current_user_id())) || current_user_can('administrator') || $course_result == 'yes') {
			?>
			<tr>
				<td colspan="4"><?php echo 'Total A+:';?>
				<td colspan="4"><?php echo $total_ap; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total A:';?>
				<td colspan="4"><?php echo $total_a; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total B+:';?>
				<td colspan="4"><?php echo $total_bp; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total B:';?>
				<td colspan="4"><?php echo $total_b; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total B-:';?>
				<td colspan="4"><?php echo $total_bn; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total C+:';?>
				<td colspan="4"><?php echo $total_cp; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total C:';?>
				<td colspan="4"><?php echo $total_c; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total C-:';?>
				<td colspan="4"><?php echo $total_cn; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total D:';?>
				<td colspan="4"><?php echo $total_d; ?>
			</tr>
			<tr>
				<td colspan="4"><?php echo 'Total F:';?>
				<td colspan="4"><?php echo $total_f. '<br>Out of which '. $total_na. ' were not appeared in final exam'; ?>
			</tr>
			<?php 
			}
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