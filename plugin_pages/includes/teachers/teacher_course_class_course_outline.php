<?php
// if(isset($_GET['course_id']) && $_GET['course_id'] != '' && isset($_GET['class_id']) && $_GET['class_id'] != ''){
// 	$course_id = $_GET['course_id'];
// 	$class_id = $_GET['class_id'];

	$course_code = esc_html( get_post_meta( $course_id, 'course_code', true ) );
    $credit_hours = intval( get_post_meta( $course_id, 'credit_hours', true ) );
    $course_class = intval( get_post_meta( $course_id, 'course_class', true ) );
    $course_duration = intval( get_post_meta( $course_id, 'course_duration', true ) );
    $course_lecture_duration = get_post_meta( $course_id, 'course_lecture_duration', true );
    $course_pre_requisite = get_post_meta( $course_id, 'course_pre_requisite', true );
    $course_aims_obj = get_post_meta( $course_id, 'course_aims_obj', true );
    $course_learning_outcomes = get_post_meta( $course_id, 'course_learning_outcomes', true );
    $course_txt_books_ref = get_post_meta( $course_id, 'course_txt_books_ref', true );
    $course_tools_soft = get_post_meta( $course_id, 'course_tools_soft', true );
    $course_lectures_per_week = intval( get_post_meta( $course_id, 'course_lectures_per_week', true ) );
?>
<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>
    <table class="widefat">
		<thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Course Details', 'unilms-pro');?></td></tr>
		</thead>
		<tbody>
			<tr>
				<td><?php _e('Course Title', 'unilms-pro');?></td>
				<td><?php echo get_the_title($course_id);?></td>
			</tr>
			<tr>
				<td><?php _e('Course Code', 'unilms-pro');?></td>
				<td><?php echo $course_code;?></td>
			</tr>
			<tr>
				<td><?php _e('Credit Hours', 'unilms-pro');?></td>
				<td><?php echo $credit_hours;?></td>
			</tr>
			<tr>
				<td><?php _e('Course Duration (Weeks)', 'unilms-pro');?></td>
				<td><?php echo $course_duration;?></td>
			</tr>
			<tr>
				<td><?php _e('Lectures (Per Week)', 'unilms-pro');?></td>
				<td><?php echo $course_lectures_per_week;?></td>
			</tr>
			<tr>
				<td><?php _e('Lecture Duration (Hours)', 'unilms-pro');?></td>
				<td><?php echo $course_lecture_duration;?></td>
			</tr>
			<tr>
				<td><?php _e('Pre-Requisite', 'unilms-pro');?></td>
				<td><?php echo $course_pre_requisite;?></td>
			</tr>
			<tr>
				<td><?php _e('Aims & Objectives', 'unilms-pro');?></td>
				<td><?php echo $course_aims_obj;?></td>
			</tr>
			<tr>
				<td><?php _e('Learning Outcome', 'unilms-pro');?></td>
				<td><?php echo $course_learning_outcomes;?></td>
			</tr>
			<tr>
				<td><?php _e('Text Books & Reference Material', 'unilms-pro');?></td>
				<td><?php echo $course_txt_books_ref;?></td>
			</tr>
			<tr>
				<td><?php _e('Tools / Softwares', 'unilms-pro');?></td>
				<td><?php echo $course_tools_soft;?></td>
			</tr>
			
		</tbody>
	</table>
<?php
//}
?>