<?php

/**
 *
 * @version     $Id: controller.php 0.1 2014/02/01 Olivier $
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

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * The main flickrset controller class (for the front end)
 *
 * @package Attachments
 */
class flickrset4joomlaController extends JControllerLegacy {

    public function display($cachable = false, $urlparams = false) {
        parent::display();
        return $this;
    }

}

?>