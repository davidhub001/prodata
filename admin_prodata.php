
<div id="prodata">
    <?php 
    if($_REQUEST["page"] == "prodata_groupes"):
    ?>
    <form action="#" method="post">
            <label for="nomGroupe">Nom du Groupe :</label>
            <input type="text" id="nomGroupe" name="nomGroupe" required>

            <input type="submit" value="Ajouter Groupe">
    </form>
    <?php 
    endif;
    if($_REQUEST["page"] == "prodata_clients"):
    ?>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" required>

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="telephone">Téléphone :</label>
        <input type="tel" id="telephone" name="telephone" required>

        <label for="groupe">Groupe :</label>
        <select id="groupe" name="groupe" required>
            <option value="groupe1">Groupe 1</option>
            <option value="groupe2">Groupe 2</option>
            <!-- Ajoutez d'autres options selon vos besoins -->
        </select>

        <label for="photo">Photo de profil :</label>
        <input type="file" id="photo" name="photo" accept="image/*" required>

        <label for="couverture">Photo de couverture :</label>
        <input type="file" id="couverture" name="couverture" accept="image/*" required>

        <input type="submit" value="Soumettre">
    </form>
    <?php 
    endif;

    if($_REQUEST["page"] == "prodata_admin"):
        echo "liste des client";
    endif;
    ?>
</div>