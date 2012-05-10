<?php 
global $wpdb;
global $wp_rewrite;
remove_post_type_support('agenda');

$WPAgenda_delete_query  = "
    DELETE wposts.* 
    FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
    WHERE wposts.ID = wpostmeta.post_id 
    AND wpostmeta.meta_key = 'tag' 
    AND wpostmeta.meta_value = 'email' 
    AND wposts.post_status = 'publish' 
    AND wposts.post_type = 'agenda' 
    ORDER BY wposts.post_date DESC
 ";

$wpdb->query($WPAgenda_delete_query);

$wp_rewrite->flush_rules();

?>