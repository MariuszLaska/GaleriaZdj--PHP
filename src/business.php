<?php

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
    $db = $mongo->wai;
    return $db;
}


function file_upload($file){
    $upload_dir = '/var/www/dev/src/web/gallery/';
    $file_name = basename($file['name']);
    $target = $upload_dir . $file_name;
    $tmp_path = $file['tmp_name'];
    if(move_uploaded_file($tmp_path, $target)){ ;
    return $target;
    }
}

function watermark_produce($file, $watermark, $type){
    $image = $file;
    $fontSize = 4;
    if($type=='image/png'){
    $newImg = imagecreatefrompng($image);
    }
    else{
        $newImg=imagecreatefromjpeg($image);
    }
    $fontColor = imagecolorallocate($newImg, 255, 0, 0);
    imagestring($newImg, $fontSize, 10, 10, $watermark, $fontColor);
    imagepng($newImg, $file . '_WM.png');
    imagedestroy($newImg);
}

function resize($file, $type){
    list($width, $height) = getimagesize($file);
    $resized_image = imagecreatetruecolor(200, 125);
    if($type=='image/png'){
        $newImg = imagecreatefrompng($file);
    }
    else{
        $newImg=imagecreatefromjpeg($file);
    }
    imagecopyresized($resized_image , $newImg, 0, 0, 0, 0, 200, 125, $width, $height);
    imagepng($resized_image , $file . '_MINI.png');
    imagedestroy($newImg);
}
function post_to_db($dir, $autor, $title, $name, $type){
    ($type=='image/jpeg' || $type=='image/jpg'? $type='jpg' : $type='png' );
    $db=get_db();

    $photo=[
        'dir' => $dir,
        'autor' => $autor,
        'title' => $title,
        'name' => $name,
        'type' => $type
    ];
    $db->photos->insertOne($photo);
}
function post_to_private($dir, $autor, $title, $name, $type, $user){
    ($type=='image/jpeg' || $type=='image/jpg'? $type='jpg' : $type='png' );
    $db=get_db();
    $photo=[
        'dir' => $dir,
        'autor' => $autor,
        'title' => $title,
        'name' => $name,
        'type' => $type,
        'user' => $user
    ];
    $db->privatephotos->insertOne($photo);
}
function get_photos(){
    $db=get_db();
    return $db->photos->find()->toArray();

}
function get_private(){
    $db=get_db();
    return $db->privatephotos->find()->toArray();
}
function find_photo($id){
    $db=get_db();
    $photos=$db->photos->find();
    foreach ($photos as $photo){
        if($photo['_id']==$id){
            return $photo;
        }
    }
}
function find_photo_private($id){
    $db=get_db();
    $photos=$db->privatephotos->find();
    foreach ($photos as $photo){
        if($photo['_id']==$id){
            return $photo;
        }
    }
}


function check_new_user_if_correct($username, $email, $password, $password2){
    if($password!=$password2){return 2;}
    $db=get_db();
    $users=$db->users->find();
    foreach($users as $user){
        if($username==$user['username']){ return 1;}
    }
    return 0;
}
function new_user($username, $email, $password){
    $db=get_db();
   // $users=$db->users->find();
    $user=[
        'username' => $username,
        'email' => $email,
        'password' => hash('tiger192,3', $password)
    ];
    $db->users->insertOne($user);
}
function login($username, $pass){
    $db=get_db();
    $users=$db->users->find();
    foreach ($users as $user){
        if($user['username']==$username){
            if($user['password']==hash('tiger192,3', $pass)){
                $_SESSION['user']=$username;
                return 0;
            }
        }
    }
    return 1;
}
function logout(){
    session_destroy();
}