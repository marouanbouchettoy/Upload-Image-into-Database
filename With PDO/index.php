<?php
error_reporting(0);

$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {

	$filename = $_FILES["uploadfile"]["name"];
	$tempname = $_FILES["uploadfile"]["tmp_name"];
	$folder = "./image/" . $filename;


	// connect data whit server
	$dsn = 'mysql:host=localhost;dbname=upload_image';
	$user = 'root';
	$pass = '';
	
	try {
		//check if data base there
		$con = new PDO($dsn, $user, $pass);
		//connect data with data base
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		echo 'failed' . $e->getMessage();
	}
	
	
                    // Insert Item info In The Database


                    $stmt = $con->prepare("INSERT INTO 
                                image(filename)
                            VALUES(:zfilename)");
                    $stmt->execute(array(
                        'zfilename'     => $filename
                    ));
                    
	// $db = mysqli_connect("localhost", "root", "", "test");

	// // Get all the submitted data from the form
	// $sql = "INSERT INTO image (filename) VALUES ('$filename')";

	// // Execute query
	// mysqli_query($db, $sql);


	// Now let's move the uploaded image into the folder: image
	if (move_uploaded_file($tempname, $folder)) {
		echo "<h3> Image uploaded successfully!</h3>";
	} else {
		echo "<h3> Failed to upload image!</h3>";
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Image Upload</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>

<body>
	<div id="content">
		<form method="POST" action="" enctype="multipart/form-data">
			<div class="form-group">
				<input class="form-control" type="file" name="uploadfile" value="" />
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit" name="upload">UPLOAD</button>
			</div>
		</form>
	</div>
	<div id="display-image">
		<?php
		// $query = " select * from image ";
		// $result = mysqli_query($db, $query);

		// while ($data = mysqli_fetch_assoc($result)) {
		?>
			<!-- <img src="./image/<?php //echo $data['filename']; ?>"> -->

		<?php
		// }
		?>
		<?php
			$stmt = $con->prepare("SELECT * FROM image");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable

			$datas = $stmt->fetchAll();
			
                        foreach ($datas as $data) {
							
							echo '<img src="image/' . $data['filename'] . '">';

                        }
                        
		?>
		

	</div>
</body>

</html>
