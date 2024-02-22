<?php
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_REQUEST["option"] =="insertgroup"):
        $nom_groupe = sanitize_text_field($_POST["nomGroupe"]);
        insert_groupe(array('nom_groupe' => $nom_groupe));
    endif;
}

function display_groupes_list() {
    $groupes = get_groupes();

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

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'edit_groupe':
            if (isset($_GET['id'])) {
                $groupe_id = intval($_GET['id']);
            }
            break;

        case 'delete_groupe':
            if (isset($_GET['id'])) {
                $groupe_id = intval($_GET['id']);
                delete_groupe($groupe_id);
            }
            break;

        default:
            // Gestion d'autres actions
            break;
    }
}

