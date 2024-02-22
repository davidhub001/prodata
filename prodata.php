<?php
/*
Plugin Name: Prodata
Description: Gestion de user group
Version: 1.0
Author: david
*/
require_once plugin_dir_path(__FILE__) . 'client.crud.php';
require_once plugin_dir_path(__FILE__) . 'group.crud.php';

// Fonction de rappel pour afficher la page du menu

function prodata_page() {
    include "admin_prodata.php";
}

// // Fonction pour enregistrer et charger le CSS
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

    // Ajoutez un sous-menu pour la gestion des groupes
    add_submenu_page(
        'prodata_admin',   // Slug parent de la page
        'Gestion des Groupes', // Titre du sous-menu
        'Groupes',           // Texte dans le sous-menu
        'manage_options',    // Capacité requise pour accéder à la page
        'prodata_groupes',   // Slug de la sous-page
        'prodata_page' // Fonction de rappel pour afficher la page des groupes
    );

    // Ajoutez un sous-menu pour la gestion des clients
    add_submenu_page(
        'prodata_admin',   // Slug parent de la page
        'Gestion des Clients', // Titre du sous-menu
        'Clients',           // Texte dans le sous-menu
        'manage_options',    // Capacité requise pour accéder à la page
        'prodata_clients',   // Slug de la sous-page
        'prodata_page' // Fonction de rappel pour afficher la page des clients
    );


    // Enqueue le CSS pour votre page
    add_action('admin_enqueue_scripts', 'mon_plugin_enqueue_styles');
}
add_action('admin_menu', 'prodata_menu');

function prodata_activate() {
    // Assurez-vous que l'activation est effectuée dans le contexte de l'administration
    delete_option('prodata_activated');
    if (is_admin() && get_option('prodata_activated') !== 'activated') {
        // Créez la table dans la base de données
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // Lisez le fichier SQL
        $sql_file = plugin_dir_path(__FILE__) . 'prodata.sql';
        $sql = file_get_contents($sql_file);
        $sql = preg_replace('/wp_/', $wpdb->prefix, $sql);

        // Affichez le contenu de la requête SQL à des fins de débogage
        error_log('SQL Query: ' . $sql);

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        $result = dbDelta($sql);

        // Affichez le résultat de la requête à des fins de débogage
        error_log('Result: ' . print_r($result, true));

        // Marquez le plugin comme activé pour éviter de répéter cette opération
        update_option('prodata_activated', 'activated');
    }
}

// Enregistrez la fonction d'activation du plugin
register_activation_hook(__FILE__, 'prodata_activate');