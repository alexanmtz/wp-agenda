<?php
/*
 Plugin Name: WP Agenda
 Plugin URI: http://www.alexandremagno.net/projects/wp-agenda
 Description: Manage events with wordpress
 Version: 2.0
 Author: Alexandre Magno <alexanmtz@gmail.com>
 Author URI: http://blog.alexandremagno.net
 */

define('PLUGIN_PATH', WP_PLUGIN_URL."/wp-agenda");

class Agenda {

	var $name = 'agenda';

	function __construct() {
		$this->register_admin_scripts();
		$this->register_public_scripts();
		$this->register_actions();
		$this->register_ajax_actions();
	}

	function register_admin_scripts() {
		
		wp_enqueue_style('jquery-ui', PLUGIN_PATH.'/css/jquery-ui-1.7.2.custom.css');
		wp_enqueue_style('jgrowl', PLUGIN_PATH.'/css/jquery.jgrowl.css');
		wp_enqueue_style( 'admin_agenda',PLUGIN_PATH.'/css/style_admin.css');
		
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script( 'form');
		wp_enqueue_script('jgrowl', PLUGIN_PATH.'/js/jquery.jgrowl_compressed.js', array('jquery'));
		wp_enqueue_script('jquery-ui-datepicker', PLUGIN_PATH.'/js/jquery.ui.datepicker.js', array('jquery','jquery-ui-core'));
		//wp_enqueue_script('datepicker-i18n', PLUGIN_PATH.'/js/jquery.ui.datepicker-pt-BR.js', array('jquery'));
		wp_enqueue_script( 'dateformat', PLUGIN_PATH.'/js/dateformat.js');
		wp_enqueue_script( 'blockui', PLUGIN_PATH.'/js/jquery.blockui.js', array('jquery'));
		wp_enqueue_script( 'validate', PLUGIN_PATH.'/js/jquery.validate.min.js', array('jquery'));
		wp_enqueue_script( 'agenda', PLUGIN_PATH.'/js/agenda_admin.js', array('fullcalendar','jquery-ui-dialog', 'jquery-ui-datepicker'));
	}

