<?php 

    function dd($value) {
        echo "<pre>";
        var_dump($value);
        echo "</pre>";
        
        die();
    }

    function zero_pad($n, $v) {
        return str_pad($v, $n, '0', STR_PAD_LEFT); 
    }

    function rndname($ft, $fp){
        $str=$fp."_";
        $dt=date('Ymd');
        $now=substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"),0,5);
        $str.=$dt.$now.".".$ft;
        return $str;
    }

    function uploadFile($FILES, $per_usr_id, $folder){

        $resUpfile = array( 
            'status' => 0, 
            'res' => ''
        );

        $fileName = basename($FILES["name"]);

        $uploadDir = "../img/" . $folder . "/";
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        $filenameNew = rndname($ext, $per_usr_id);
        $targetFilePath = $uploadDir . $filenameNew;
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if(in_array(strtolower($ext), $allowTypes)){
            move_uploaded_file($FILES["tmp_name"], $targetFilePath);

            $resUpfile['status'] = 1;
            $resUpfile['res'] =  $filenameNew;

            return $resUpfile;
        }else {
            $resUpfile['status'] = 99;
            $resUpfile['res'] =  "เลือก ไฟล์ภาพ .jpeg / .jpg / .png / .gif";

            return $resUpfile;
        }

        return $resUpfile;
    }
?>