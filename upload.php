<?php
for($i=0; $i<count($_FILES['file']['name']); $i++){
$target_path = "sounds/";

    $target_path = $target_path . utf8_decode($_FILES['file']['name'][$i]); 
	
	echo "target_path = ".$target_path."\n";

    if(move_uploaded_file(utf8_decode($_FILES['file']['tmp_name'][$i]), $target_path)) {
        echo "The file has been uploaded successfully \n";
    } else{
        echo "There was an error uploading the file, please try again! \n ";
		foreach ($_FILES['file']['error'] as $e)
			echo $e."<BR />";
		
    }
}