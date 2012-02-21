<?php

// php debuging
ini_set('display_errors', 0); 
ini_set('log_errors', 1); 
ini_set('error_log', '/var/www/www.tiltit.org/php_errors.txt'); 
//error_reporting(E_USER_NOTICE);
error_reporting(E_ERROR | E_USER_NOTICE);
//error_reporting(E_ALL);
xdebug_disable();


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

	
}