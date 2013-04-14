<?php

/**
 * Return the path + / + the name of the file as a string
 * @param File $fn
 * @return string as described before
 */
function getFullFileName($fn){
    return $fn->getPath().'/'.$fn->getFilename();
}

//Includes the utility functions
include_once('../../includes/functions.php');

//Includes the Image utility functions
include_once('../../includes/ImageManipulator.php');

//Delete the thumbnails
foreach (new DirectoryIterator("../../assets/images/partners/thumbs") as $fn) {
    if(!is_dir(getFullFileName($fn)))
        unlink(getFullFileName($fn));
}

//List the images of the partners folder
foreach (new DirectoryIterator("../../assets/images/partners") as $fn) {
    //For each image create a new thumbnail
    if(!is_dir(getFullFileName($fn))){
        $manipulator = new ImageManipulator(getFullFileName($fn));

        //Get the width and height from the options
        $thumb_width = get_option('ps_thumb_width');
        $thumb_height = get_option('ps_thumb_height');

        //Resize
        $thumb = $manipulator->resample($thumb_width, $thumb_height);

        //Save
        $manipulator->save("../../assets/images/partners/thumbs/".$fn->getFilename());
    }
}

echo 'DONE';
?>
