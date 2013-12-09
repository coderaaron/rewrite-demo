<?php
/*
  Plugin Name: Rewrite API Demo
  Description: Playing with the WordPress Rewrite API
  Author: Aaron Graham
 */
 
function ag_add_rewrite_rule() {
	add_rewrite_rule( 'howdy', 'index.php?&p=1', 'top');
	flush_rewrite_rules();
}
add_action( 'init', 'ag_add_rewrite_rule');

?>