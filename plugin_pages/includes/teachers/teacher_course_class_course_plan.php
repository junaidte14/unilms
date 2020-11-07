<?php
// if(isset($_GET['course_id']) && $_GET['course_id'] != '' && isset($_GET['class_id']) && $_GET['class_id'] != ''){
// 	$course_id = $_GET['course_id'];
// 	$class_id = $_GET['class_id'];

	$repeatable_fields_unilms_coursecont = get_post_meta($course_id, 'repeatable_fields_unilms_coursecont', true);
    
?>
<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>
<table class="widefat">
    <thead>
		<tr><td colspan="200" style="text-align: center;"><?php _e('Weekly Plan', 'unilms');?></td></tr>
	    <tr>
	        <th><strong><?php _e('Week', 'unilms');?></strong></th>
	        <th><strong><?php _e('Lecture', 'unilms');?></strong></th>
	        <th><strong><?php _e('Topics', 'unilms');?></strong></th>
	        <th><strong><?php _e('Activity', 'unilms');?></strong></th>
	    </tr>
	</thead>
	<tbody>
<?php
	$week = 1;
	$i = 1;
    if ( $repeatable_fields_unilms_coursecont ){
        foreach ( $repeatable_fields_unilms_coursecont as $field ) {
?>
			<tr>
				<td><?php echo $week; ?></td>
				<td><?php echo $i; ?></td>
				<td>
					<?php if(array_key_exists('unilms_coursecont_lecture', $field) && $field['unilms_coursecont_lecture'] != ''): ?>
					<?php echo esc_html(get_the_title($field['unilms_coursecont_lecture'])) . ': ';?>
					<?php 
					$lecture_topics = get_post_meta( $field['unilms_coursecont_lecture'], 'lecture_topics', true );
					echo esc_html($lecture_topics);
					?>
					<?php endif;?>
				</td>
				<td>
					<?php if(array_key_exists('unilms_coursecont_quiz', $field) && $field['unilms_coursecont_quiz'] != ''): ?>
					<?php echo esc_html(get_the_title($field['unilms_coursecont_quiz']));?>
					<?php endif;?><br>
					<?php if(array_key_exists('unilms_coursecont_assign', $field) && $field['unilms_coursecont_assign'] != ''): ?>
					<?php echo esc_html(get_the_title($field['unilms_coursecont_assign']));?>
					<?php endif;?>
				</td>
			</tr>     
<?php
			if($i % 2 == 0){
	        	$week += 1;
	    	}
	    	$i++;
        }
    }
?>
	</tbody>
</table>
<?php
//}
?>