<?php

class ImageUpload
{
	private $id;
	private $catransid;
	private $path;
	private $type;
	private $createdat;
	private $addedby;

	

	protected $connect;

	public function __construct()
	{
		require_once('../connect_me.php');

		$db = new Database_connection();

		$this->connect = $db->connect();
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function getId()
	{
		return $this->id;
	}

	function setCatransid($catransid)
	{
		$this->catransid = $catransid;
	}

	function getCatransid()
	{
		return $this->catransid;
	}

	function setPath($path)
	{
		$this->path = $path;
	}

	function getPath()
	{
		return $this->path;
	}

	function setType($type)
	{
		$this->type = $type;
	}

	function getType()
	{
		return $this->type;
	}

	function setCreatedat($createdat)
	{
		$this->createdat = date('Y-m-d H:i:s');
	}

	function getCreatedat()
	{
		return $this->createdat;
	}

	function setAddedby($addedby)
	{
		$this->addedby = $addedby;
	}

	function getAddedby()
	{
		return $this->addedby;
	}

	function saveRedeemimage($redeem_images) {
	    $images = explode('|', $redeem_images);
	    $savedImages = [];

	    foreach ($images as $encodedImage) {
	        $encodedImage = trim($encodedImage);
	        if (!empty($encodedImage)) {
	        	$image_parts = explode(";base64,", $encodedImage);
	        	$image_type_aux = explode("image/", $image_parts[0]);
	            $image_type = $image_type_aux[1];
	        	
	        	// exit;

	            $result = $this->saveImage(base64_decode($image_parts[1]));
	            if ($result) {
	                // echo "Image saved successfully: $result<br>";
	                 $savedImages[] = $result;
	               

	            } else {
	                echo "Failed to save an image.<br>";
	            }
	        }
	    }
	    return $savedImages;
	}


	private function saveImage($imagedata) {
	    // Determine the image format from the base64 data
	    $imageFormat = $this->getImageFormat($imagedata);

	    if (!$imageFormat) {
	        echo "Error: Unsupported image format. Skipping.<br>";
	        return false;
	    }

	    // Map the image format to a file extension
	    $validExtensions = [
	        'image/jpeg' => 'jpg',
	        'image/png' => 'png',
	        'image/gif' => 'gif',
	        // Add more formats as needed
	    ];

	    $extension = isset($validExtensions[$imageFormat]) ? $validExtensions[$imageFormat] : 'png';
	    $newName = rand() . '.' . $extension;
	    $destination = '../assets/images/uploads/' . $newName;

	    if (file_put_contents($destination, $imagedata) !== false) {
	        return $newName;
	    } else {
	        echo "Error: Failed to save the image.<br>";
	        return false;
	    }
	}


	private function getImageFormat($imagedata) {
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
	    return finfo_buffer($finfo, $imagedata);
	}


	function saveUploadimages(){

	 $query="
        INSERT INTO img_upload (catransid,path,type,createdat,addedby) 
        VALUES (?,?,?,?,?)
        ";

        $statement = $this->connect->prepare($query);

		$statement->bind_param('issss',$this->catransid,$this->path,$this->type,$this->createdat,$this->addedby);
		
		if($statement->execute()){

			return true;
		}
		else{

			return false;
		}

	}

	function getRedeemImages($type){

		$query="SELECT * FROM `img_upload` 
			where catransid=? AND type='$type'
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->catransid);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $images = $result->fetch_all();
		}
		else
		{
			$images = array();
			
		}

		$statement->close();

		return $images;

	}

	function getUnpaidRedeemImages($type){
		
		$query="SELECT * FROM `img_upload` 
			where catransid=? AND type='$type'
		";

		$statement = $this->connect->prepare($query);
		$statement->bind_param('i', $this->catransid);
        // print_r($query);

		if($statement->execute())
		{
			$result = $statement->get_result();
            $images = $result->fetch_all();
		}
		else
		{
			$images = array();
			
		}

		$statement->close();

		return $images;

	}

	function saveGamesimage($redeem_images) {
	    $images = explode('|', $redeem_images);
	    $savedImages = [];

	    foreach ($images as $encodedImage) {
	        $encodedImage = trim($encodedImage);
	        if (!empty($encodedImage)) {
	        	$image_parts = explode(";base64,", $encodedImage);
	        	$image_type_aux = explode("image/", $image_parts[0]);
	            $image_type = $image_type_aux[1];
	        	
	        	// exit;

	            $result = $this->saveGameImage(base64_decode($image_parts[1]));
	            if ($result) {
	                // echo "Image saved successfully: $result<br>";
	                 $savedImages[] = $result;
	               

	            } else {
	                echo "Failed to save an image.<br>";
	            }
	        }
	    }
	    return $savedImages;
	}


	private function saveGameImage($imagedata) {
	    // Determine the image format from the base64 data
	    $imageFormat = $this->getGameImageFormat($imagedata);

	    if (!$imageFormat) {
	        echo "Error: Unsupported image format. Skipping.<br>";
	        return false;
	    }

	    // Map the image format to a file extension
	    $validExtensions = [
	        'image/jpeg' => 'jpg',
	        'image/png' => 'png',
	        'image/gif' => 'gif',
	        // Add more formats as needed
	    ];

	    $extension = isset($validExtensions[$imageFormat]) ? $validExtensions[$imageFormat] : 'png';
	    $newName = rand() . '.' . $extension;
	    $destination = '../assets/images/gamesscore/' . $newName;

	    if (file_put_contents($destination, $imagedata) !== false) {
	        return $newName;
	    } else {
	        echo "Error: Failed to save the image.<br>";
	        return false;
	    }
	}


	private function getGameImageFormat($imagedata) {
	    $finfo = finfo_open(FILEINFO_MIME_TYPE);
	    return finfo_buffer($finfo, $imagedata);
	}


	function getAllImages() {
	    // Prepare the SQL query to select all images based on catransid
	    $query = "SELECT * FROM `img_upload` WHERE catransid = ? ORDER BY createdat DESC";

	    // Initialize the prepared statement
	    $statement = $this->connect->prepare($query);
	    
	    // Bind the catransid parameter to the query
	    $statement->bind_param('i', $this->catransid);

	    // Initialize an empty array to hold the images
	    $images = array();

	    // Execute the query
	    if ($statement->execute()) {
	        // Fetch the result set from the executed query
	        $result = $statement->get_result();
	        
	        // Fetch all results as an associative array
	        $images = $result->fetch_all(MYSQLI_ASSOC);  // Use MYSQLI_ASSOC for associative array
	    }

	    // Close the statement
	    $statement->close();

	    // Return the array of images
	    return $images;
	}


}

?>