<?php
/*
 Plugin Name: WP Agenda
 Plugin URI: http://www.alexandremagno.net/projects/wp-agenda
 Description: Manage events with wordpress
 Version: 0.1
 Author: Alexandre Magno <alexanmtz@gmail.com>
 Author URI: http://blog.alexandremagno.net
 */

define('PLUGIN_PATH', WP_PLUGIN_URL."/wp-agenda");

class WPAgenda {
	
	var $name = 'WPAgenda';
	
	function __construct() {
		$this->register_admin_scripts();
		$this->register_public_scripts();
		$this->register_actions();
	}

	function register_admin_scripts() {
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('jquery-ui', PLUGIN_PATH.'/css/jquery-ui-1.7.2.custom.css');
		wp_enqueue_script( 'form');
		wp_enqueue_style('jgrowl', PLUGIN_PATH.'/css/jquery.jgrowl.css');
		wp_enqueue_script('jgrowl', PLUGIN_PATH.'/js/jquery.jgrowl_compressed.js', array('jquery'));
		wp_enqueue_script('datepicker-i18n', PLUGIN_PATH.'/js/jquery.ui.datepicker-pt-BR.js', array('jquery'));
		wp_enqueue_script('jquery-ui-datepicker', PLUGIN_PATH.'/js/jquery.ui.datepicker.js', array('jquery','jquery-ui-core'));
		wp_enqueue_script( 'dateformat', PLUGIN_PATH.'/js/dateformat.js');
		wp_enqueue_script( 'validate', PLUGIN_PATH.'/js/jquery.validate.min.js', array('jquery'));
		wp_enqueue_script( 'agenda', PLUGIN_PATH.'/js/agenda_admin.js', array('fullcalendar','jquery-ui-dialog'));
		wp_enqueue_style( 'admin_agenda',PLUGIN_PATH.'/css/style_admin.css');
	}

	function register_public_scripts() {
		wp_enqueue_style( 'fullcalendar', PLUGIN_PATH.'/css/fullcalendar.css');
		wp_enqueue_style('jgrowl', PLUGIN_PATH.'/css/jquery.jgrowl.css');
		wp_enqueue_script('jgrowl', PLUGIN_PATH.'/js/jquery.jgrowl_compressed.js', array('jquery'));
		wp_enqueue_script( 'fullcalendar', PLUGIN_PATH.'/js/fullcalendar.js', array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-resizable'));
		wp_enqueue_script( 'agenda-locale', PLUGIN_PATH.'/js/agenda-locale.js', array('fullcalendar'));
		wp_enqueue_script( 'agenda_main', PLUGIN_PATH.'/js/agenda_main.js', array('fullcalendar'));
	}
	function register_actions() {
		add_action('admin_init', array($this,"register_admin_scripts"));
		add_action('init',array($this,"register_public_scripts"));
		add_action('init',array($this,"install"));
		add_action('admin_init', array($this, 'print_boxes'));
		add_action('save_post', array($this, 'save_metadata'));
	}


	function install() {
		
		$labels = array(
		    'name' => __('Agenda', 'Adicionar novo evento'),
		    'singular_name' => __('Agenda', 'Evento'),
		    'add_new' => __('Adicionar novo', 'Evento'),
		    'add_new_item' => __('Adicionar novo evento'),
		    'edit_item' => __('Editar Agenda'),
		    'new_item' => __('Nova Agenda'),
		    'view_item' => __('Ver Agenda'),
		    'search_items' => __('Buscar Eventos'),
		    'not_found' =>  __('Nenhum evento encontrado'),
		    'not_found_in_trash' => __('Nenhum evento na lixeira'), 
		    'parent_item_colon' => '',
		    'menu_name' => 'Agenda'

  		);
		
		
		register_post_type($this->name,array(
		    'label' => 'Agenda',
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => true,
		    'capability_type' => 'post',
		    'has_archive' => true, 
		    'hierarchical' => false,
		    'menu_position' => null,
			'menu_icon' => PLUGIN_PATH.'/img/calendar.png',
		    'supports' => array('title','editor', 'thumbnail','excerpt')
		));
	}
	function print_boxes() {
		add_meta_box('wp-agenda-date', __('Data e horário'), array($this,'print_date_box'), 'WPAgenda');
		add_meta_box('wp-agenda-local', __('Local'), array($this,'print_local_box'), 'WPAgenda');
	}
	function print_date_box() {
		global $post;
		$post_id = $post->ID;
		$start_date = get_post_meta($post_id, 'start-date', true);
		$end_date = get_post_meta($post_id, 'end-date', true);
		$start_time = get_post_meta($post_id, 'start-time', true);
		$end_time = get_post_meta($post_id, 'end-time', true);
		
		echo '<fieldset>';
		echo '<label for="start-date">' . __("Começa em:", 'WPAgenda' ) . '</label> ';
  		echo '<input class="date" type="text" id="start-date" name="start-date" value="'.$start_date.'" size="25" />';
  		echo '<label for="start-time">' . __("Horário de início:", 'WPAgenda' ) . '</label> ';
  		echo '<input type="text" name="start-time" value="'.$start_time.'" />';
  		echo '</fieldset>';
		echo '<fieldset>';
  		echo '<label for="end-date">' . __("Termina em:", 'WPAgenda' ) . '</label> ';
  		echo '<input class="date" type="text" id="end-date" name="end-date" value="'.$end_date.'" size="25" />';
  		echo '<label for="end-time">' . __("Horário de Término:", 'WPAgenda' ) . '</label> ';
  		echo '<input type="text" name="end-time" value="'.$end_time.'" />';
  		echo '';
  		echo '</fieldset>';
  		
	}
	
	function print_local_box() {
		global $post;
		$post_id = $post->ID;
		$local = get_post_meta($post_id, 'local', true);
		echo '<label for="local">' . __("Endereço do evento:", 'WPAgenda' ) . '</label> ';
  		echo '<textarea class="local" type="text" id="local" name="local">'.$local.'</textarea>';
	}
	
	function save_metadata($id) {
		$metadata = Array();
		$metadata['start-date'] = $_POST['start-date'];
		$metadata['start-time'] = $_POST['start-time'];
		$metadata['end-date'] = $_POST['end-date'];
		$metadata['end-time'] = $_POST['end-time'];
		$metadata['local'] = $_POST['local'];
		foreach($metadata as $key => $data) {
			update_post_meta($id, $key, $data);
		}
		
		return $metadata;
	}
	
}
// end WPAgenda Class

$agenda = new WPAgenda();