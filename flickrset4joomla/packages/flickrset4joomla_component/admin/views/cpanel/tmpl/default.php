<?php
/**
 *
 * @version     $Id: default.php 0.1 2014/02/01 Olivier $
 * @package     flickrset
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
?>

<div align="center" style="clear: both">
    <br>
    <?php
    $xml = JFactory::getXML(JPATH_COMPONENT . DS . 'flickrset4joomla.xml');
    echo JText::sprintf('COM_FLICKRSET4JOOMLA_FOOTER', $xml->version);
    ?>
</div>

<div align="right" class="copyright row-fluid">
    <?php echo JText::sprintf('COM_FLICKRSET4JOOMLA_LEAVE_A_REVIEW_JED', 'http://extensions.joomla.org/extensions/social-web/social-media/photo-channels/flickr/26557'); ?>
    <br/>
    <?php echo JText::sprintf('COM_FLICKRSET4JOOMLA_DEVELOPED_BY'); ?> <?php echo JHtml::_('email.cloak', 'ogroef@gmail.com', 1, 'Olivier De Groef'); ?>
</div>