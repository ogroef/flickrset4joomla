<?php

/**
 *
 * @version     $Id: sources.php 0.8 2018/02/12 olivier $
 * @package     FlickrSet4Joomla
 * @subpackage  FlickrSet4Joomla_Plugin
 * @author      flickrset_plugin_author
 * @copyright   Copyright (C) flickrset_plugin_copyright_range Open Source Matters. All rights reserved.
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

/* ----------------------------------- Embeded FlickrSet creatsd by link ------------------------------------- */
$createdwithlink = "<small>{CREATED_WITH_DISPLAY} <a href=\"{REQUEST_PROTOCOL}extensions.joomla.org/extensions/26557/details\" target=\"_blank\">Flickrset for Joomla</a>.</small>";

/* ---------------------------- Embeded template code for FlickrSet as flashobject --------------------------- */
$flickrsetflash = "
<div style=\"text-align:center;margin:auto;\" id=\"{PLAYERID}\" name=\"FlickrSet_{FLICKR_SETID}_Flash\">
 <object width=\"{OBJECT_WIDTH}\" height=\"{OBJECT_HEIGHT}\">
  <param name=\"flashvars\" value=\"offsite=true&lang={LANGUAGE}&page_show_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/show/&page_show_back_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/&set_id={FLICKR_SETID}&jump_to=\" />
  <param name=\"movie\" value=\"{REQUEST_PROTOCOL}www.flickr.com/apps/slideshow/show.swf?v=138195\" />
  <param name=\"allowFullScreen\" value=\"{ALLOWFULLSCREEN}\" />
  <embed type=\"application/x-shockwave-flash\" src=\"{REQUEST_PROTOCOL}www.flickr.com/apps/slideshow/show.swf?v=138195\" allowFullScreen=\"{ALLOWFULLSCREEN}\" flashvars=\"offsite=true&lang={LANGUAGE}&page_show_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/show/&page_show_back_url=/photos/{FLICKRID}/sets/{FLICKR_SETID}/&set_id={FLICKR_SETID}&jump_to=\" width=\"{OBJECT_WIDTH}\" height=\"{OBJECT_HEIGHT}\" />
 </object><br/>{CREATEDWITH_LINK}
</div>
";

/* ---------------------------- Embeded template code for FlickrSet as embeded Slideshow --------------------- */
$flickrsetess = "
<div style=\"text-align:center;margin:auto;\" id=\"{PLAYERID}\" name=\"FlickrSet_{FLICKR_SETID}_EmbedSS\">
 <a data-flickr-embed=\"true\"
    data-header=\"true\"
    data-footer=\"false\"
    href=\"{REQUEST_PROTOCOL}www.flickr.com/photos/{FLICKRID}/albums/{FLICKR_SETID}\"
    title=\"{LINK_DISPLAY}\">
    <img src=\"{FLICKR_SETIMG}\"
         width=\"{OBJECT_WIDTH}\"
         height=\"{OBJECT_HEIGHT}\"
         alt=\"{LINK_DISPLAY}\">
 </a>
 <script async src=\"{REQUEST_PROTOCOL}embedr.flickr.com/assets/client-code.js\"
         charset=\"utf-8\">
 </script><br/>{CREATEDWITH_LINK}
</div>
";

/* -------------------------------- Embeded template code for FlickrSet as button ---------------------------- */
$flickrsetbutton = "
<div id=\"{PLAYERID}\" name=\"FlickrSet_{FLICKR_SETID}_Button\">
   <p>
      <a class=\"btn\" target=\"_blank\" title=\"{LINK_DISPLAY}\" href=\"{REQUEST_PROTOCOL}www.flickr.com/photos/{FLICKRID}/sets/{FLICKR_SETID}/player\" rel=\"alternate\">
       <i class=\"button-flickrset\" />
        {LINK_DISPLAY}
       </a>
   </p>
</div>
";

/* -------------------------------- Embeded template code for FlickrSet as link ---------------------------- */
$flickrsetlink = "
<div id=\"{PLAYERID}\" name=\"FlickrSet_{FLICKR_SETID}_Link\">
   <p>
      <a href=\"{REQUEST_PROTOCOL}www.flickr.com/photos/{FLICKRID}/sets/{FLICKR_SETID}/player\" target=\"_blank\">
       <i class=\"link-flickrset\" rel=\"alternate\"/>
        {LINK_DISPLAY}
      </a>
   </p>
</div>
";

/* -------------------------------- Tags & formats -------------------------------- */
$newtagsource = array( "flickrset" => $flickrsetflash
                     , "flickrsetess" => $flickrsetess
                     , "flickrsetlink" => $flickrsetlink
                     , "flickrsetbutton" => $flickrsetbutton
                     );

?>
