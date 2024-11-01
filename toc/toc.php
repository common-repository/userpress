<?php

add_filter( 'the_content', 'up546E_table_of_contents_content_filter', 1, 100 );

function up546E_table_of_contents_content_filter($content = NULL) {
	global $mytoc, $mytoccount;
	$mytoc = array();
	$mytoccount = 0;
	$new_content = preg_replace_callback(
   		'#<h(\d)[^>]*?>(.*?)<[^>]*?/h\d>#i',
		function ($matches) {
			global $mytoccount, $mytoc;
			$mytoc[$mytoccount]['level'] = $matches[1];
			$mytoc[$mytoccount]['name'] = $matches[2];
			$output = '<a name="target-toc-'.$mytoccount.'"></a>'.$matches[0];
			$mytoccount++;
			return $output;
			
		},
   	 	$content
	);
	return $new_content;

}

function up546E_build_subnav_toc($echo = TRUE) {
	global $mytoc;
	if (!isset($mytoc)) {
		global $post;
		up546E_table_of_contents_content_filter($post->post_content);
	}
	if (isset($mytoc) && is_array($mytoc) && !empty($mytoc)) {
		if (count($mytoc) < 2) return;
		$output = '<h3>Contents</h3>';
		$output .= '<ol id="userpress_toc">';
		$close = '';
		$lastlevel = 1;
		foreach ($mytoc as $id => $item) {
			$thislevel = $item['level'];
			if ($thislevel > $lastlevel) {
				$output .= '<ol>';
				$close = '</ol>'.$close;
			} elseif ($thislevel < $lastlevel) {
				$output .= $close;
				$close = '';
			}
			
			$output .= '<li><a href = "#target-toc-'.$id.'">'.$item['name'].'</a>';
			$close = '</li>'.$close;
			$lastlevel = $thislevel;
		}
		$close = '</ol>'.$close;
		$output .= $close;
	} 
	
	if (isset($output)) {
		if ($echo !== TRUE)
			return $output;
		echo $output;
	}
}


// WIDGET

wp_register_sidebar_widget(
		'userpress_wiki_toc',        // your unique widget id
		'Table of Contents',          // widget name
		'up546E_userpresstoc_func',  // callback function
		array(                  // options
			'description' => 'Automatically generated table of contents based on post/page headings.'
		)
	);
	
	
// SHORT CODE

function up546E_userpresstoc_func( $atts ){
	 up546E_build_subnav_toc();
}
add_shortcode( 'userpresstoc', 'up546E_userpresstoc_func' );	