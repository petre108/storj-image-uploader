<?php

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif', 'jpeg');

if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {

    $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

    if (!in_array(strtolower($extension), $allowed)) {
        echo '{"status":"error - no image file!"}';
        exit;
    }

    if (move_uploaded_file($_FILES['upl']['tmp_name'], 'uploads/' . $_FILES['upl']['name'])) {


        //---------------
        $target_url = 'http://node1.metadisk.org/api/upload';

        //$target_url = 'http://node1.metadisk.org/accounts/token/new';  // { "token": "6Q1EfEoG8qCwkNyz" }

        $file_name_with_full_path = realpath('uploads/'.$_FILES['upl']['name']);

        $post = array('file' => '@' . $file_name_with_full_path);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        //echo " RESULT: " . $result;
        $result_array = json_decode($result, true);
        
        header("Location: index.php?filehash=".$result_array['filehash']."&key=".$result_array['key']);

        //---------------


        echo '{"status":"success"}';
        exit;
    }
}

echo '{"status":"error - other"}';
exit;
