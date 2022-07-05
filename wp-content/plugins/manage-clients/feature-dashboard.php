<?php 


if (!isset($_GET['user_id'])) header('Location: ./admin.php?page=manage_clients');
define('USER_ID', $_GET['user_id']);
$user = get_user_by('ID', USER_ID);
?>

<h1 class="cva">CVA</h1>

<div class="manage-clients dashboard-cont">

    <h1>Tableau de bord de <?php echo get_user_meta(USER_ID, 'lastname', true) ?> <?php echo get_user_meta(USER_ID, 'firstname', true) ?></h1>
    <p class="subtitle">(<?php echo $user->user_login; ?>)</p>

    <?php get_template_part('template-parts/my-account/parts/dashboard'); ?>
</div>

<?php require_once 'parts/client-actions.php'; ?>