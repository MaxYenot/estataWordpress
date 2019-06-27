<?php
add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
// add_action('wp_print_styles', 'theme_name_scripts'); // можно использовать этот хук он более поздний
function theme_name_scripts() {
	wp_enqueue_style( 'style-name', get_stylesheet_uri() );
	wp_enqueue_script( 'user_javascript', get_stylesheet_directory_uri() .  '/js/yenot.js', $deps, $ver, true );
}

//уменьшаем кол-во выведеных слов в excerpt
add_filter( 'excerpt_length', function(){
	return 8;
} );

//добавляем произвольный тип записи "недвижимость"
add_action( 'init', 'true_register_post_type_init' );

function true_register_post_type_init() {
	$labels = array(
		'name' => 'Недвижимость',
		'singular_name' => 'Недвижимость', // админ панель Добавить->Функцию
		'add_new' => 'Добавить объект',
		'add_new_item' => 'Добавить новый объект недвижимости', // заголовок тега <title>
		'edit_item' => 'Редактировать объект',
		'new_item' => 'Новый оБъект',
		'all_items' => 'Все объекты',
		'view_item' => 'Просмотр данного объекта на сайте',
		'search_items' => 'Искать недвижимость',
		'not_found' =>  'Извините, объектов недвижимости не найдено.',
		'not_found_in_trash' => 'В корзине нет объектов недвижимости.',
		'menu_name' => 'Недвижимость' // ссылка в меню в админке
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'show_ui' => true, // показывать интерфейс в админке
		'has_archive' => true, 
		'menu_icon' => get_stylesheet_directory_uri() .'/img/estate_icon.png', // иконка в меню
		'menu_position' => 20, // порядок в меню
		'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'taxonomies'),
		'taxonomy' => 'estate_type',
	);
	register_post_type('estate', $args);
}

// добавляем таксономию
function reg_my_tax_est_type(){
$labels = array(
		'name'              => _x( 'Тип недвижимости', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Тип недвижимости', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Искать по типу недвижимости', 'textdomain' ),
		'all_items'         => __( 'Вся недвижимость', 'textdomain' ),
		'edit_item'         => __( 'Редактировать тип', 'textdomain' ),
		'update_item'       => __( 'Обновить тип', 'textdomain' ),
		'add_new_item'      => __( 'Добавить новый тип недвижимости', 'textdomain' ),
		'new_item_name'     => __( 'Имя нового типа', 'textdomain' ),
		'menu_name'         => __( 'Тип недвижимости', 'textdomain' ),
	);

$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'estate-type' ),
	);
register_taxonomy( "estate_type", array('estate'), $args );
}
add_action( 'init', 'reg_my_tax_est_type' );

function reg_my_tax_cities(){
$labels = array(
		'name'              => _x( 'Города', 'taxonomy general name', 'textdomain' ),
		'singular_name'     => _x( 'Город', 'taxonomy singular name', 'textdomain' ),
		'search_items'      => __( 'Искать по городам', 'textdomain' ),
		'all_items'         => __( 'Все города', 'textdomain' ),
		'edit_item'         => __( 'Редактировать город', 'textdomain' ),
		'update_item'       => __( 'Обновить город', 'textdomain' ),
		'add_new_item'      => __( 'Добавить новый город', 'textdomain' ),
		'new_item_name'     => __( 'Имя нового города', 'textdomain' ),
		'menu_name'         => __( 'Город', 'textdomain' ),
	);

$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'cities' ),
	);
register_taxonomy( "cities", array('estate'), $args );	
}
add_action( 'init', 'reg_my_tax_cities' );



/**
 * Возможность загружать изображения для терминов (элементов таксономий: категории, метки).
 *
 * Пример получения ID и URL картинки термина:
 *     $image_id = get_term_meta( $term_id, '_thumbnail_id', 1 );
 *     $image_url = wp_get_attachment_image_url( $image_id, 'thumbnail' );
 *
 * @author: Kama http://wp-kama.ru
 *
 * @version 2.9
 */
