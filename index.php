<?php 
/*
Plugin Name: EL CULTIVO - funciones
Plugin URI: http://elcultivo.mx
Description: Funciones para el pan de cada día.
Version: 0.2
Author URI: http://elcultivo.mx
*/

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


// Valida de una forma sencilla (¿incompleta?)
// si el string que le pasas es un mail
function es_mail($string){
	$es_mail = false;
	$explode = explode('@', $string);
	if( count($explode)== 2 ){
		$explode_2 = explode('.', $explode[1]);
		$cuantos_exp2 = count($explode_2);
		if( $cuantos_exp2 >1 && $explode_2[$cuantos_exp2-1] != '')
			$es_mail = true;
	}
	return $es_mail;
}

//dale el ID del post
//y un array con los ids de las imágenes a excluir, (si ninguna usar false)
//y te regresará un array con las URL de las imágenes de ese post
function cltvo_todasImgsDelPost($parentId, $size, $exclude=false){
	
	$query_images_args = array(
		'post_parent' => $parentId,
	    'post_type' => 'attachment',
	    'orderby' => 'title',
	    'order' => 'ASC',
	    'post_mime_type' =>'image',
	    'post_status' => 'inherit',
	    'posts_per_page' => -1
	);
	
	if( $exclude && is_array($exclude)){
		$query_images_args['post__not_in'] = $exclude;
	}
	
	$query_images = get_posts( $query_images_args );
	
	if(!$query_images){
		return false;		
	}else{
		$images = array();
		foreach ( $query_images as $image) {
		    $imagesArray = wp_get_attachment_image_src( $image->ID, $size );
		    $images[] = $imagesArray[0];
		}
		return $images;	
	}
}

//dale el ID del post
//y un array con los ids de las imágenes a excluir, (si ninguna usar false)
//y te regresará un array con los IDS de las imágenes de ese post
function cltvo_todosIdsImgsDelPost($parentId, $exclude= false){
	
	$query_images_args = array(
		'post_parent' => $parentId,
	    'post_type' => 'attachment',
	    'orderby' => 'title',
	    'order' => 'ASC',
	    'post_mime_type' =>'image',
	    'post_status' => 'inherit',
	    'posts_per_page' => -1
	);
	
	if( $exclude && is_array($exclude)){
		$query_images_args['post__not_in'] = $exclude;
	}
	
	$query_images = get_posts( $query_images_args );
	$images = array();
	foreach ( $query_images as $image) {
	    $images[] = $image->ID;
	}
	
	return $images;	
}

function cltvo_wpURL_2_path( $url ){
	$path = get_theme_root();
	$path = str_replace('wp-content/themes', '', $path);
	$path = str_replace(home_url('/'), $path, $url);
	return $path;
}
if( !function_exists('cltvo_is_local_h') ){
	function cltvo_is_local_h(){
		if($_SERVER['HTTP_HOST'] == 'localhost:8888'){
			return true;
		}else{
			return false;
		}
	}
}
if( !function_exists('cltvo_print_r') ){
	function cltvo_print_r($var){
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
}
?>