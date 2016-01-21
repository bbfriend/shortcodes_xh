set
1:Unzip

2:plugins/shortcodes_xh/* ----> plugins/shortcodes_xh/*

3:cmsimple/userfuncs.php ---> cmsimple/userfuncs.php
  * if you have already have a userfuncs.php, please copy the source code. Very simple code.

4:Open your template.htm
   content() --> xh_content()
 example.
          <?php echo content();?>
   to
          <?php echo xh_content();?>









====Original writer===
Badcow Shortcodes
https://github.com/Badcow/Shortcodes
=====================

This is a port of WordPress' brilliant shortcode feature for use outside of WordPress. The code has remained largely unchanged.

The purpose of this project is to use the familiar WordPress shortcode syntax in any system.

Basic Usage
-----------

    $shortcodes = new Badcow\Shortcodes\Shortcodes;
    $shortcodes->addShortcode('hello', function ($attributes, $content, $tagName) {
        return $attributes['greeting'] . ', ' . $content;
    });

    echo $shortcodes->process('My shortcode does this: [hello greeting="Konnichiwa"]world![/hello]');

Installation
------------

Use [Composer](http://getcomposer.org/). That's what all the cool kids use.

    "require" : { "badcow/shortcodes": "dev-master" }

Running Tests
-------------

    phpunit /path/to/shortcodes

Build Status
------------

[![Build Status](https://travis-ci.org/Badcow/Shortcodes.png)](https://travis-ci.org/Badcow/Shortcodes)
