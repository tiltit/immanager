<?php

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




defined('IN_CMS') || exit();

/*
 * The table should look like this:
 * id : primary id
 * imagePath : is the path to the folder where the image is saved
 * imageFilename : is the the imahe filename
 * imageTitle : The title given by the user to the image
 * imageDescription : The description given by the user to the image.
 * 
 * In the immanager extent record class there shoud be a method to find all
 * images with a given path, and a method to find a single image with a given
 * path AND the image filename.
 * 
 */

class immanager extends Record {
    
    const TABLE_NAME = 'immanager';

    public $id;
    public $imagePath;
		public $imageFilename;
    public $imageTitle;
    public $imageDescription;
		public $thumbnailPath;
		
		
		
	public static function find($args = null) {
				
		// Collect attributes...
		$where    = isset($args['where']) ? trim($args['where']) : '';
		$order_by = isset($args['order']) ? trim($args['order']) : '';
		$offset   = isset($args['offset']) ? (int) $args['offset'] : 0;
		$limit    = isset($args['limit']) ? (int) $args['limit'] : 0;

		// Prepare query parts
		$where_string = empty($where) ? '' : "WHERE $where";
		$order_by_string = empty($order_by) ? '' : "ORDER BY $order_by";
		$limit_string = $limit > 0 ? "LIMIT $limit" : '';
		$offset_string = $offset > 0 ? "OFFSET $offset" : '';

		$tablename = self::tableNameFromClassName('immanager');

		// Prepare SQL
		$sql = "SELECT	$tablename.id as id,
										$tablename.imagePath as imagePath,
										$tablename.imageFilename as imageFilename,
										$tablename.imageTitle as imageTitle, 
										$tablename.imageDescription as imageDescription ,
										$tablename.thumbnailPath as thumbnailPath
			FROM $tablename $where_string $order_by_string $limit_string $offset_string";
		
		$stmt = self::$__CONN__->prepare($sql);
		$stmt->execute();

		// Run!
		if ($limit == 1) {
			return $stmt->fetchObject('immanager');
		}
		else {
			$objects = array();
				while ($object = $stmt->fetchObject('immanager'))
				$objects[] = $object;

				return $objects;
			}

	} // find
		

	public static function findAllByFolder($folder, $order = 'imageFilename') {
		return self::find(array(
			'where' => self::tableNameFromClassName('immanager') . '.imagePath = "' . $folder . '"',
			'order' => $order
		));
	}
	
	public static function findByPath($path) {
		
		$imageFilename = end(explode('/', $path));
		$folder = substr($path, 0, -strlen($imageFilename) -1);
		
		$tablename = self::tableNameFromClassName('immanager');
		
		return self::find(array(
			'where' => $tablename . '.imagePath = "' . $folder . '"' 
				. ' AND ' . $tablename . '.imageFilename = "' . $imageFilename . '"',
			'limit' => 1
		));
	}
		
}