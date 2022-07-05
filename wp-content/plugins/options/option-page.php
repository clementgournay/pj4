<?php 

update_option('multibrands', isset($_POST['multibrands']));
update_option('brand_filtering', isset($_POST['brand_filtering']));

?>

<div class="options">
    <h1>Options</h1>
    <form method="POST" action="./admin.php?page=options">
        <div class="table">
            <div class="tr">
                <div class="td label">
                    <span>Multimarques</span>
                </div>
                <div class="td input">
                    <?php
                    $checked = (get_option('multibrands') == true) ? 'checked' : ''; 
                    ?>
                    <input type="checkbox" name="multibrands" value="true" <?php echo $checked; ?>>
                </div>
            </div>
            <div class="tr">
                <div class="td label">
                    <span>Filtrage par marque</span>
                </div>
                <div class="td input">
                    <?php $checked = (get_option('brand_filtering') == true) ? 'checked' : ''; ?>
                    <input type="checkbox" name="brand_filtering" <?php echo $checked; ?>>
                </div>
            </div>
        </div>
        <div class="controls">
            <button type="submit" class="btn">Sauvegarder</button> 
        </div>
    </form>
</div>