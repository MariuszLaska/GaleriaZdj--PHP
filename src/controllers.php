<?php
require_once 'business.php';

function main(&$model){
    if(isset($_POST['photo'])||isset($_POST['autor'])||isset($_POST['watermark'])){
        if(!$_FILES['photo']){
            $model['error']='no_fill';
            return 'error_view';
        }
        if(!$_POST['autor']){
            $model['error']='no_autor';
            return 'error_view';
        }
        if(!$_POST['watermark']){
            $model['error']='no_watermark';
            return 'error_view';
        }
        if($_POST['autor']&&$_POST['watermark']){
            $zdjecie = $_FILES['photo'];
            if($zdjecie['type']!='image/png'&&$zdjecie['type']!='image/jpeg'){
                $model['error']='type_error';
                return 'error_view';
            }
            if($zdjecie['size']>1000000){
                $model['error']='size_error';
                return 'error_view';
            }
        }

        //OBSŁUGA PLIKU

        $photo_dir=file_upload($_FILES['photo']);
        watermark_produce($photo_dir, $_POST['watermark'], $_FILES['photo']['type'] );
        resize($photo_dir, $_FILES['photo']['type']);
        $file_name=($_FILES['photo']['name']);
        $file_type=($_FILES['photo']['type']);
        if(isset($_POST['private'])){
            post_to_private($photo_dir, $_POST['autor'], $_POST['title'], $file_name, $file_type,$_SESSION['user']);
            header("Location:/gallery");
        }
        else {
            post_to_db($photo_dir, $_POST['autor'], $_POST['title'], $file_name, $file_type);
            header("Location:/gallery");
        }

    }
    else{
       return 'main';
    }
}

function gallery_view (&$model){
    $photos=get_photos();
    $privatephotos=get_private();
    $model['photos']=$photos;
    $model['private']=$privatephotos;
    return 'gallery_view';
}



function photo_view (&$model){
    $photo=find_photo($_GET['id']);
    $model['path']= $photo['name'];
    return 'photo_view';
}
function private_photo_view (&$model){
    $photo=find_photo_private($_GET['id']);
    $model['path']= $photo['name'];
    return 'photo_view';
}



function new_user_view (&$model){
    // 0-ok  1-zajety login  2-różne hasła 3-pole nieuzupelnione
    @$model['error'] = check_new_user_if_correct($_POST['username'],$_POST['email'],$_POST['password'],$_POST['password2']);
    if(@$_POST['username']==""||@$_POST['email']==""||@$_POST['password']==""||@$_POST['password2']==""||@$model['error']!=0){
        if($model['error']==0){$model['error']=3;}
        return 'new_user_view';
    }
    else if ($model['error']==0){
        new_user($_POST['username'],$_POST['email'],$_POST['password']);
        header("Location:/");
    }
}