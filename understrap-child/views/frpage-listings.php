<?php
    if( ! defined ('ABSPATH')){
        exit;
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                            <div class="col-md-12">

                                <div class="card mb-1">
                                    <div class="card-body">
                                        <div class="row">
                                        <div class="col-md-3">
                                            <?php the_post_thumbnail( $post->ID, 'medium' ); ?>
                                        </div>
                                        <div class="col-md-6 border-right">

                                            <?php
                                                the_title(
                                                    sprintf( '<h5 class="text-danger"><a href="%s">', esc_url( get_permalink() ) ),
            '</a></h5>'
        );
        ?><!-- 
                                            <a href="#" class="badge badge-secondary"> -->
<?php $cur_terms = get_the_terms( $post->ID, 'cities' );
    if( is_array( $cur_terms ) ){
        foreach( $cur_terms as $cur_term ){
            echo '<a class="badge badge-secondary" href="'. get_term_link( (int)$cur_term->term_id, $cur_term->taxonomy ) .'">'. $cur_term->name .'</a>';
        }
    }
?>
                                            <!-- </a> -->
                                            
                                            <?php $cur_terms = get_the_terms( $post->ID, 'estate_type' );
                                                if( is_array( $cur_terms ) ){
                                                    foreach( $cur_terms as $cur_term ){
                                                        echo '<a class="badge badge-secondary" href="'. get_term_link( (int)$cur_term->term_id, $cur_term->taxonomy ) .'">'. $cur_term->name .'</a>';
                                                    }
                                                }
                                            ?>
                                            <p class="card-text"><strong>

<?php $cur_terms = get_the_terms( $post->ID, 'cities' );
    if( is_array( $cur_terms ) ){
        foreach( $cur_terms as $cur_term ){
            echo $cur_term->name;
        }
    }
?>
                                                <?php the_field("address");?></strong></p>
                                            <p class="card-text"><?php the_excerpt(); ?></p>
                                            <?#php if ( 'post' == get_post_type() ) : ?>
                                            <p class="card-text"><small class="text-muted"><?php understrap_posted_on(); ?></small></p>
                                           <?#php endif; ?> 
                                        </div>
                                        <div class="col-md-3">
                                            <h5><?php the_field("price");?> руб.</h5>
                                            <p><strong>Общая S: </strong><small><?php the_field('totla_square'); ?> м<sup>2</sup></small></p>
                                            <p><strong>Жилая S: </strong><small><?php the_field("living_square");?> м<sup>2</sup></small></p>
                                            <p><strong>Этаж: </strong><small><?php the_field("floor");?></small></p>
                                            <p><strong>Этажей: </strong><small><?php the_field("floors");?></small></p>
                                         

  
                                              

                                        </div>
                                    </div>
                                    </div>
                                </div>

                            </div>
                        </div>
        </div>

    </div>
</div>
