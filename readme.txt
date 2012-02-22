INTRODUCTION

immanager is a plugin for Wolf-CMS that lets you create thumbnails from images
on your site and give them titles and descriptions.


INSTALLATION INSTRUCTIONS

Copy the plugin into a folder called immanager within your Wolf CMS plugin
folder, i.e., '/wolf/plugins'. Then enable the plugin in the administration 
section of your site. Make sure your "images" folder is writable by PHP.


HOW TO USE

On the immanager tab you can browse your image folders and assign titles and
descriptions to them. The 'Create Thumbnails' page will let you create 
thumbnails for your images.
You can then retrieve the entered information in a page in the following way:

If you want to retrieve information for a single image:
$image = immanager::findByPath('/public/images/MyImage.jpg');
echo $image->imageName . '<br />';
echo $image->imageDescription . '<br />';
echo $image->thumbnailPath . '<br />';

Or if you want to cycle through an entire folder:
foreach (immanager::findAllByFolder('/public/images/MyImageFolder') as $picture) {
  echo '<strong>' . $picture->imageTitle . '</strong>' . '<br />';
  echo '<a href="' . $picture->imagePath . DS . $picture->imageFilename . '">';
  echo '<img src="' . $picture->thumbnailPath . '" />';
  echo '</a>';
  echo $picture->imageDescription . '<br />';
}