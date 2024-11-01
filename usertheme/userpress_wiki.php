<?php
global $blog_id, $wp_query, $wiki, $post, $current_user;
get_header( 'wiki' );
?>


<div class="row">

<!-- Main Content -->
<?php if ( have_posts() ) : ?>

			<?php while ( have_posts() ) : the_post(); ?>

<?php global $post; ?>
<div class="medium-9 columns" id="container">


<div class="row">
<div class="medium-12 columns">
<?php get_template_part( 'featured', 'media' ); ?>

<h2 class="page-title">
<?php if ( class_exists('BuddyPress') ) { ?>
<span class="right" style="font-weight:normal; letter-spacing:0px;">
<?php up546E_bppostsubbutton();  ?>
</span>
<?php }  ?>

<?php the_title(); ?></h2>

<?php if (get_post_meta($post->ID, 'userpress_wiki_subtitle', true) ) { ?>
<h3 class="subtitle">
<?php echo get_post_meta($post->ID, 'userpress_wiki_subtitle', true); ?>
</h3>
<?php } ?>

<div class="userpress_wiki_tabs incsub_wiki_tabs_top">
<?php echo $wiki->tabs(); ?><div class="incsub_wiki_clear"></div></div>

</div>
</div>




<div class="row">
<div class="medium-2 columns post-meta">
<p><strong><i class="fi-calendar"></i> Published</strong>
<br /><?php echo get_the_date(); ?></p>
<p><strong><i class="fi-clock"></i> Last modified</strong>
<br /><?php the_modified_time('F j, Y'); ?> 
<br /><?php the_modified_time('g:i a'); ?></p>		

<?php edit_post_link('WP Editor', '<p><i class="fi-page-edit"></i> ', '</p>'); ?>


<?php

$taxonomies = get_object_taxonomies('userpress_wiki', 'object');

$customtaxheaders = array(
	'userpress_wiki_category' => '<i class="fi-page"></i> Filed Under',
	'userpress_wiki_tag' => '<i class="fi-price-tag"></i> Tags'
	);



foreach ($taxonomies as $tax) {
	if ($tax->public == 0) continue;
	$terms = get_the_terms( $post->ID , $tax->name );
	if ( !empty($terms)) { ?>
		<p><strong>
		<?php if (isset($customtaxheaders[$tax->name])) {
			echo $customtaxheaders[$tax->name]; 
		} else { 
			echo $tax->labels->name; 
		}; ?>
		</strong></p>
		<ul>
		<?php
		foreach ( $terms as $term ) {
			$term_link = get_term_link( $term, $tax->name );
			if( is_wp_error( $term_link ) )
			continue;
			echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
		} ?>
		</ul>
	<?php } 
	
	
}	
?>

</div>

<div class="medium-9 columns left post">
<article id="post-<?php the_ID(); ?>" >




<?php if (class_exists('up546E_build_subnav_toc') AND  up546E_userpress_slug() !== up546E_get_frontpage_uri()) { up546E_build_subnav_toc(); } ?>				

                <?php if ( !post_password_required() ) {

                $revision_id = isset($_REQUEST['revision'])?absint($_REQUEST['revision']):0;
                $left        = isset($_REQUEST['left'])?absint($_REQUEST['left']):0;
                $right       = isset($_REQUEST['right'])?absint($_REQUEST['right']):0;
                $action      = isset($_REQUEST['action'])?$_REQUEST['action']:'view';

                if ($action == 'discussion') {
                   comments_template( '', true );
                } else {
                    echo $wiki->decider(apply_filters('the_content', $post->post_content), $action, $revision_id, $left, $right, false);
                }
                ?>
		<?php } ?>

</article>
</div>
</div>

</div><!-- End Main Content -->

			<?php endwhile; ?>
			
		<?php endif; ?>

<?php get_sidebar('wiki'); ?>
</div>
<!-- End Page -->

<?php get_footer(); ?>


