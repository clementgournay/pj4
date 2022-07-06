<?php

require_once 'admin.php';

$products = json_decode(file_get_contents('export/clothes.json'));

foreach($products as $product) {
    $search_products = wc_get_products([
        'reference' => $product->reference,
        'limit' => 1
    ]);
    if (count($search_products) > 0) {

        wcproduct_add_attributes($search_products[0]->get_id(), [
            'setup' => 'true',
            'ready' => 'true',
            'proposal' => 'true',
            'cut' => $product->cut,
            'brand' => $product->brand,
            'length' => $product->length, 
            'sleeve' => $product->sleeve,
            'neck' => $product->neck
        ]);
        $search_products[0]->save();

        $file = $product->reference.'.jpg';
        $file_path = './export/'.$file;

        $new_file_path = wp_upload_dir()['path'] . '/' . $file;
        copy($file_path, $new_file_path);

        //if( move_uploaded_file('./export/'.$file, $new_file_path ) ) {
            $upload_id = wp_insert_attachment( array(
                'guid'           => $file, 
                'post_mime_type' => 'image/jpeg',
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $product->reference ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ), $new_file_path);
    
            // wp_generate_attachment_metadata() won't work if you do not include this file
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
    
            // Generate and save the attachment metas into the database
            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
    
            set_post_thumbnail($search_products[0]->get_id(), $upload_id);
        //}
    }
}
