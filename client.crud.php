<?php
function get_clients() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'clients';

    return $wpdb->get_results("SELECT * FROM $table_name", ARRAY_A);
}
function delete_client($client_id) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'clients';

    $wpdb->delete(
        $table_name,
        array('id' => $client_id)
    );
}
function update_client($client_id, $data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'clients';

    $wpdb->update(
        $table_name,
        array(
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'photo' => $data['photo'],
            'couverture' => $data['couverture'],
            'groupe_id' => $data['groupe_id'],
        ),
        array('id' => $client_id)
    );
}
function insert_client($data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'clients';

    $wpdb->insert(
        $table_name,
        array(
            'nom' => $data['nom'],
            'prenom' => $data['prenom'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'photo' => $data['photo'],
            'couverture' => $data['couverture'],
            'groupe_id' => $data['groupe_id'],
        )
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if($_REQUEST["option"] =="insertclient"):
        $nom = sanitize_text_field($_POST["nom"]);
        $prenom = sanitize_text_field($_POST["prenom"]);
        $email = sanitize_email($_POST["email"]);
        $telephone = sanitize_text_field($_POST["telephone"]);

        $photo = esc_url($_POST["photo"]); // Assurez-vous que la photo est une URL
        $couverture = esc_url($_POST["couverture"]); // Assurez-vous que la couverture est une URL
        $groupe_id = intval($_POST["groupe_id"]); // Assurez-vous que le groupe_id est un entier
        insert_client(array(
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'telephone' => $telephone,
            'photo' => $photo,
            'couverture' => $couverture,
            'groupe_id' => $groupe_id,
        ));
    endif;
}
function display_clients_list() {
    $clients = get_clients();

    if ($clients) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Email</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        foreach ($clients as $client) {
           
            echo '<tr>';
            echo '<td>' . $client['nom'] . '</td>';
            echo '<td>' . $client['prenom'] . '</td>';
            echo '<td>' . $client['email'] . '</td>';
            echo '<td>';
            echo '<div class="buttons">';
            echo '<a href="?page=prodata_clients&action=edit_client&id=' . $client['id'] . '">Modifier</a>';
            echo '<a href="?page=prodata_clients&action=delete_client&id=' . $client['id'] . '">Supprimer</a>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';

        }
        echo '</table>';
    } else {
        echo 'Aucun client trouvé.';
    }
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'edit_client':
            if (isset($_GET['id'])) {
                $client_id = intval($_GET['id']);
            }
            break;

        case 'delete_client':
            if (isset($_GET['id'])) {
                $client_id = intval($_GET['id']);
                delete_client($client_id);
                
            }
            break;


        default:
            break;
    }
}

