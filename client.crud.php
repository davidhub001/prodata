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
        $photo = " ";
        $couverture = " ";

        $groupe_id = intval($_POST["groupe_id"]); 
        $photo = "test.png";
        $couverture = "test.png";
        if(upload_image($_FILES, "photo")){
            $photo = upload_image($_FILES, "photo");
        }
        if(upload_image($_FILES, "couverture")){
            $couverture = upload_image($_FILES, "couverture");
        }
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
function upload_image($data, $champ){
    if (isset($data[$champ]) && $data[$champ]['error'] === 0) {
        $file = $data[$champ];

        $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
        $file_info = pathinfo($file['name']);
        $file_extension = strtolower($file_info['extension']);
        if (!in_array($file_extension, $allowed_extensions, true)) {
            wp_send_json_error('Type de fichier non pris en charge');
        }

        $path = __DIR__.'/images';
        $file_name = $file['name'];
        $file_path = trailingslashit($path) . $file_name;
        move_uploaded_file($file['tmp_name'], $file_path);
        return $file_name;
        // wp_send_json_success(array('file_path' => $file_path));
    } else {
        // wp_send_json_error('Aucun fichier téléchargé');
        return false;
    }
}
function display_clients_list() {
    $clients = get_clients();

    if ($clients) {
        echo '<table>';
        echo '<tr>';
        echo '<th>Photo</th>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Email</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        foreach ($clients as $client) {
           
            echo '<tr>';
            echo '<td><img class="img_prodata" src="'. plugins_url("prodata/images/").$client["photo"]. '" ></td>';
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

