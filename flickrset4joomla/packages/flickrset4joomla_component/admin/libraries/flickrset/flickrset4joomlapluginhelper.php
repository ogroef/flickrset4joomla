<?php

/**
 *
 * @version     $Id: flickrset4joomlapluginhelper.php 0.2 2014/02/01 Olivier $
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
defined('_JEXEC') or die('Restricted access');

JLoader::import('joomla.plugin.plugin');
JLoader::import('joomla.application.component.helper');

/**
 * This is the base class for the flickrset4joomla plugins.
 */
abstract class FlickrSet4JoomlaPluginHelper extends JPlugin {

    // Plugin name
    private $com_name = 'com_flickrset4joomla';
    
    private $log_type_message = 'message';
    private $log_type_warning = 'warning';
    private $log_type_notice = 'notice';
    private $log_type_error = 'error';
    
    protected $log_level_unexcepted = '1';
    protected $log_level_error = '2';
    protected $log_level_function = '3';
    protected $log_level_statement = '4';

    public function __construct(&$subject, $config = array()) {
        parent::__construct($subject, $config);
        $this->loadLanguage();
    }

    private function log_flickrset4joomla($msg, $msg_type) {
        JFactory::getApplication()->enqueueMessage((string) $msg, $msg_type);
    }

    private function log_flickrset4joomla_message($msg) {
        $this->log_flickrset4joomla((string) $msg, $this->log_type_message);
    }

    private function log_flickrset4joomla_warning($msg) {
        $this->log_flickrset4joomla((string) $msg, $this->log_type_warning);
    }

    private function log_flickrset4joomla_notice($msg) {
        $this->log_flickrset4joomla((string) $msg, $this->log_type_notice);
    }

    private function log_flickrset4joomla_error($msg) {
        $this->log_flickrset4joomla((string) $msg, $this->log_type_error);
    }

    protected function log_message($module, $level, $msg) {
        // Get the component parameters
        $params = JComponentHelper::getParams($this->com_name);
        
        //Get the component debug enabled, module, level parameters
        $comparam_flickr4joomla_debugenabled = $params->get('flickrset4joomla_debugenabled', 'N');
        $comparam_flickr4joomla_debugmodule = $params->get('flickrset4joomla_debugmodule', 'FLICKRSET');
        $comparam_flickr4joomla_debuglevel = $params->get('flickrset4joomla_debuglevel', '4');
        
        //According component debug settings, show message on screen
        if ($comparam_flickr4joomla_debugenabled == 'Y' || $comparam_flickr4joomla_debugmodule == $module) {
            if ($comparam_flickr4joomla_debuglevel >= $level) {
                if ($this->log_level_unexcepted == $level) {
                    $this->log_flickrset4joomla_error($msg);
                }
                if ($this->log_level_error == $level) {
                    $this->log_flickrset4joomla_warning($msg);
                }
                if ($this->log_level_function == $level) {
                    $this->log_flickrset4joomla_notice($msg);
                }
                if ($this->log_level_statement == $level) {
                    $this->log_flickrset4joomla_message($msg);
                }
            }
        }
    }
    
}
