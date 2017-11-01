<?php

/**
 *
 * @version     $Id: flickrset4joomla.php 0.2 2017/09/28 Olivier $
 * @package     FlickrSet4Joomla
 * @subpackage  FlickrSet4Joomla_Component
 * @author      flickrset4joomla_component_author
 * @copyright   Copyright (C) flickrset4joomla_component_copyright_range Open Source Matters. All rights reserved.
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

$php_min_version = "5.3.1";

// verify PHP version
if (version_compare(PHP_VERSION, $php_min_version ) < 0) {
    return JError::raiseWarning(20000, JText::sprintf('COM_FLICKRSET4JOOMLA_PHP_VERSION_INCOMPATIBLE', PHP_VERSION, $php_min_version));
}

// check JUser object authorization against an access control object and optionally an access extension object
if (!JFactory::getUser()->authorise('core.manage', 'com_flickrset4joomla')) {
    return JError::raiseWarning(20404, JText::_('JERROR_ALERTNOAUTHOR'));
}

// import joomla controller library
jimport('joomla.application.component.controller');

// Get an instance of the controller
$controller = JControllerLegacy::getInstance('flickrset4joomla');

$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();