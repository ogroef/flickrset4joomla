<?php

/**
 *
 * @version     $Id: add_flickrset_btn.js 0.2 2014/02/01 Olivier $
 * @package     FlickrSet4Joomla
 * @subpackage  FlickrSet4Joomla_Component
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
defined('_JEXEC') or die();

JLoader::import('joomla.plugin.plugin');

/**
 * This is the base class for the flickrset_btn plugins.
 */
abstract class FlickrSetPluginHelper extends JPlugin {

    public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    private function log($msg,$msg_type) {
        JFactory::getApplication()->enqueueMessage((string) $msg, $msg_type);
    }

    protected function log_message($msg) {
        log((string) $msg, 'message');
    }

    protected function log_warning($msg) {
        log((string) $msg, 'warning');
    }

    protected function log_notice($msg) {
        log((string) $msg, 'notice');
    }

    protected function log_error($msg) {
        log((string) $msg, 'error');
    }
}
