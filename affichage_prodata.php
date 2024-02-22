<div id="liste_collectif">
<?php
    // Charger les données depuis le fichier JSON
    $jsonData = json_decode(file_get_contents(plugins_url('default_data/data/data_collectif.json', __FILE__)), true);

    // Boucler à travers les données JSON pour générer des éléments HTML
    foreach ($jsonData as $user) {
        ?>
        <div class="user-box">
            <div class="user-image" style="background-image: url('<?=plugins_url('default_data/images/'.$user['couverture'], __FILE__)?>');"></div>
            <img src="<?=plugins_url('default_data/images/'.$user['photo'], __FILE__)?>" alt="User Photo">
            <div class="user-info">
                <h2><?=$user['nom']?>&nbsp;<?=$user['prenom']?></h2>
                <p>Email:&nbsp;<?=$user['email']?></p>
                <p>Téléphone:&nbsp;<?=$user['telephone']?></p>
            </div>
            <button class="connect-btn">Contacter</button>
        </div>

        <?php
    }
    ?>
</div>
