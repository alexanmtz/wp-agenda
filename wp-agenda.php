<?php
/*
 Plugin Name: WP Agenda
 Plugin URI: http://www.alexandremagno.net/projects/wp-agenda
 Description: Manage events with wordpress
 Version: 0.1
 Author: Alexandre Magno <alexanmtz@gmail.com>
 Author URI: http://blog.alexandremagno.net
 */

class WPAgenda {

	function init() {
		$this->register_admin_scripts();
		$this->register_public_scripts();
		$this->register_actions();
	}

	function register_admin_scripts() {
		wp_enqueue_script('jquery-ui-dialog');
		wp_enqueue_style('jquery-ui-dialog', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/jquery-ui-1.7.2.custom.css');
		wp_enqueue_script( 'form');
		wp_enqueue_style('jgrowl', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/jquery.jgrowl.css');
		wp_enqueue_script('jgrowl', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/jquery.jgrowl_compressed.js', array('jquery'));
		wp_enqueue_script( 'dateformat', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/dateformat.js');
		wp_enqueue_script( 'validate', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/jquery.validate.min.js', array('jquery'));
		wp_enqueue_script( 'agenda', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/agenda_admin.js', array('fullcalendar','jquery-ui-dialog'));
		wp_enqueue_style( 'admin_agenda',WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/style_admin.css');
	}

	function register_public_scripts() {
		wp_enqueue_style( 'agenda_view',WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/agenda_public.css');
		wp_enqueue_style( 'fullcalendar', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/fullcalendar.css');
		wp_enqueue_style('jgrowl', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/css/jquery.jgrowl.css');
		wp_enqueue_script('jgrowl', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/jquery.jgrowl_compressed.js', array('jquery'));
		wp_enqueue_script( 'fullcalendar', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/fullcalendar.js', array('jquery','jquery-ui-core','jquery-ui-draggable','jquery-ui-resizable'));
		wp_enqueue_script( 'agenda-locale', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/agenda-locale.js', array('fullcalendar'));
		wp_enqueue_script( 'agenda_main', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/agenda_main.js', array('fullcalendar'));
	}
	function register_actions() {
		add_action('admin_init', array($this,"register_admin_scripts"));
		add_action('init',array($this,"register_public_scripts"));
		add_action('init',array($this,"install"));
	}


	function install() {
		
		register_post_type('WPAgenda',array(
		    'label' => __('Agenda'),
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
			'menu_icon' => 'WP_PLUGIN_URL'.'/'.plugin_basename(dirname(__FILE__)).'/img/calendar.png',
		    'supports' => array('title','editor','author','thumbnail','excerpt','comments')
		));
	}
	
}
// end WPAgenda Class

$agenda = new WPAgenda();
$agenda->init();