
<?php require_once '../wp-config.php'; ?>

<!doctype html>
<html>
<head>
    <title>Ticket de caisse #</title>

    <?php if (isset($_GET['id'])): ?>
        <meta property="og:url" content="<?php echo get_site_url(); ?>/user-looks/?id=<?php echo $_GET['id']; ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Personal Shopper" />
        <meta property="og:description" content="Mon look créé sur Personal Shopper" />
        <meta property="og:image" content="<?php echo get_site_url(); ?>/wp-content/uploads/looks/<?php echo $_GET['id']; ?>.png">';
    <?php endif; ?>

    <link rel="stylesheet" href="./style.css">

    <?php get_header(); ?>

</head>
<body>

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v12.0" nonce="HXc0sFTM"></script>

    <?php 
        if (isset($_GET['id'])) {
            $URL = get_site_url().'/user-looks/?id='.$_GET['id'];
            ?>
            <h1>Look utilisateur</h1>
            <p>Voici mon look créé avec l'assistant de création de look:</p>
            <img class="look-img" src="<?php echo get_site_url(); ?>/wp-content/uploads/looks/<?php echo $_GET['id']; ?>.png">
            <div class="actions">
                <a class="btn" href="<?php echo get_site_url(); ?>/mon-compte/privatisation/planifier">Réserver en boutique</a>
                <a class="btn" href="<?php echo get_site_url(); ?>/mon-compte/dressing/creer-look">Créer un look</a>
            </div>
            <div class="sns-share">
                <div class="fb-share-button" data-href="<?php echo $URL; ?>" data-layout="button_count" data-size="small">
                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u='<?php echo $URL; ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Partager</a>
                </div>
            </div>
            <?php
        } else {
            echo 'L\'URL entrée est invalide.';
        }
    ?>

<?php get_footer(); ?>