if( is_admin() && ! class_exists('Term_Meta_Image') ){

	// init
	//add_action('current_screen', 'Term_Meta_Image_init');
	add_action( 'admin_init', 'Term_Meta_Image_init' );
	function Term_Meta_Image_init(){
		$GLOBALS['Term_Meta_Image'] = new Term_Meta_Image();
	}

	class Term_Meta_Image {

		// для каких таксономий включить код. По умолчанию для всех публичных
		static $taxes = []; // пример: array('category', 'post_tag');

		// название мета ключа
		static $meta_key = '_thumbnail_id';
		static $attach_term_meta_key = 'img_term';

		// URL пустой картинки
		static $add_img_url = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkAQMAAABKLAcXAAAABlBMVEUAAAC7u7s37rVJAAAAAXRSTlMAQObYZgAAACJJREFUOMtjGAV0BvL/G0YMr/4/CDwY0rzBFJ704o0CWgMAvyaRh+c6m54AAAAASUVORK5CYII=';

		public function __construct(){
			// once
			if( isset($GLOBALS['Term_Meta_Image']) )
				return $GLOBALS['Term_Meta_Image'];

			$taxes = self::$taxes ? self::$taxes : get_taxonomies( [ 'public' =>true ], 'names' );

			foreach( $taxes as $taxname ){
				add_action( "{$taxname}_add_form_fields",   [ $this, 'add_term_image' ],     10, 2 );
				add_action( "{$taxname}_edit_form_fields",  [ $this, 'update_term_image' ],  10, 2 );
				add_action( "created_{$taxname}",           [ $this, 'save_term_image' ],    10, 2 );
				add_action( "edited_{$taxname}",            [ $this, 'updated_term_image' ], 10, 2 );

				add_filter( "manage_edit-{$taxname}_columns",  [ $this, 'add_image_column' ] );
				add_filter( "manage_{$taxname}_custom_column", [ $this, 'fill_image_column' ], 10, 3 );
			}
		}

		## поля при создании термина
		public function add_term_image( $taxonomy ){
			wp_enqueue_media(); // подключим стили медиа, если их нет

			add_action('admin_print_footer_scripts', [ $this, 'add_script' ], 99 );
			$this->css();
			?>
			<div class="form-field term-group">
				<label><?php _e('Image', 'default'); ?></label>
				<div class="term__image__wrapper">
					<a class="termeta_img_button" href="#">
						<img src="<?php echo self::$add_img_url ?>" alt="">
					</a>
					<input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
				</div>

				<input type="hidden" id="term_imgid" name="term_imgid" value="">
			</div>
			<?php
		}

		## поля при редактировании термина
		public function update_term_image( $term, $taxonomy ){
			wp_enqueue_media(); // подключим стили медиа, если их нет

			add_action('admin_print_footer_scripts', [ $this, 'add_script' ], 99 );

			$image_id = get_term_meta( $term->term_id, self::$meta_key, true );
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : self::$add_img_url;
			$this->css();
			?>
			<tr class="form-field term-group-wrap">
				<th scope="row"><?php _e( 'Image', 'default' ); ?></th>
				<td>
					<div class="term__image__wrapper">
						<a class="termeta_img_button" href="#">
							<?php echo '<img src="'. $image_url .'" alt="">'; ?>
						</a>
						<input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
					</div>

					<input type="hidden" id="term_imgid" name="term_imgid" value="<?php echo $image_id; ?>">
				</td>
			</tr>
			<?php
		}

		public function css(){
			?>
			<style>
				.termeta_img_button{ display:inline-block; margin-right:1em; }
				.termeta_img_button img{ display:block; float:left; margin:0; padding:0; min-width:100px; max-width:150px; height:auto; background:rgba(0,0,0,.07); }
				.termeta_img_button:hover img{ opacity:.8; }
				.termeta_img_button:after{ content:''; display:table; clear:both; }
			</style>
			<?php
		}

		## Add script
		public function add_script(){
			// выходим если не на нужной странице таксономии
			//$cs = get_current_screen();
			//if( ! in_array($cs->base, array('edit-tags','term')) || ! in_array($cs->taxonomy, (array) $this->for_taxes) )
			//  return;

			$title = __('Featured Image', 'default');
			$button_txt = __('Set featured image', 'default');
			?>
			<script>
			jQuery(document).ready(function($){
				var frame,
					$imgwrap = $('.term__image__wrapper'),
					$imgid   = $('#term_imgid');

				// добавление
				$('.termeta_img_button').click( function(ev){
					ev.preventDefault();

					if( frame ){ frame.open(); return; }

					// задаем media frame
					frame = wp.media.frames.questImgAdd = wp.media({
						states: [
							new wp.media.controller.Library({
								title:    '<?php echo $title ?>',
								library:   wp.media.query({ type: 'image' }),
								multiple: false,
								//date:   false
							})
						],
						button: {
							text: '<?php echo $button_txt ?>', // Set the text of the button.
						}
					});

					// выбор
					frame.on('select', function(){
						var selected = frame.state().get('selection').first().toJSON();
						if( selected ){
							$imgid.val( selected.id );
							$imgwrap.find('img').attr('src', selected.sizes.thumbnail.url );
						}
					} );

					// открываем
					frame.on('open', function(){
						if( $imgid.val() ) frame.state().get('selection').add( wp.media.attachment( $imgid.val() ) );
					});

					frame.open();
				});

				// удаление
				$('.termeta_img_remove').click(function(){
					$imgid.val('');
					$imgwrap.find('img').attr('src','<?php echo self::$add_img_url ?>');
				});
			});
			</script>

			<?php
		}

		## Добавляет колонку картинки в таблицу терминов
		public function add_image_column( $columns ){
			// fix column width
			add_action( 'admin_notices', function(){
				echo '<style>.column-image{ width:50px; text-align:center; }</style>';
			});

			// column without name
			return array_slice( $columns, 0, 1 ) + [ 'image' =>'' ] + $columns;
		}

		public function fill_image_column( $string, $column_name, $term_id ){
			if( $image_id = get_term_meta( $term_id, self::$meta_key, 1 ) ){
				$string = '<img src="'. wp_get_attachment_image_url( $image_id, 'thumbnail' ) .'" width="50" height="50" alt="" style="border-radius:4px;" />';
			}

			return $string;
		}

		## Save the form field
		public function save_term_image( $term_id, $tt_id ){
			if( isset($_POST['term_imgid']) && $attach_id = (int) $_POST['term_imgid'] ){
				update_term_meta( $term_id,   self::$meta_key,             $attach_id );
				update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );
			}
		}

		## Update the form field value
		public function updated_term_image( $term_id, $tt_id ){
			if( ! isset($_POST['term_imgid']) )
				return;

			$cur_term_attach_id = (int) get_term_meta( $term_id, self::$meta_key, 1 );

			if( $attach_id = (int) $_POST['term_imgid'] ){
				update_term_meta( $term_id,   self::$meta_key,             $attach_id );
				update_post_meta( $attach_id, self::$attach_term_meta_key, $term_id );

				if( $cur_term_attach_id != $attach_id )
					wp_delete_attachment( $cur_term_attach_id );
			}
			else {
				if( $cur_term_attach_id )
					wp_delete_attachment( $cur_term_attach_id );

				delete_term_meta( $term_id, self::$meta_key );
			}
		}

	}

}



//shortcodes

function r_estate_creator_shortcode(){
	$creatorHTML = file_get_contents("inc/estateform/estate_form_template.php", true);
	$editorHTML = r_generate_content_editor();
	$creatorHTML = str_replace('CONTENT_EDITOR', $editorHTML, $creatorHTML);
	return $creatorHTML;
}
function r_generate_content_editor(){
	ob_start();
	wp_editor('', 'estatecontenteditor');
	$editor_contents = ob_get_clean();
	return $editor_contents;
	
	
}

add_shortcode( 'estate_creator', 'r_estate_creator_shortcode' );