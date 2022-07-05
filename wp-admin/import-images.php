<?php

require_once 'admin.php';

$folder = scandir('./export');

foreach($folder as $file) {
    if ($file !== '.' && $file !== '..') {
        $without_ext = str_replace('.jpg', '', $file);
        $ref = strtoupper($without_ext);
        $products = wc_get_products([
            'reference' => $ref,
            'limit' => 1
        ]);
        if (count($products) > 0) {

            wcproduct_add_attributes($products[0]->get_id(), [
                'setup' => 'true',
                'ready' => 'true'
            ]);
            $products[0]->save();

            $new_file_path = $wordpress_upload_dir['path'] . '/' . $file;
            if( move_uploaded_file('./export/'.$file, $new_file_path ) ) {
                $upload_id = wp_insert_attachment( array(
                    'guid'           => $file, 
                    'post_mime_type' => 'image/jpeg',
                    'post_title'     => preg_replace( '/\.[^.]+$/', '', $without_ext ),
                    'post_content'   => '',
                    'post_status'    => 'inherit'
                ), $new_file_path );
        
                // wp_generate_attachment_metadata() won't work if you do not include this file
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
        
                // Generate and save the attachment metas into the database
                wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
        
                set_post_thumbnail($product->get_id(), $upload_id);
            }
        }
    }
}