<?php
/**
 * Template Name: Vice Vice Davey
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<link href="/wp-content/themes/twentyfourteen/css/vice-vice-davey.css" rel="stylesheet" type="text/css" />

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>

	<div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">
            <div id="main-image">
                <img src="/images/vice.png" />
            </div>
        </div><!-- #content -->
	</div><!-- #primary -->

</div><!-- #main-content -->

<?php
//get_sidebar();
//get_footer();
