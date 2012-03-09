<?php
// php debuging
//ini_set('display_errors', 0);
//ini_set('log_errors', 1);
//ini_set('error_log', '/var/www/cheval-cameramiste.tiltit.org/php_errors.txt');
//error_reporting(E_USER_NOTICE);
//error_reporting(E_ERROR | E_USER_NOTICE);
//error_reporting(E_ALL);
//xdebug_disable();
/*
 *			immanager plugin for WolfCMS.
 *
 *			This plugin makes it posible to give titles and descriptions to
 *			images in the backend of a WolfCMS powered website.
 *
 *			Author : Oliver Dille
 *			Licence : GPL3
 *
 */

class ImmanagerController extends PluginController {
	
	private function is_image ($ext) {
		$types = array('png','jpg','jpeg','gif');		
		foreach ($types as $val) if (strtolower ($val) == $ext) return true; 
		return false;
	}
		
	/*
	 * Function hex2RGB
	 * 
	 * The Following function was copy pasted from php.net.
	 * http://php.net/manual/en/function.hexdec.php
	 */
	private function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
		$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
		$rgbArray = array();
		if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
			$colorVal = hexdec($hexStr);
			$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
			$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
			$rgbArray['blue'] = 0xFF & $colorVal;
		} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
			$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
			$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
			$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
		} 
		else {
			return false; //Invalid hex color code
		}
		return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
	}
			
	private function makeThumbnail($imagePath, $resizeMethod, $thumbWidth, $thumbHeight, $backgroundColor) {
	// A sharpen level parameter could be added to this.
		
		// Get file extention
		$ext = pathinfo($imagePath, PATHINFO_EXTENSION);
		// All to lower case.
    switch (strtolower($ext)) {
    	case "jpg":
    		$src_image = imagecreatefromjpeg($imagePath);
    		break;
    	case "jpeg":
    		$src_image = imagecreatefromjpeg($imagePath);
    		break;
    	case "gif":
    		$src_image = imagecreatefromgif($imagePath);
    		break;
    	case "png":
    		$src_image = imagecreatefrompng($imagePath);
    		break;
   	}
		
		// Get width and height of the source image.
		$src_w = imagesx($src_image);
		$src_h = imagesy($src_image);
		
		switch ($resizeMethod) {
			case 0:
				// Strech
				$im = imagecreatetruecolor($thumbWidth, $thumbHeight);	
				imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $thumbWidth , $thumbHeight , $src_w , $src_h );
				break;
				
			case 1:
				//Crop
				$im = imagecreatetruecolor($thumbWidth, $thumbHeight);
				$src_aspect_ratio = $src_w / $src_h;
				$thumb_aspect_ratio = $thumbWidth / $thumbHeight;
				
				if ($thumb_aspect_ratio > $src_aspect_ratio) {
					$scaledHeight = $thumbHeight * ( $src_w / $thumbWidth);
					$src_x = 0;
					$src_y = ($src_h / 2) - ($scaledHeight /2);
					imagecopyresampled ( $im , $src_image , 0 , 0 , $src_x , $src_y , $thumbWidth , $thumbHeight ,$src_w , $scaledHeight );
					
				} else {
					$scaledWidth = $thumbWidth * ( $src_h / $thumbHeight);
					$src_x = ($src_w / 2) - ($scaledWidth /2);
					$src_y = 0;
					imagecopyresampled ( $im , $src_image , 0 , 0 , $src_x , $src_y , $thumbWidth , $thumbHeight ,$scaledWidth , $src_h );		
				}
			break;
				
			case 2:
				// Frame
				$im = imagecreatetruecolor($thumbWidth, $thumbHeight);
				$bg = imagecolorallocate($im, $backgroundColor['red'], $backgroundColor['green'], $backgroundColor['blue']);
				//$bg = imagecolorallocate($im, 255, 255, 255);
				imagefilledrectangle($im, 0, 0, $thumbWidth, $thumbHeight, $bg);
				$src_aspect_ratio = $src_w / $src_h;
				$thumb_aspect_ratio = $thumbWidth / $thumbHeight;
				$src_x = 0;
				$src_y = 0;
				
				if ($thumb_aspect_ratio < $src_aspect_ratio) { 
					
					$scaledHeight = $thumbWidth * ( $src_h / $src_w);
					$dest_x = 0;
					$dest_y = $thumbHeight / 2 - $scaledHeight /2;
					$dest_w = $thumbWidth;
					$dest_h = $scaledHeight ;
					imagecopyresampled ( $im , $src_image , $dest_x , $dest_y , $src_x , $src_y , $dest_w , $dest_h ,$src_w , $src_h );	
					
				} else {
					$scaledWidth = $thumbHeight * ( $src_w / $src_h);
					$dest_x = ($thumbWidth / 2) - ($scaledWidth / 2);
					$dest_y = 0;
					$dest_w = $scaledWidth ;//
					$dest_h = $thumbHeight;
					imagecopyresampled ( $im , $src_image , $dest_x , $dest_y , $src_x , $src_y , $dest_w , $dest_h ,$src_w , $src_h );		
				}
				break;
				
			case 3:
				// Only Width
				$scaledHeight = $thumbWidth * ( $src_h /  $src_w);
				$im = imagecreatetruecolor($thumbWidth, $scaledHeight);
				imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $thumbWidth , $scaledHeight , $src_w , $src_h );
				break;
			
			case 4:
				// Only Height
				$scaledWidth = $thumbHeight * ( $src_w / $src_h);
				$im = imagecreatetruecolor($scaledWidth, $thumbHeight);
				imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $scaledWidth , $thumbHeight , $src_w , $src_h );
				break;
			case 5:
				// Longest Side
				
				if ($src_w > $src_h) {
					// Only Width
					$scaledHeight = $thumbWidth * ( $src_h /  $src_w);
					$im = imagecreatetruecolor($thumbWidth, $scaledHeight);
					imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $thumbWidth , $scaledHeight , $src_w , $src_h );
				} else {
					// Only height
					$scaledWidth = $thumbHeight * ( $src_w / $src_h);
					$im = imagecreatetruecolor($scaledWidth, $thumbHeight);
					imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $scaledWidth , $thumbHeight , $src_w , $src_h );
				}
				break;
			
			case 6:
				// Shortest Side
				if ($src_w < $src_h) {
					// Only Width
					$scaledHeight = $thumbWidth * ( $src_h / $src_w);
					$im = imagecreatetruecolor($thumbWidth, $scaledHeight);
					imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $thumbWidth , $scaledHeight , $src_w , $src_h);
				} else {
					// Only height
					$scaledWidth = $thumbHeight * ( $src_w / $src_h);
					$im = imagecreatetruecolor($scaledWidth, $thumbHeight);
					imagecopyresampled ( $im , $src_image , 0 , 0 , 0 , 0 , $scaledWidth , $thumbHeight , $src_w , $src_h );
				}
				break;
		}
		imagedestroy($src_image);
		return $im;
	}
	
	/*
	 * function folderImageList ()
	 * Ruturns a list of images from folder
	 * as an array.
	 * Returns false if no images in folder.
	 */
	private function folderImageList($folder = CMS_ROOT) {
		if ($handle = opendir($folder)) {
			while (false !== ($file = readdir($handle))) {
				// Image files are determined by ther extentions.
				if ($this->is_image(pathinfo($file, PATHINFO_EXTENSION)))
				$imageList[] = $file;
			}	
			closedir($handle);
			if (is_array($imageList)) {
				sort($imageList);
				return $imageList;
			}
		}
		return false;
	}
	
	public function __construct() {
		$this->setLayout('backend');
		$this->assignToLayout('sidebar', new View('../../plugins/immanager/views/sidebar'));
	}
	
	public function documentation() {
  	$this->display('immanager/views/documentation');
	}
	
	public function settings() {
		$this->display('immanager/views/settings', Plugin::getAllSettings('immanager'));
	}
  
	
	public function saveSettings() {
			$settings = $_POST['settings'];
       $ret = Plugin::setAllSettings($settings, 'immanager');
       if ($ret)
				Flash::set('success', __('The settings have been updated.'));
       else
				Flash::set('error', 'An error has occured.');
        redirect(get_url('plugin/immanager/settings'));
    }
	
	/* Returm a dinamicaly generated thumbnail,
	 * for the browse page.
	 */
	public function thumbnail(){
		
		// Get the image path
		$imagePath = CMS_ROOT . $_GET['path'];
		// Select resize method. 0=strech, 1=crop, 2=frame, 3=only width, 4=only height, 5=longest side, 6=shortest side;  
		$resizeMethod = $_GET['rm'];
		// Width and height of thumbnail.
		$thumbWidth = $_GET['w'];
		$thumbHeight = $_GET['h'];
		// Background color for frame method.
		$backgroundColor = $this->hex2RGB($_GET['backgroundColor']);
   	$im = $this->makeThumbnail($imagePath, $resizeMethod, $thumbWidth, $thumbHeight, $backgroundColor);
   	header('Content-Type: image/jpeg');
		imagejpeg($im);
		imagedestroy($im);
	}
	
	/* 
	 * Function for the Creat Thumnails view.
	 */
	
	public function viewThumbnails(){
    // Retrieve the plugin settings.
    $settings = Plugin::getAllSettings('immanager');
    $params = func_get_args();
		$directory = '/' . join('/', $params);
    $directory = ($directory == '/') ? $settings['ImageFolder'] : $directory;
		// Generate an aray with thumnail preview links.
		$imageList = $this->folderImageList(CMS_ROOT . $directory);
		foreach($imageList as $val) {
			$links['currentThumbnails'][] = $directory . $settings['thumbnailFolder'] .'/' . $val;
			$links['name'][]=$val;
		}
		
		/*
		 * @todo: Make an arry of links for current thumbs.
		 * 
		 */
		// Set variables to be sent to the sidebar.
		$this->assignToLayout('sidebar', new View('../../plugins/immanager/views/sidebar', array(
			'view' => 'viewThumbnails'
    )));
		
		// Add the current directory to the settings array.
    $settings['directory'] = $directory;
		// Add the preview links to the settings array.
		$settings['links'] = $links;
		
		$this->display('immanager/views/viewThumbnails', $settings);
	}
	
  /*
	 * function thumbnailSave
	 * Generates the thumbnail and saves them to disk.
	 */
  public function thumbnailSave() {
    $settings = $_POST['settings'];
		$globalSettings=Plugin::getAllSettings('immanager');
		
		//trigger_error('tS:ImageFolder:' . $settings['ImageFolder']);
		// trigger_error('tS:thumbnailFolder:' . $globalSettings['thumbnailFolder']);
		
		// Directory to create if does not exist
		$thumbnailDirectory = $settings['ImageFolder'] . $globalSettings['thumbnailFolder'];
		
		// Check if directory exist, if not create it.
		if (!is_dir(CMS_ROOT . $thumbnailDirectory)){
			if(!mkdir(CMS_ROOT . $thumbnailDirectory, 0777)){
				trigger_error('Unable to make directory.');	
				Flash::set('error', 'Cannot create directory.');
				redirect(get_url('plugin/immanager/viewThumbnails' . $settings['ImageFolder']));
			}
		}
		
		$backgroundColor = $this->hex2RGB($settings['backgroundColor']);
		// Get an array with the pictures to be procesed.
		$imageList = $this->folderImageList(CMS_ROOT . $settings['ImageFolder']);
		// Cycle throght the array create thumbs and write them to disk.
		foreach ($imageList as $val){
			$thumbnailPath = $thumbnailDirectory . DS . $val;
			$im = $this->makeThumbnail(CMS_ROOT . $settings['ImageFolder'] . DS . $val, 
							$settings['resizeMethod'],
							$settings['thumbnailWidth'],
							$settings['thumbnailHeight'],
							$backgroundColor);
			
			// Ok so now write the thumbnails to disk.
			if (!imagejpeg( $im , CMS_ROOT . $thumbnailPath )){
				Flash::set('error', __('Cannot write image file.'));
			}
			
			imagedestroy($im);
			
			// Last, look for immanagers and and add the the thumbnail path if 
			// is isnt set.
			$manager = immanager::findByPath($settings['ImageFolder'] . DS . $val);
			// If the manager exists update thumbnailPath if it needs to be.
			if($manager){
				trigger_error('manager found.');
				if($manager->thumbnailPath != $thumbnailPath) {
					$manager->thumbnailPath = $thumbnailPath;
					$manager->save();
				}
			}
		}
		Flash::set('success', __('Thumbnails successfully saved.'));
		redirect(get_url('plugin/immanager/viewThumbnails' . $settings['ImageFolder']));
  }
	
	// Using a similar method to the filemanager plugin.
	public function browse() {
    // Add javascript for the plugins index page.
		Plugin::addJavascript('immanager', 'js/flash.js');
    // retrieve the plugin settings
		$settings = Plugin::getAllSettings('immanager');
		$params = func_get_args();
		$directory = '/' . join('/', $params);
    $directory = ($directory == '/') ? $settings['ImageFolder'] : $directory;

		// Search the directory for image files.
		$files = $this->folderImageList(CMS_ROOT . $directory);
		// Check If there are any images in the folder.
		if (is_array($files)) {
			// Create an array of immanagers indexed by the file path. 
			foreach(immanager::findAllByFolder($directory) as $image){
				$immanagers[$image->imageFilename] = $image;
			}
		} 
		else {
			// If there no images in the folder. 
			$files=false;
		}
				
		// Set variables to be sent to the sidebar.
		$this->assignToLayout(
						'sidebar', 
						new View('../../plugins/immanager/views/sidebar', array('view' => 'browse'))
		);
		
		// Display index page.
		$this->display('immanager/views/index', array(
			'directory' => $directory, 
			'images' => $files,
			'immanagers' => $immanagers,
			'ajaxEnabled' => $settings['enableAjax']
		));
    	
  }
    
	public function index() {
		// Add javascript for the plugins index page.
		Plugin::addJavascript('immanager', 'js/flash.js');
		$this->browse();
	}

	public function imageCommeterSaveComment(){
		
		$settings = Plugin::getAllSettings('immanager');
		
		$imagePath = $_POST['imagePath'];
		$imageData = array( 
			'imagePath' => $imagePath,
			'imageTitle' => $_POST['imageTitle'],
			'imageDescription' => $_POST['imageDescription'],
			'imageFilename' => $_POST['imageFilename']
		);
		//$images = immanager::findAllByFolder($imagePath);
		$image = immanager::findByPath($imagePath . '/' . $imageData['imageFilename']);
		
		if ($image) {
			$image->imageTitle = $imageData['imageTitle'];
			$image->imageDescription = $imageData['imageDescription'];
			$image->save();
		} 
		else {
			$image = new immanager();
			$image->imagePath = $imageData['imagePath'];
			$image->imageFilename =$imageData['imageFilename'];
			$image->imageTitle = $imageData['imageTitle'];
			$image->imageDescription = $imageData['imageDescription'];
			
			// Check whether there is a thumbnail for this image.
			// if there is enter it to the row.
			$thumbnailPath = $image->imagePath . DS . $settings['thumbnailFolder'] . DS . $image->imageFilename;
			if(file_exists(CMS_ROOT . $thumbnailPath )) {
				$image->thumbnailPath = $thumbnailPath;
			}
			
			$image->save();
		}
			
    if ($settings['enableAjax']==1) {
    	$return['error'] = false;
			$return['msg'] = 'success';
    	echo json_encode($return);
    } else {
			Flash::set('success', __('Image title and description updated.'));
			redirect(get_url('plugin/immanager/browse' . $imagePath ));
    }
	}
}
