<?php

/**
 *
 * @version     $Id$
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

class com_flickrset4joomlaInstallerScript {

    protected $extension = 'com_flickrset4joomla';

    function preflight($type, $parent) {
        $this->parent = $parent;
        if (version_compare(PHP_VERSION, '5.3.1', '<')) {
            $this->loadLanguage();
            Jerror::raiseWarning(null, JText::sprintf('COM_FLICKRSET4JOOMLA_PHP_VERSION_INCOMPATIBLE', PHP_VERSION, '5.3.1'));
            return false;
        }
    }

}
