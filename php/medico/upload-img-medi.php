<?php

if(!empty($_FILES['imagen']['name'])){
    if(!empty($_FILES['imagen']["type"])){
        $temporary = explode(".", $_FILES['imagen']["name"]);
        $file_extension = end($temporary);
        $fileName = $_POST["cedula_medi"].".".$file_extension;
        $valid_extensions = array("jpeg", "jpg", "png");
        if((($_FILES["imagen"]["type"] == "image/png") || ($_FILES['imagen']["type"] == "image/jpg") || ($_FILES['imagen']["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['imagen']['tmp_name'];
            $targetPath = "../../assets/images/medico/".$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                echo($fileName);
            }
        }
    }
}

?> 