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

Plugin::setInfos(array(
    'id'          => 'immanager',
    'title'       => __('immanager Image Manager'),
    'description' => __('Provides a way to give a title and description and create thumbnails.'),
    'version'     => '0.0.1',
   	'license'     => 'GPL',
		'author'      => 'Oliver Dille',
    'website'     => 'http://tiltit.org/',
    //'update_url'  => 'http://www.wolfcms.org/plugin-versions.xml',
    'require_wolf_version' => '0.7.5'
));

// Add the extend record class to the plugin.
AutoLoader::addFile('immanager', CORE_ROOT.'/plugins/immanager/immanager.php');

// Add the controller for the plugin.
Plugin::addController('immanager', __('immanager'), 'administrator', true);
/*
function imageCommenter($imagePath, $titleOrDescription = 'title'){
			$pdo = Record::getConnection();
			$query = "select * from image_commenter where imagePath='$imagePath'";
			$queryResult = $pdo->query($query);
			$row = $queryResult->fetch(PDO::FETCH_ASSOC);
			$imageTitle = $row['imageTitle'];
			$imageDescription = $row['imageDescription'];
			$pdo=null;
			if ($titleOrDescription == 'description') {
				return $imageDescription;
			} else {
				return $imageTitle;
			}
		}
*/
		
		