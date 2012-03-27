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


?>
<h1><?php echo __('Image Commenter Documentation'); ?></h1>
<p>
<?php echo __('
<h3>Introduction</h3>
<p>
immanager is a plugin for Wolf-CMS that lets you create thumbnails from images
on your site and give them titles and descriptions.
</p>
	
<h3>Installation instructions</h3>
<p>
Copy the plugin into a folder called immanager within your Wolf CMS plugin
folder, i.e., "/wolf/plugins". Then enable the plugin in the administration 
section of your site. Make sure your "images" folder is writable by PHP.
</p>

<h3>How to use</h3>
<p>
On the immanager tab you can browse your image folders and assign titles and
descriptions to them. The "Create Thumbnails" page will let you create 
thumbnails for your images.
You can then retrieve the entered information in a page in the following way:
</p>
<p>If you want to retrieve information for a single image:</p>
<strong><pre>&lt?php
	$image = immanager::findByPath("/public/images/MyImage.jpg");
	echo $image->imageName . "&ltbr /&gt";
	echo $image->imageDescription . "&ltbr /&gt";
	echo $image->thumbnailPath . "&ltbr /&gt";
?&gt</pre></strong>

<p>Or if you want to cycle through an entire folder:</p>
<strong><pre>&lt?php
foreach (immanager::findAllByFolder(&#39/public/images/MyImageFolder&#39) as $picture) {
  echo &#39&ltstrong&gt&#39 . $picture-&gtimageTitle . &#39&lt/strong&gt&#39 . &#39&ltbr /&gt&#39;;
  echo &#39&lta href="&#39 . $picture-&gtimagePath . DS . $picture-&gtimageFilename . &#39"&gt&#39;;
  echo &#39&ltimg src="&#39 . $picture-&gtthumbnailPath . &#39" /&gt&#39;;
  echo &#39&lt/a&gt&#39;;
  echo $picture-&gtimageDescription . &#39&ltbr /&gt&#39;;
}
?&gt</pre></strong>
'); ?>
</p>
