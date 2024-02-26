<?php
function get_clients_group($id) {
    global $wpdb;
    $table_client = $wpdb->prefix . 'clients';
    $table_group = $wpdb->prefix . 'groupes';

    return $wpdb->get_results("SELECT * FROM `$table_client` wp_c INNER JOIN `$table_group` wp_g ON wp_c.groupe_id=wp_g.groupe_id WHERE wp_g.groupe_id=$id", ARRAY_A);
}
?>