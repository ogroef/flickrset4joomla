<?php

/**
 *
 * @version     $Id: sources.php 0.1 2014/01/01 olivier $
 * @package     Joomla
 * @subpackage  Content
 * @copyright   Copyright (C) 2005-2014 Open Source Matters. All rights reserved.
 * @license     GNU/GPL, see LICENSE.php
 *
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * 
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

/* -------------------------------- Embeded template code for FlickerSet -------------------------------- */
$flickrset = "
<div id=\"{PLAYERID}\">
<object width=\"{OBJECT_WIDTH}\" height=\"{OBJECT_HEIGHT}\">
 <param name=\"flashvars\" value=\"offsite=true&lang=en-us&page_show_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/show/&page_show_back_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/&set_id={FLICKR_SETID}&jump_to=\" />
 <param name=\"movie\" value=\"http://www.flickr.com/apps/slideshow/show.swf?v=138195\" />
 <param name=\"allowFullScreen\" value=\"{ALLOWFULLSCREEN}\" />
 <embed type=\"application/x-shockwave-flash\" src=\"http://www.flickr.com/apps/slideshow/show.swf?v=138195\" allowFullScreen=\"{ALLOWFULLSCREEN}\" flashvars=\"offsite=true&lang=en-us&page_show_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/show/&page_show_back_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/&set_id={FLICKR_SETID}&jump_to=\" width=\"{OBJECT_WIDTH}\" height=\"{OBJECT_HEIGHT}\" />
</object>
</div>
";

/* -------------------------------- Tags & formats -------------------------------- */
$newtagsource = array(
// flickr.com - http://www.flickr.com/photos/sciandra/sets/72157631445023884/show/?embed=1
    "flickrset" => $flickrset,
);
