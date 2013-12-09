<?php
/*
	Plugin Name: Rewrite API Demo
	Description: Playing with the WordPress Rewrite API
	Author: Aaron Graham
 */
 
function ag_add_rewrite_rule() {
	add_rewrite_tag('%referrer%','([^&]+)');

	add_rewrite_rule(
		'^([^/]+)/referal/([^/]+)', 
		'index.php?p=$matches[1]&referrer=$matches[2]',
		'top'
	);

	add_rewrite_rule( 'howdy', 'index.php?p=1', 'top');

	add_rewrite_endpoint('json', EP_ALL );

	flush_rewrite_rules();
}
add_action( 'init', 'ag_add_rewrite_rule');

function ag_content_filter($content) {
	if (get_query_var( 'referrer' )) {
		return $content."<br>referred by:".get_query_var( 'referrer' );
	}
	return $content;
}

add_filter( 'the_content', 'ag_content_filter' );

function ag_template_redirect() {
	global $post;
	switch (get_query_var('json')) {
		case 'verify':
			echo 'enabled';
			exit;
		case 'response':
			$arr = array ('post' => $post, 'comments' => get_comments(array('post_id' => $post->ID)));
			echo json_encode($arr);
			exit;
	}
}
add_action( 'template_redirect', 'ag_template_redirect' );
?>