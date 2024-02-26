<?php
/*
Plugin Name: Prodata
Description: Gestion de user group
Version: 1.0
Author: david
*/
require_once plugin_dir_path(__FILE__) . 'client.crud.php';
require_once plugin_dir_path(__FILE__) . 'group.crud.php';
require_once plugin_dir_path(__FILE__) . 'join_client_groupes.php';
require_once plugin_dir_path(__FILE__) . 'action_prodata.php';

function prodata_page() {
    include "admin_prodata.php";
}

function mon_plugin_enqueue_styles() {
    wp_enqueue_style('mon-plugin-styles', plugins_url('css/style.css', __FILE__));
}

function prodata_menu() {
    add_menu_page(
        'Prodata',          // Titre de la page
        'Prodata',          // Texte dans le menu
        'manage_options',   // Capacité requise pour accéder à la page
        'prodata_admin',  // Slug de la page
        'prodata_page',     // Fonction de rappel pour afficher la page
        'dashicons-admin-generic' // Icône optionnelle, vous pouvez changer cela
    );
    add_submenu_page(
        'prodata_admin',   // Slug parent de la page
        'Gestion des Groupes', // Titre du sous-menu
        'Groupes',           // Texte dans le sous-menu
        'manage_options',    // Capacité requise pour accéder à la page
        'prodata_groupes',   // Slug de la sous-page
        'prodata_page' // Fonction de rappel pour afficher la page des groupes
    );
    add_submenu_page(
        'prodata_admin',
        'Gestion des Clients',
        'Clients',
        'manage_options',
        'prodata_clients',
        'prodata_page'
    );
    add_action('admin_enqueue_scripts', 'mon_plugin_enqueue_styles');
}
add_action('admin_menu', 'prodata_menu');

function prodata_activate() {
    delete_option('prodata_activated');
    if (is_admin() && get_option('prodata_activated') !== 'activated') {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();
        $sql_file = plugin_dir_path(__FILE__) . 'prodata.sql';
        $sql = file_get_contents($sql_file);
        $sql = preg_replace('/wp_/', $wpdb->prefix, $sql);

        error_log('SQL Query: ' . $sql);

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);
        error_log('Result: ' . print_r($result, true));
        update_option('prodata_activated', 'activated');
    }
}

register_activation_hook(__FILE__, 'prodata_activate');

function prodata_clients_shortcode($atts) {
    $atts = shortcode_atts(
        array(
            'groupe' => 5, 
        ),
        $atts,
        'prodata_clients'
    );

    $groupe = intval($atts['groupe']);
    $jsonData = json_decode(file_get_contents(admin_url('admin-ajax.php?action=prodata_retourne_json&id_groupe='.$groupe)));
    ob_start();
    include 'affichage_prodata.php';
    return ob_get_clean();
}
add_shortcode('prodata_clients', 'prodata_clients_shortcode');


function enqueue_plugin_styles() {
    $css_url = plugins_url('css', __FILE__);
    wp_enqueue_style('style2', $css_url . '/style.css', array(), null, 'all');
}
add_action('wp_enqueue_scripts', 'enqueue_plugin_styles');

function prodata_retourne_json() {
    $data =  get_clients_group($_GET["id_groupe"]);
    wp_send_json($data);
}
add_action('wp_ajax_prodata_retourne_json', 'prodata_retourne_json');
add_action('wp_ajax_nopriv_prodata_retourne_json', 'prodata_retourne_json');
