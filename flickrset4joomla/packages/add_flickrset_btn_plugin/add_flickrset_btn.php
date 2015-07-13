<?php

/**
 *
 * @version     $Id: add_flickrset_btn.php 0.2 2014/02/01 Olivier $
 * @package     FlickrSet4Joomla
 * @subpackage  Add_FlickrSet4Joomla_Button_Plugin
 * @author      Olivier
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

// Import the Flickrset4Joomla Helpers class for common methods
JLoader::import('components.com_flickrset4joomla.libraries.flickrset.flickrset4joomlapluginhelper', JPATH_ADMINISTRATOR);

if (!class_exists('FlickrSet4JoomlaPluginHelper')) {
    return;
}

class plgButtonadd_flickrset_btn extends FlickrSet4JoomlaPluginHelper {

    protected $com_content = 'com_content';
    var $plg_name = 'add_flickrset_btn';
    var $plg_version = '';
    var $plg_tag = 'flickrset';

    /**
     * Load the language file on instantiation.
     *
     * @var    boolean
     * @since  3.1
     */
    protected $autoloadLanguage = true;

    /**
     * Private function used to log messages on screen
     *
     * @param   mixed    $plg_name   Name of the plugin.
     * @param   mixed    $log_level  Level of logging.
     * @param   integer  $log_msg    The message that is used for logging.
     *
     */
    protected function log($plg_name, $log_level, $log_msg) {
        $this->log_message($plg_name, $log_level, $log_msg);
    }

    /**
     * Display the button
     *
     * @param   string   $name    The name of the button to display.
     * @param   string   $asset   The name of the asset being edited.
     * @param   integer  $author  The id of the author owning the asset being edited.
     *
     * @return button 
     */
    function onDisplay($name, $asset, $author) {
        
        $this->log($this->plg_name,$this->log_level_module,'Starting...');

        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        $doc = JFactory::getDocument();

        $extension = $app->input->get('option');

        // Only generate the flickrset button in the content component
        if ($extension === $this->com_content) {
            $this->log($this->plg_name, $this->log_level_statement, 'Rendering the flickrset button');

            //Get the version number of the plugin
            $xml = JFactory::getXML(JPATH_PLUGINS . DIRECTORY_SEPARATOR . 'editors-xtd' . DIRECTORY_SEPARATOR . $this->plg_name . DIRECTORY_SEPARATOR . $this->plg_name . '.xml');
            $this->plg_version = $xml->version;
            $this->log($this->plg_name, $this->log_level_statement, 'Using version '. $this->plg_version);

            // Add the regular css file
            JHtml::stylesheet('plg_editors-xtd_add_flickrset_btn/plg_editors-xtd_add_flickrset_btn.css', array(), true);

            JHtml::_('behavior.modal');

            $link = 'index.php?option=com_flickrset4joomla&amp;view=article&amp;layout=addflickrsetbtn&amp;tmpl=component&amp;e_name=' . $name . '&amp;flickrsettag=' . $this->plg_tag . '&amp;addflickrsetbuttonversion=' . $this->plg_version;

            // Create the [Add Flickrset] button object
            $button = new JObject();

            // Finalize the [Add Flickrset] button info
            $button->set('modal', true);
            $button->set('class', 'btn');
            $button->set('text', JText::_('PLG_EDITORS-XTD_FLICKRSET_ADD_BUTTON'));
            if ($app->isAdmin()) {
                $button->set('name', 'flickrset-add-button');
                $this->log($this->plg_name, $this->log_level_statement, 'Rendering button in backend');
            } else {
                $button->set('name', 'flickrset-add-button-frontend');
                $this->log($this->plg_name, $this->log_level_statement, 'Rendering button in frontend');
            }
            $button->set('rel', '');
            $button->set('link', $link);
            $button->set('options', "{handler: 'iframe', size: {x:500, y:310}}");

            $this->log($this->plg_name,$this->log_level_module,'End');

            return $button;
        } else {
            return false;
        }
    }

}

?>