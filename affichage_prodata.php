<div id="liste_collectif">
<?php
    foreach ($jsonData as $_user) {
        $user = (array)$_user;
        ?>
        <div class="user-box">
            <div class="user-image" style="background-image: url('<?=plugins_url('images/'.$user['couverture'], __FILE__)?>');"></div>
            <img src="<?=plugins_url('images/'.$user['photo'], __FILE__)?>" alt="User Photo">
            <div class="user-info">
                <h2><?=$user['nom']?>&nbsp;<?=$user['prenom']?></h2>
                <p>Email:&nbsp;<?=$user['email']?></p>
                <p>Téléphone:&nbsp;<?=$user['telephone']?></p>
                
            </div>
            <button class="connect-btn" onclick="afficherPopup()">Contacter</button>
        </div>
        <?php
    }
    ?>
</div>
