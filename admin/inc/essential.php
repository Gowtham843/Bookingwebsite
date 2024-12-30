<?php 
//frontend upload process needs this data 

define('SITE_URL','http://127.0.0.1/bookingwebsite/');
define('ABOUT_IMG_PATH',SITE_URL.'images/about/');
define('CAROUSEL_IMG_PATH',SITE_URL.'images/carousel/');
define('FACILITIES_IMG_PATH',SITE_URL.'images/facilities/');
define('ROOMS_IMG_PATH',SITE_URL.'images/rooms/');
define('USERS_IMG_PATH',SITE_URL.'images/users/');

// email and name of the admin how sends gmail to users
define('USER_EMAIL','rameshm9535052257@gmail.com');
define('EMAIL_PASS','klveomyqdztmqowz');
define('USER_NAME','Dequeue');



//Phone payment methods call back url
define('CALL_BACK_URL','http://localhost/bookingwebsite/pay_response.php');

//backend upload process needs this data 
define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/bookingwebsite/images/');
define('ABOUT_FOLDER','about/');
define('CAROUSEL_FOLDER','carousel/');
define('FACILITIES_FOLDER','facilities/');
define('ROOMS_FOLDER','rooms/');
define('USERS_FOLDER','users/');

function adminLogin(){
    session_start();
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
        echo"<script>
            window.location.href='index.php';
        </script>";
        exit;
    }
}

function redirect($url){
    echo"<script>
        window.location.href='$url';
    </script>";
    exit;
}

function alert($type,$msg){
  
    echo <<<alert
            <div class="alert alert-$type alert-dismissible fade show custom-alert" role="alert">
              <strong class="me-3">$msg</strong>.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
           </div>
          alert;
}


function uploadImage($image,$folder){
    $VALID=['image/jpeg','image/png','image/webp'];
    $imge=$image['type'];

    if (!in_array($imge,$VALID)) {
        return 'inv_img'; // returning ivaild image anta...!
    }
    else if(($image['size']/(1024*1024))>2){
        return "Image_size_is_more";// Image is too large..!
    }else{
        $ext=pathinfo($image['name'],PATHINFO_EXTENSION);
        $newName='IMG_'.random_int(11111,99999).".$ext";
        $img_path=UPLOAD_IMAGE_PATH.$folder.$newName;
        
        if(move_uploaded_file($image['tmp_name'],$img_path)){
            return $newName;
        }else{
            return "Error_in_Uploading_the_file.";
        }
    }


}


function uploadsvgImage($image,$folder){
    $VALID=['image/svg+xml'];
    $imge=$image['type'];

    if (!in_array($imge,$VALID)) {
        return 'inv_img'; // returning ivaild image anta...!
    }
    else if(($image['size']/(1024*1024))>1){
        return "Image_size_is_more";// Image is too large..!
    }else{
        $ext=pathinfo($image['name'],PATHINFO_EXTENSION);
        $newName='IMG_'.random_int(11111,99999).".$ext";
        $img_path=UPLOAD_IMAGE_PATH.$folder.$newName;
        
        if(move_uploaded_file($image['tmp_name'],$img_path)){
            return $newName;
        }else{
            return "Error_in_Uploading_the_file.";
        }
    }


}

function deleteImage($image,$folder){
    // unlink is used delete files
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
        return true;
    }else{
        return false;
    }
}


function uploadUserImage($image){
    $VALID=['image/jpeg','image/png','image/webp'];
    $imge=$image['type'];

    if (!in_array($imge,$VALID)) {
        return 'inv_img'; // returning ivaild image anta...!
    }
  else{
        $ext=pathinfo($image['name'],PATHINFO_EXTENSION);
        $newName='IMG_'.random_int(11111,99999).".jpeg";
        $img_path=UPLOAD_IMAGE_PATH.USERS_FOLDER.$newName;

        if ($ext =='png' ||$ext =='PNG') {
           $img=imagecreatefrompng($image['tmp_name'] );  
        }else if($ext =='webp'||$ext =='WEBP'){
            $img=imagecreatefromwebp($image['tmp_name'] );  
        }else{
            $img=imagecreatefromjpeg($image['tmp_name'] );  
        }

        if(imagejpeg($img,$img_path,75)){
            return $newName;
        }else{
            return "Error_in_Uploading_the_file.";
        }
    }
}


?>