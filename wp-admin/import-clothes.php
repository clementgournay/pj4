<?php

require_once 'admin.php';

$products = json_decode(file_get_contents('../import/products.json'));

foreach($products as $product) {
    $search_products = wc_get_products([
        'reference' => $product->reference,
        'limit' => 1
    ]);
    if (count($search_products) > 0) {

        wcproduct_add_attributes($search_products[0]->get_id(), [
            'setup' => $product->setup,
            'ready' => $product->ready,
            'proposal' => $product->proposal,
            'cut' => $product->cut,
            'brand' => $product->brand,
            'length' => $product->length, 
            'sleeve' => $product->sleeve,
            'neck' => $product->neck
        ]);
        
        $category = get_term_by('slug', $product->category, 'product_cat');
        if ($category) {
            $cat_id = $category->term_id;
            $search_products[0]->set_category_ids([$cat_id]);

            $search_products[0]->save();

            $file = $product->id.'.jpg';
            $file_path = ABSPATH.'/import/'.$file;
            chmod($file_path, 777);

            $new_file_path = wp_upload_dir()['path'].'/'.$file;
            copy($file_path, $new_file_path);

            $upload_id = wp_insert_attachment(array(
                'guid'           => $file, 
                'post_mime_type' => 'image/jpeg',
                'post_title'     => preg_replace('/\.[^.]+$/', '', $product->reference),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ), $new_file_path);

            // wp_generate_attachment_metadata() won't work if you do not include this file
            require_once(ABSPATH.'wp-admin/includes/image.php');

            // Generate and save the attachment metas into the database
            wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));

            set_post_thumbnail($search_products[0]->get_id(), $upload_id);
        }
    }
}
