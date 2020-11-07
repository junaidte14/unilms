<?php 
//get url of the page using specific shortcode

function uni_lms_get_url_by_shortcode_std($shortcode) {
	global $wpdb;

	$url = '';

	$sql = 'SELECT ID
		FROM ' . $wpdb->posts . '
		WHERE
			post_type = "page"
			AND post_status="publish"
			AND post_content LIKE "%' . $shortcode . '%"';

	if ($id = $wpdb->get_var($sql)) {
		$url = get_permalink($id);
	}

	return $url;
}
?>