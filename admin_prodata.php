
<div id="prodata">
    <?php 
    if($_REQUEST["page"] == "prodata_groupes"):
    ?>
    <form action="admin.php?page=prodata_groupes&option=insertgroup" method="post">
            <label for="nomGroupe">Nom du Groupe :</label>
            <input type="text" id="nomGroupe" name="nomGroupe" required>

            <input type="submit" value="Ajouter Groupe">
    </form>

    <?php 
    display_groupes_list();

    endif;
    if($_REQUEST["page"] == "prodata_clients"):
    ?>
    <form action="admin.php?page=prodata_clients&option=insertclient" method="post" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required>

        <label for="groupe">Groupe :</label>
        <select id="groupe_id" name="groupe_id" required>
            <?php 
                $groupes = get_groupes();

                if ($groupes) {
                    foreach ($groupes as $groupe) {
                        ?>
                            <option value="<?=$groupe['groupe_id']?>"><?=$groupe['nom_groupe']?></option>
                        <?php
                    }
                } else {
                    ?>
                        <option value="0"></option>
                    <?php
                }
            ?>
        </select>

        <label for="photo">Photo de profil :</label>
        <input type="file" id="photo" name="photo" accept="image/*" >

        <label for="couverture">Photo de couverture :</label>
        <input type="file" id="couverture" name="couverture" accept="image/*" >

        <input type="submit" value="Soumettre">
    </form>
    
    <?php 
    display_clients_list();
    endif;

    if($_REQUEST["page"] == "prodata_admin"):
        echo "liste des client";
    endif;
    ?>
</div>
