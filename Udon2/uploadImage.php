<?php 
    require '../inc/function.php';

    $response = array( 
        'status' => 0, 
        'res' => ''
    );

    $action = trim($_POST["action"]);

    switch($action){

        case "register" :

            $memID = trim($_POST["memID"]);

            if(!empty($_FILES["file"])) {

                
                $resUpfile = uploadFile($_FILES["file"], $memID, "reg");

                if($resUpfile['status'] == 1){
                    $response['status'] = 1;
                    $response['res'] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $response['res'] = $resUpfile['res'];
                    $response['status'] = 99;
                }
            }else {
                $response['status'] = 99;
                $response['res'] = "ไม่สามารถอัพโหลดไฟล์ได้";
            }

        break;

        case "newform01" :
            $memID = trim($_POST["memID"]);
            if(!empty($_FILES["file"])) {

                $resUpfile = uploadFile($_FILES["file"], $memID, "newform01");

                if($resUpfile['status'] == 1){
                    $response['status'] = 1;
                    $response['res'] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $response['res'] = $resUpfile['res'];
                    $response['status'] = 99;
                }
            }else {
                $response['status'] = 99;
                $response['res'] = "ไม่สามารถอัพโหลดไฟล์ได้";
            }
        break;

        case "form01" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "form01");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "form01");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_3"])) {
                $resUpfile = uploadFile($_FILES["file_3"], $memID, "form01");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[3] = 1;
                    $resUploadFile[3] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[3] = 99;
                    $resUploadFile[3] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_4"])) {
                $resUpfile = uploadFile($_FILES["file_4"], $memID, "form01");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[4] = 1;
                    $resUploadFile[4] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[4] = 99;
                    $resUploadFile[4] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;

        break;

        case "n_form05_1" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form05_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form05_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form06_1" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form06_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form06_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form06_2" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form06_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form06_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form06_3" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form06_3");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form06_3");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form07_1" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form07_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form07_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }else {
                $statusUploadFile[2] = 2;
                $resUploadFile[2] = "-";
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form07_2" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form07_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form07_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }else {
                $statusUploadFile[2] = 2;
                $resUploadFile[2] = "-";
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form08_2" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form08_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form08_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "n_form09" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "n_form09");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "n_form09");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;
        break;

        case "form11_1" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "form11_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "form11_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_3"])) {
                $resUpfile = uploadFile($_FILES["file_3"], $memID, "form11_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[3] = 1;
                    $resUploadFile[3] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[3] = 99;
                    $resUploadFile[3] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_4"])) {
                $resUpfile = uploadFile($_FILES["file_4"], $memID, "form11_1");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[4] = 1;
                    $resUploadFile[4] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[4] = 99;
                    $resUploadFile[4] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;

        break;

        case "form11_2" :
            $memID = trim($_POST["memID"]);
            $statusUploadFile = array();
            $resUploadFile = array();

            if(!empty($_FILES["file_1"])) {
                $resUpfile = uploadFile($_FILES["file_1"], $memID, "form11_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[1] = 1;
                    $resUploadFile[1] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[1] = 99;
                    $resUploadFile[1] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_2"])) {
                $resUpfile = uploadFile($_FILES["file_2"], $memID, "form11_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[2] = 1;
                    $resUploadFile[2] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[2] = 99;
                    $resUploadFile[2] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_3"])) {
                $resUpfile = uploadFile($_FILES["file_3"], $memID, "form11_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[3] = 1;
                    $resUploadFile[3] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[3] = 99;
                    $resUploadFile[3] = $resUpfile['res'];
                }
            }

            if(!empty($_FILES["file_4"])) {
                $resUpfile = uploadFile($_FILES["file_4"], $memID, "form11_2");

                if($resUpfile['status'] == 1){
                    $statusUploadFile[4] = 1;
                    $resUploadFile[4] = $resUpfile['res'];
                }else if ($resUpfile['status'] == 99)  {
                    $statusUploadFile[4] = 99;
                    $resUploadFile[4] = $resUpfile['res'];
                }
            }

            $response['status'] = $statusUploadFile;
            $response['res'] = $resUploadFile;

        break;

    }

    echo json_encode($response);
?>