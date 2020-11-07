<?php
$course_grad_array = array();

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

$course_grad_array['course_grad_ap'] = $course_grad_ap;
$course_grad_array['course_grad_a'] = $course_grad_a;
$course_grad_array['course_grad_bp'] = $course_grad_bp;
$course_grad_array['course_grad_b'] = $course_grad_b;
$course_grad_array['course_grad_bn'] = $course_grad_bn;
$course_grad_array['course_grad_cp'] = $course_grad_cp;
$course_grad_array['course_grad_c'] = $course_grad_c;
$course_grad_array['course_grad_cn'] = $course_grad_cn;
$course_grad_array['course_grad_d'] = $course_grad_d;
$course_grad_array['course_grad_f'] = $course_grad_f;
?>
<style>
.widefat td, .widefat th {
    border: 1px solid;
}
</style>
    <table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Grad Policy', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Marks Range', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Grad Point', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Letter Grad', 'unilms-pro');?></strong></th>
		    </tr>
		</thead>
		<tbody>
			<tr>
				<td><?php echo $course_grad_ap . ' - 100' ; ?></td>
				<td>4.00</td>
				<td>A+</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_a . ' - ' . $course_grad_ap; ?></td>
				<td>3.70</td>
				<td>A</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_bp . ' - ' . $course_grad_a; ?></td>
				<td>3.30</td>
				<td>B+</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_b . ' - ' . $course_grad_bp; ?></td>
				<td>3.00</td>
				<td>B</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_bn . ' - ' . $course_grad_b; ?></td>
				<td>2.70</td>
				<td>B-</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_cp . ' - ' . $course_grad_bn; ?></td>
				<td>2.30</td>
				<td>C+</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_c . ' - ' . $course_grad_cp; ?></td>
				<td>2.00</td>
				<td>C</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_cn . ' - ' . $course_grad_c; ?></td>
				<td>1.70</td>
				<td>C-</td>
			</tr>
			<tr>
				<td><?php echo $course_grad_d . ' - ' . $course_grad_cn; ?></td>
				<td>1.00</td>
				<td>D</td>
			</tr>
			<tr>
				<td><?php echo 'Below ' . $course_grad_d; ?></td>
				<td>0.00</td>
				<td>F</td>
			</tr>
		</tbody>
	</table>
<?php

?>