<?php


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

   
    if ( empty( $_POST['name'] ) || empty( $_POST['email'] ) || empty( $_POST['password'] ) || empty( $_FILES['profile_pic'] ) ) {
        die( 'All fields are required.' );
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $profile_pic = $_FILES['profile_pic'];

    
    if ( !filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
        die( 'Invalid email format.' );
    }


    $upload_dir = 'uploads/';
    $filename = uniqid() . '_' . date( 'Y-m-d_H-i-s' ) . '_' . $profile_pic['name'];

    if ( !move_uploaded_file( $profile_pic['tmp_name'], $upload_dir . $filename ) ) {
        die( 'Error uploading file.' );
    }

    $data = array( $name, $email, $filename );
    $file = fopen( 'users.csv', 'a' );

    if ( fputcsv( $file, $data ) === false ) {
        die( 'Error writing to file.' );
    }

    fclose( $file );

    
    session_start();
    setcookie( 'username', $name );

   
    header( 'Location: success.php' );
    exit();
}

?>