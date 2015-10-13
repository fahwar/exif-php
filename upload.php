<?php

	if(isset($_FILES['image'])){
		$errors	    = array();
		$file_name  = $_FILES['image']['name'];
		$file_size  = $_FILES['image']['size'];
		$file_tmp   = $_FILES['image']['tmp_name'];
		$file_type  = $_FILES['image']['type'];   
		$file_ext   = strtolower(end(explode('.',$_FILES['image']['name'])));
		
		$expensions = array("jpeg","jpg"); 		
		if(in_array($file_ext,$expensions) === false){
			$errors[] ="Jenis berkas tidak diijinkan!";
		}
		if($file_size > 10485760){
		$errors[] = 'Ukuran berkas harus kurang dari 10MB';
		}				
		if(empty($errors) == true){
			$new_file_name = rand(1,99999);
			move_uploaded_file($file_tmp,"images/".$new_file_name.".jpg");
			$image = "images/".$new_file_name.".jpg";
			include "hasil.php";
		} else {
			print_r($errors);
		}
	}
?>
