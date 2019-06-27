<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>


<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">
  <div class="row ">
  		<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
          
          	<?php while ( have_posts() ) : the_post(); ?>
          	
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
          <div class="col col-md-12 col-lg-12 col-xl-10">
      <ol class="breadcrumb" style="margin-top: 20px;">
          <li class="breadcrumb-item"><a href="/">Недвижимость</a></li>
          <?php $cur_terms = get_the_terms( $post->ID, 'cities' );
    if( is_array( $cur_terms ) ){
        foreach( $cur_terms as $cur_term ){
            echo '<li class="breadcrumb-item"><a href="'. get_term_link( (int)$cur_term->term_id, $cur_term->taxonomy ) .'">'. $cur_term->name .'</a></li>';
        }
    }
?>
          
          <li class="breadcrumb-item active" aria-current="page"><?php the_title();?></li>
        </ol>
      <div class="page-header bordered mb0">
        <div class="row">
          <div class="col-md-8"> 
          <?php
		the_title(
			sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
			'</a></h1>'
		);
		?>
          </div>
          <div class="col-md-4">
            <div class="price"><?php the_field("price");?> руб</small></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


			
<div id="content" class="item-single">
  <div class="container">
    <div class="row">
          <div class="col col-md-12 col-lg-12 col-xl-10">
        <div class="row has-sidebar">
          <div class="col-md-7 col-lg-8">
            

              <div>
              	<div class="myPostThumb">
              		<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>
              	</div>
                <div class="item-description">
                  <?php the_content();?>
                </div>

                
              </div>
            </div>

          <div class="col-md-5 col-lg-4">
            
          <div><div id="sidebar" class="sidebar-right">
              <div class="sidebar_inner">
                <div id="feature-list" role="tablist">
                <div class="card">
                  <div class="card-header" role="tab" id="headingOne">
                    <h4 class="panel-title"> <a role="button" data-toggle="collapse" href="#specification" aria-expanded="true" aria-controls="specification"> Характеристики <i class="fa fa-caret-down float-right"></i> </a> </h4>
                  </div>
                  <div id="specification" class="panel-collapse collapse show" role="tabpanel">
                    <div class="card-body">
                      <table class="table v1">
                        <tbody><tr>
                          <td>Общ. S</td>
                          <td><?php the_field("totla_square");?></td>
                        </tr>
                        <tr>
                          <td>Жилая S</td>
                          <td><?php the_field("living_square");?></td>
                        </tr>
                        <tr>
                          <td>Этаж</td>
                          <td><?php the_field("floor");?></td>
                        </tr>
                        <tr>
                          <td>Этажей</td>
                          <td><?php the_field("floors");?></td>
                        </tr>
                        <tr>
                          <td>Адрес</td>
                          <td><?php the_field("address");?></td>
                        </tr>
                      </tbody></table>
                    </div>
                  </div>
                </div>
                </div>

              </div>
            </div><div class="resize-sensor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; z-index: -1; visibility: hidden;"><div class="resize-sensor-expand" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0px; top: 0px; transition: all 0s ease 0s; width: 310px; height: 2689px;"></div></div><div class="resize-sensor-shrink" style="position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;"><div style="position: absolute; left: 0; top: 0; transition: 0s; width: 200%; height: 200%"></div></div></div></div></div>
        </div>
      </div>
    </div>
  </div>
</div>

</article><!-- #post-## -->
			<?php endwhile; // end of the loop. ?>
			</main><!-- #main -->
<?php get_footer();?>