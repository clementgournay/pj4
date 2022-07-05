<div class="client-actions">
    <p><?php echo get_user_meta(USER_ID, 'firstname', true); ?> <?php echo get_user_meta(USER_ID, 'lastname', true); ?></p>
    <a class="btn" href="./admin.php?page=manage_clients&feature=dashboard&user_id=<?php echo USER_ID; ?>">Tableau de bord</a> 
    <a class="btn" href="./admin.php?page=manage_clients&feature=dressing&user_id=<?php echo USER_ID; ?>">Dressing</a> 
    <a class="btn" href="./admin.php?page=manage_clients&feature=looks&user_id=<?php echo USER_ID; ?>">Proposer un look</a> 
    <a class="btn" href="./admin.php?page=manage_clients&feature=measurement&user_id=<?php echo USER_ID; ?>">Mensurations</a> 
</div>
<div class="controls">
    <a class="get-back" href="./admin.php?page=manage_clients">Retour à la liste des clients</a>
</div>