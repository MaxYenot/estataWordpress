<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php
// получаем ID термина на странице термина
$term_id = get_queried_object_id();

// получим ID картинки из метаполя термина
$image_id = get_term_meta( $term_id, '_thumbnail_id', 1 );

// ссылка на полный размер картинки по ID вложения
$image_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
?>
<div class="wrapper" id="wrapper-static-hero">

<div class="container" id="wrapper-static-content" tabindex="-1">

<div class="row">

<div id="text-13" class="footer-widget widget_text widget-count-1 col-md-12">
<div class="textwidget">
<div class="row">
<div class="col-md-3">
<?php
// выводим картинку на экран
echo '<img src="'. $image_url .'" alt="" />';?>
</div>
<div class="col-md-9">
<?php 
if (category_description($term_id)){
echo category_description($term_id);
}else{
	echo "Введите описание города! Администратор -> Недвижимость -> Город";
}
?>
</div>

</div>
</div>
</div><!-- .static-hero-widget -->
</div>

</div>

</div>


<?php $container = get_theme_mod( 'understrap_container_type' );
?>



<div class="wrapper" id="index-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check and opens the primary div -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php // $myquery = new WP_Query( array( 'post_type' => 'estate' ) );
				if ( have_posts() ) : ?>

					<?php /* Start the Loop */ ?>

					<?php while ( have_posts() ) : the_post(); ?>

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







	</div><!-- #content -->

</div><!-- #index-wrapper -->

<?php get_footer(); ?>