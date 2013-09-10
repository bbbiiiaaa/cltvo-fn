<?php 

// Forma rápida de hacer el query de un post
// Sin importar de qué Post Type sea
// Pásale un id de post y te regresa 
// un array con un sólo post

function cltvo_toma_1post($post_id){
	$post_types = get_post_types();
	$exclude_tp = array('attachment', 'revision', 'nav_menu_item');
	foreach ($exclude_tp as $tp) { unset($post_types[$tp]); }

	$args = array(
		'posts_per_page' => 1,
		'include' => $post_id,
		'post_type' => $post_types
	);
	$post = get_posts($args);

	return $post;
}
?>