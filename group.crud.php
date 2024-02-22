<?php

// database-functions.php

// ...

function insert_groupe($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'groupes';

    $wpdb->insert(
        $table_name,
        array(
            'nom_groupe' => $data['nom_groupe'],
        )
    );
}

function update_groupe($groupe_id, $data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'groupes';

    $wpdb->update(
        $table_name,
        array(
            'nom_groupe' => $data['nom_groupe'],
        ),
        array('groupe_id' => $groupe_id)
    );
}

function delete_groupe($groupe_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'groupes';

    $wpdb->delete(
        $table_name,
        array('groupe_id' => $groupe_id)
    );
}

function get_groupes() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'groupes';

    return $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
}

// Gestion du formulaire de groupe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_groupe = sanitize_text_field($_POST["nomGroupe"]);

    // Validez les données ici

    // Insérez le groupe dans la base de données
    insert_groupe(array('nom_groupe' => $nom_groupe));
}
