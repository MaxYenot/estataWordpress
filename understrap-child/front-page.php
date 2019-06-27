<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package understrap
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$container = get_theme_mod( 'understrap_container_type' );
?>

<?php if ( is_front_page() && is_home() ) : ?>
	<?php get_template_part( 'global-templates/hero' ); ?>
<?php endif; ?>

<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php $myquery = new WP_Query( array( 'post_type' => 'estate' ) );
				if ( $myquery->have_posts() ) : ?>

					<?php /* Start the Loop */ ?>

					<?php while ( $myquery->have_posts() ) : $myquery->the_post(); ?>

						<?php

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'views/frpage-listings', 'custom_type=estate' );
/*echo get_the_title();*/

						?>

					<?php endwhile; ?>

				<?php else : ?>

					<?php get_template_part( 'loop-templates/content', 'none' ); ?>

				<?php endif; ?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->





<section class="our-webcoderskull padding-lg">
  <div class="container">
    <div class="row heading heading-icon">
        <h2>Объявления по городам</h2>
    </div>

<?php 

$terms = get_terms('cities',  array("hide_empty" => false) );
if($terms){
	echo '<ul class="row">';
foreach ($terms as $term){
		echo '<li class="col-12 col-md-6 col-lg-3">';
		$termLink = get_term_link($term->term_id, $term->taxonomy); #получаем ссылку на эту таксономию
		$termImageID = get_term_meta( $term->term_id, '_thumbnail_id', 1 ); #получаем id картинки из метаполя термина
		$termImageUrl = wp_get_attachment_image_url( $termImageID, 'thumbnail' ); #получаем ссылку на картинку по ID вложения

		/*echo $termLink;*/
		echo '<a href="' . $termLink . '">';
		echo "<div class=\"cnt-block equal-hight\" >";
		echo "<figure>";
		echo "<img class=\"img-responsive\" src=\"" . $termImageUrl . "\">";
		echo "</figure>";
		echo "<h3>";
		echo $term->name;
		echo "</h3>";
		echo "</div>";
		echo "</a>";
		echo "</li>";
		
	}
	echo '</ul>';
}
?>

  </div>
</section>






	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>
