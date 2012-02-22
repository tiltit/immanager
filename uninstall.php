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

if (Plugin::deleteAllSettings('immanager') === false) {
    Flash::set('error', __('Unable to delete plugin settings.'));
    redirect(get_url('setting'));
}
try {
	$pdo = Record::getConnection();
	$pdo->query('DROP TABLE IF EXISTS ' . TABLE_PREFIX . 'immanager');
}
catch(PDOException $e) {
	Flash::set('error :' . $e->getMessage, __('Unable to drop table :tablename', array(':tablename' => TABLE_PREFIX.'immanager')));
	redirect(get_url('setting'));
}
