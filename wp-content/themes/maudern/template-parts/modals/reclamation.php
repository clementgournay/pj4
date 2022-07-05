<div class="modal" id="reclamations" data-endpoint="<?php echo get_template_directory_uri(); ?>/includes/claim.php" data-method="post">
    <div class="window">
        <div class="header">
            <div class="title">Réclamation</div>
            <div class="close">X</div>
        </div>
        <div class="body">

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
                <label for="claim_type">Type de réclamation</label>
                <select class="woocommerce-Select select" name="claim_type" id="claim_type">
                    <option value="change">Echange</option>
                    <option value="refund">Remboursement</option>
                </select>
            </p>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
                <label for="description">Détail de la réclamation</label>
                <textarea class="woocommerce-Textarea textarea" name="description" id="description"></textarea>
            </p>

            <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide is-active clearfix">
                <label for="photos">Photos</label>
                <input type="file" class="woocommerce-Input woocommerce-Input--file input-file" name="photos" id="photos" accept=".jpeg, .jpg, .png, .gif" multiple></input>
            </p>
        </div>
        <div class="footer">
            <button type="button" class="btn submit">Envoyer</button>
        </div>
    </div>
</div>