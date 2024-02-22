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
    $nom = sanitize_text_field($_POST["nom"]);
    $prenom = sanitize_text_field($_POST["prenom"]);
    $email = sanitize_email($_POST["email"]);
    $telephone = sanitize_text_field($_POST["telephone"]);
    
    $photo = esc_url($_POST["photo"]); // Assurez-vous que la photo est une URL
    $couverture = esc_url($_POST["couverture"]); // Assurez-vous que la couverture est une URL
    $groupe_id = intval($_POST["groupe_id"]); // Assurez-vous que le groupe_id est un entier

    // Validez les données ici

    // Insérez les données dans la base de données
    insert_client(array(
        'nom' => $nom,
        'prenom' => $prenom,
        'email' => $email,
        'telephone' => $telephone,
        'photo' => $photo,
        'couverture' => $couverture,
        'groupe_id' => $groupe_id,
    ));
}
