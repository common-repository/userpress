<?php 




/**
 * 
 * Alters the UserPress archive loop
 * @uses pre_get_posts hook
*/

function userpress_archive_filter( $query ) {
	
// Recently Created
	if (isset($_GET["view"]) && $_GET["view"] == 'created') {

// Recently Updated
	} elseif (isset($_GET["view"]) && $_GET["view"] == 'recently_modified') {
        $query->set( 'orderby', 'modified' );
        
// Recently Discussed
	} elseif (isset($_GET["view"]) && $_GET["view"] == 'recently_discussed') { 
        $query->set( 'orderby_last_comment', 'true' );

// Most Discussed    
	} elseif (isset($_GET["view"]) && $_GET["view"] == 'most_discussed') { 
        $query->set( 'orderby', 'comment_count' );
        $query->set( 'order', 'DESC' );       

// Alphabetical Order
	} elseif (isset($_GET["view"]) && $_GET["view"] == 'alpha') { 
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' ); 
        
// Create New Wiki -- Yes. This is an ugly hack. But it works.
	} elseif (isset($_GET["action"]) && $_GET["action"] == 'create') {
		if ($query->is_main_query()) $query->set( 'posts_per_page', 1 );
	}
	
}


add_action( 'pre_get_posts', 'userpress_archive_filter' );




// Create New Wiki


if (isset($_GET["action"]) && $_GET["action"] == 'create') {

	add_action( 'init', 'up546E_cannot_create');

	function up546E_cannot_create() {
		if (!up546E_user_can_publish()) {
			header( 'Location: '.get_post_type_archive_link('userpress_wiki'));
			exit();
		}
	}

	add_action( 'template_redirect', 'upw_create_new_wiki' );
		function upw_create_new_wiki()
		{
   			 include( get_template_directory() . '/page.php' );
   			 exit();
		}


	add_filter( 'the_content', 'upw_insert_wiki_form' );
		function upw_insert_wiki_form($content)
		{
		global $blog_id, $wp_query, $wiki, $post, $current_user;
		$content = $wiki->get_new_wiki_form();
		return $content;
		}	
		
	add_filter( 'the_title', 'upw_new_wiki_title', 10, 2 );
		function upw_new_wiki_title($title, $id)
		{
		global $title_CNW_count;
		if ($id == get_the_id() && $title_CNW_count != 1) {
			$title = "Create New Wiki";
			$title_CNW_count = 1;
		}
		return $title;
		}	
	add_action( 'the_post', 'upw_new_wiki_post_intercept');
		function upw_new_wiki_post_intercept($post) {
			$post->ID = '-1';
			//print_r($post);
		}
}

if (isset($_GET["action"]) && ($_GET["action"] == 'edit' || $_GET["action"] == 'create')) {
	
	add_filter( 'the_content', 'up546E_remove_all_shortcodes_from_content', 0 );
	add_filter( 'the_content', 'up546E_reactivate_all_shortcodes', 99 );


}

function up546E_remove_all_shortcodes_from_content( $content ) {

	global $shortcode_tags, $remember_shortcode_tags;
	
	$remember_shortcode_tags = $shortcode_tags;

	/* Loop through the shortcodes and remove them. */
	foreach ( $shortcode_tags as $shortcode_tag => $function)
		remove_shortcode( $shortcode_tag );

	/* Return the post content. */
	return $content;
}


function up546E_reactivate_all_shortcodes( $content ) {

	global $remember_shortcode_tags;
	
	foreach ( $remember_shortcode_tags as $shortcode_tag => $function)
		add_shortcode( $shortcode_tag, $function );


	return $content;
}
?>