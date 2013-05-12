partner-slider
==============

Wordpress plugin : Partner slider
---------------------------------

This plugin will allow you to display your partners on your website thanks to a simple widget.

You can manage partners, add them into lists and display them into certain pages from the admin panel.

For example you have a programming blog dedicated to Java and Python. You can create 3 lists :
 - One list for your partners related to Java programming linked to your (parent) page Java.
 - One list for your partners related to Python programming linked to your (parent) page Python.
 - One default list which will display partners on all the other pages.

I am not a PHP developer, even less a Wordpress developer,
but i had some fun making this plugin and i would love to have some feedback about it.
Notably about the plugin architecture, i feel like it's not really consistent.

Tested on Wordpress 3.5.1 with the theme twenty twelve
Please refer to the wiki and do not hesitate to raise issues, fork or whatever you have in mind.

This project uses :
 - http://baijs.nl/tinycarousel/ : a jquery plugin to display images in a carousel
 - ImageManipulator : a PHP class to manipulate images and create thumbnails

TODO:
 - Set an option to display or not the next/previous arrows (perhaps using a json file to pass the options to the js file)