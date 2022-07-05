<?php


if (isset($_POST['send_photo']) && isset($_FILES['photo']) && $_FILES['photo']['tmp_name'] !== '') {


    $wordpress_upload_dir = wp_upload_dir();
    
    $i = 1; // number of tries when the file with the same name is already exists
    $photo = $_FILES['photo'];
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $photo['name'];
    $new_file_mime = mime_content_type( $photo['tmp_name'] );


    if( empty( $photo ) )
        die( 'File is not selected.' );

    if( $photo['error'] )
        die( $photo['error'] );
        
    if( $photo['size'] > wp_max_upload_size() )
        die( 'It is too large than expected.' );
        
    if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
        die( 'WordPress doesn\'t allow this type of uploads.' );
        
    while( file_exists( $new_file_path ) ) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $photo['name'];
    }

    // looks like everything is OK
    if( move_uploaded_file( $photo['tmp_name'], $new_file_path ) ) {
	
        $upload_id = wp_insert_attachment( array(
            'guid'           => $new_file_path, 
            'post_mime_type' => $new_file_mime,
            'post_title'     => preg_replace( '/\.[^.]+$/', '', $photo['name'] ),
            'post_content'   => '',
            'post_status'    => 'inherit'
        ), $new_file_path );

        // wp_generate_attachment_metadata() won't work if you do not include this file
        require_once( ABSPATH . 'wp-admin/includes/image.php' );

        // Generate and save the attachment metas into the database
        wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

        set_post_thumbnail($_POST['product_id'], $upload_id);
    }

}