	function register_public_scripts() {
		wp_enqueue_style( 'fullcalendar', PLUGIN_PATH.'/css/fullcalendar.css');
		wp_enqueue_style('tooltip', PLUGIN_PATH.'/css/jquery.tooltip.css');
		wp_enqueue_style('public', PLUGIN_PATH.'/css/style_public.css');
		wp_enqueue_script( 'blockui', PLUGIN_PATH.'/js/jquery.blockui.js', array('jquery'));
		wp_enqueue_script('jgrowl', PLUGIN_PATH.'/js/jquery.jgrowl_compressed.js', array('jquery'));
		wp_enqueue_script('tooltip', PLUGIN_PATH.'/js/jquery.tooltip.pack.js', array('jquery'));
		wp_enqueue_script( 'fullcalendar', PLUGIN_PATH.'/js/fullcalendar.js', array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-resizable','tooltip'));
		//wp_enqueue_script( 'agenda-locale', PLUGIN_PATH.'/js/agenda-locale.js', array('fullcalendar'));
		wp_enqueue_script( 'agenda_main', PLUGIN_PATH.'/js/agenda_main.js', array('fullcalendar', 'tooltip'));
	}
	function register_actions() {
		add_action('admin_init', array($this,"register_admin_scripts"));
		add_action('init',array($this,"register_public_scripts"));
		add_action('init',array($this,"install"));
		add_action('admin_init', array($this, 'print_boxes'));
		add_action('save_post', array($this, 'save_metadata'));
		
		add_action('wp_print_scripts', array($this,'generate_javascript_object'));
		
		/* reescrevendo url */
		/* aplicando urls */
		add_action('init', array($this,'agenda_rewrite_rules'));
		/* redirecionando template */
		add_action("template_redirect",array($this,'agenda_templates'));
		/* passando variaveis para o loop de agenda */
		add_filter('query_vars', array($this,'agenda_queryvars'));
	}
	
	function generate_javascript_object() {
		if(!is_admin()) {
			echo '<script type="text/javascript">';
			echo 'var ajaxurl = "'.site_url('/wp-admin/admin-ajax.php";');
			echo '</script>';
		}
	}
	
	function register_ajax_actions() {
		add_action('wp_ajax_agenda_events', array($this,'get_agenda_events'));
    add_action('wp_ajax_nopriv_agenda_events', array($this,'get_agenda_events'));
	}
	
	
	function get_agenda_events() {
		global $wpdb;
		$events = get_posts(array('post_type'=>'agenda', 'numberposts' => -1), ARRAY_A);
    
		foreach($events as $event) {
		  if( current_theme_supports( 'post-thumbnails' ) ) {
        $thumb = get_the_post_thumbnail( $event->ID, array(100,100) );
      }
			$event->start_date = get_post_meta($event->ID, 'start-date');
			$event->end_date = get_post_meta($event->ID, 'end-date');
			$event->start_time = get_post_meta($event->ID, 'start-time');
			$event->end_time = get_post_meta($event->ID, 'end-time');
			$event->thumbnail = $thumb;
		}
		$json = json_encode($events);
		echo $json;
		die();
	}
	
	function install() {

		$labels = array(
		    'name' => __('Agenda', 'Add new event'),
		    'singular_name' => __('Agenda', 'Event'),
		    'add_new' => __('Add New', 'Event'),
		    'add_new_item' => __('Add new event'),
		    'edit_item' => __('Edit Event'),
		    'new_item' => __('New Event'),
		    'view_item' => __('See Event'),
		    'search_items' => __('Search Events'),
		    'not_found' =>  __('no events found'),
		    'not_found_in_trash' => __('no events in trash'), 
		    'parent_item_colon' => '',
		    'menu_name' => 'Agenda'

		    );


		    register_post_type($this->name,array(
		    'label' => 'Agenda',
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true,
		    'taxonomies' => array( 'post_tag'), 
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
		add_meta_box('wp-agenda-date', __('When'), array($this,'print_date_box'), $this->name);
		add_meta_box('wp-agenda-local', __('Where'), array($this,'print_local_box'), $this->name);
	}
	function print_date_box() {
		global $post;
		$post_id = $post->ID;
		$start_date = get_post_meta($post_id, 'start-date', true);
		$end_date = get_post_meta($post_id, 'end-date', true);
		$start_time = get_post_meta($post_id, 'start-time', true);
		$end_time = get_post_meta($post_id, 'end-time', true);
		
		echo '<fieldset>';
		echo '<label for="start-date">' . __("Starts in:", 'agenda' ) . '</label> ';
		echo '<input class="date" type="text" id="start-date" name="start-date" value="'.$start_date.'" size="25" />';
		echo '<label for="start-time">' . __("Start Hour:", 'agenda' ) . '</label> ';
		echo '<input type="text" name="start-time" value="'.$start_time.'" />';
		echo '<span>Ex: 14:24</span>';
		echo '</fieldset>';
		echo '<fieldset>';
		echo '<label for="end-date">' . __("Ends in:", 'agenda' ) . '</label> ';
		echo '<input class="date" type="text" id="end-date" name="end-date" value="'.$end_date.'" size="25" />';
		echo '<label for="end-time">' . __("Finish time:", 'agenda' ) . '</label> ';
		echo '<input type="text" name="end-time" value="'.$end_time.'" />';
		echo '<span>Ex: 12:24</span>';
		echo '';
		echo '</fieldset>';

	}

	function print_local_box() {
		global $post;
		$post_id = $post->ID;
		$local = get_post_meta($post_id, 'local', true);
		echo '<label for="local">' . __("Event Address:", 'agenda' ) . '</label> ';
		echo '<label for="local">' . __("Endereço do evento:", 'agenda' ) . '</label> ';
		echo '<textarea class="local" type="text" id="local" name="local">'.$local.'</textarea>';
	}

	function save_metadata($id) {
		
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    		return $postID;
		}
		
		
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

	function agenda_rewrite_rules() {
		add_rewrite_tag('%agenda%','([^&]+)');
	}

	function agenda_templates() {
	  global $wp_query;
		if ( !is_null($wp_query->query_vars['agenda']) ) {
			if (file_exists(TEMPLATEPATH . '/agenda.php')) {
				include(TEMPLATEPATH . '/agenda.php');
				exit;
			} 
		}
	}

	function agenda_queryvars($qvars) {
		$qvars[] = 'agenda';
		return $qvars;
	}

}
// end WPAgenda Class


new Agenda();