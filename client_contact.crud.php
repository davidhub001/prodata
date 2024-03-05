<?php
function insert_cc($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'client_contact';

    $wpdb->insert(
        $table_name,
        array(
            'description' => serialize($data['description']),
            'id_client' => $data['id_client']
        )
    );
}

// function update_groupe($groupe_id, $data) {
//     global $wpdb;
//     $table_name = $wpdb->prefix . 'groupes';

//     $wpdb->update(
//         $table_name,
//         array(
//             'nom_groupe' => $data['nom_groupe'],
//         ),
//         array('groupe_id' => $groupe_id)
//     );
// }

function delete_cc($groupe_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'client_contact';

    $wpdb->delete(
        $table_name,
        array('id' => $groupe_id)
    );
}

function get_cc() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'client_contact';

    return $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
}

function display_cc_list() {
    $groupes = get_cc();

    if ($groupes) {
        echo '<ul>';
        foreach ($groupes as $groupe) {
            echo '<li>';
            echo $groupe['nom_groupe'];
            echo '<a href="?page=prodata_groupes&action=edit_groupe&id=' . $groupe['groupe_id'] . '">Modifier</a>';
            echo '<a href="?page=prodata_groupes&action=delete_groupe&id=' . $groupe['groupe_id'] . '">Supprimer</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo 'Aucun groupe trouvé.';
    }
}
