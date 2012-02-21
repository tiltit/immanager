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

/* Security measure */
if (!defined('IN_CMS')) { exit(); }

/*
 * The table should look like this:
 * id : primary id
 * imagePath : is the path to the folder where the image is saved
 * imageFilename : is the the imahe filename
 * imageTitle : The title given by the user to the image
 * imageDescription : The description given by the user to the image.
 * thumbnailPath	: The path to to thumbnail if it exists
 * 
 */
$sql = "CREATE TABLE IF NOT EXISTS " . TABLE_PREFIX . "immanager(
	id INT NOT NULL AUTO_INCREMENT, 
	PRIMARY KEY(id),
	imagePath varchar(255),
	imageFilename varchar(255),
	imageTitle varchar(255),
	imageDescription varchar(1020),
	thumbnailPath varchar(255))";

$PDO = Record::getConnection();
$PDO->exec($sql);

//Set default setting.
$settings= array (
	'ImageFolder' => '/public/images',
	'enableAjax' => '0',
	'thumbnailFolder' => '/thumbnails',
	'resizeMethod' => '3',
	'thumbnailWidth' => '100',
	'thumbnailHeight' => '100',
	'backgroundColor' => 'FFFFFF'
);
Plugin::setAllSettings($settings, 'immanager');

exit();