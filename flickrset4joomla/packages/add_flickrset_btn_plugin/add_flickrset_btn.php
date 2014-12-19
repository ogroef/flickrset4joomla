<?php

/**
 *
 * @version     $Id: add_flickrset_btn.php 0.2 2014/02/01 Olivier $
 * @package     Joomla.Platform
 * @subpackage  Plugin
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

// Import the FlickrsetPlugin class for common methods
JLoader::import('components.com_flickrset_btn.libraries.flickrset.plugin', JPATH_ADMINISTRATOR);

if (!class_exists('FlickrSetPlugin')) {
    return;
}

class plgButtonadd_flickrset_btn extends FlickrSetPlugin {

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
     * Display the button
     *
     * @param   string   $name    The name of the button to display.
     * @param   string   $asset   The name of the asset being edited.
     * @param   integer  $author  The id of the author owning the asset being edited.
     *
     * @return button 
     */
    function onDisplay($name, $asset, $author) {
        
        $app = JFactory::getApplication();
        $user = JFactory::getUser();
        $doc = JFactory::getDocument();

        $extension = $app->input->get('option');

        // $this->log($extension);

        // Only generate the flickrset button in the content component
        if ($extension === $this->com_content) {
            //Get the version number of the plugin
            $xml = JFactory::getXML(JPATH_PLUGINS . DS . 'editors-xtd' . DS . $this->plg_name . DS . $this->plg_name .'.xml');
            $this->plg_version = $xml->version;
        
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
            } else {
                $button->set('name', 'flickrset-add-button-frontend');
            }
            $button->set('rel', '');
            $button->set('link', $link);
            $button->set('options', "{handler: 'iframe', size: {x:500, y:310}}");

            return $button;
        } else {
            return false;
        }
    }

}

?>