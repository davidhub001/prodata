<?php 


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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(array_key_exists("option",$_REQUEST)):
        if($_REQUEST["option"] =="insertgroup"):
            $nom_groupe = sanitize_text_field($_POST["nomGroupe"]);
            insert_groupe(array('nom_groupe' => $nom_groupe));
        endif;
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
        if($_REQUEST["option"] =="liste_data_select"):
           $GLOBALS["prodata_liste"] = get_clients_group($_POST["liste_data_select"]);
        endif;
    endif;
}
