<?php

/**
 *
 * @version             $Id: add_flickrset_btn.php 0.1 2014/02/01 Olivier $
 * @package             Joomla
 * @subpackage  Content
 * @copyright   Copyright (C) 2005-2014 Open Source Matters. All rights reserved.
 * @license             GNU/GPL, see LICENSE.php
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

// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');

class plgButtonadd_flickrset_btn extends JPlugin {

    var $plg_name = 'add_flickrset_btn';
    var $plg_tag = 'flickrset';

    /**
     * Load the language file on instantiation.
     *
     * @var    boolean
     * @since  3.1
     */
    protected $autoloadLanguage = true;

    function onDisplay($name) {
        $doc = JFactory::getDocument();
        $app = JFactory::getApplication();

        JHTML::stylesheet('plugins/editors-xtd/add_flickrset_btn/add_flickrset_btn/includes/css/plg_editors-xtd_add_flickrset_btn.css');

        $flickersetidprompt = JText::_('PLG_EDITORSXTD_FLICKRSET_PROMPT');
        $flickersetidpromptalert = JText::_('PLG_EDITORSXTD_FLICKRSET_PROMPT_ALERT');

        $jsCode = "function insertflickrset(nameOfEditor) {
				    flickrsetid = prompt('$flickersetidprompt','0123456789');
					
					if (flickrsetid)
					{ if (flickrsetid !== null && isFinite(flickrsetid) && flickrsetid.length>0)
					  { // JInsertEditorText has to be defined by the editor in use (fe: TinyMCE editor or JCE does)
                                            var tag = '\{$this->plg_tag\}'+flickrsetid+'{\/$this->plg_tag}';
                                            jInsertEditorText(tag, nameOfEditor);
					    return true;
					  }
					  else
					  { alert('$flickersetidpromptalert');
                                            return false;
					  }
					}
                   }
            ";
        $doc->addScriptDeclaration($jsCode);

        $button = new JObject();
        $button->set('modal', false);
        $button->set('class', 'btn');
        $button->set('text', JText::_('PLG_EDITORSXTD_FLICKRSET_BUTTON'));
        $button->set('onclick', 'insertflickrset(\'' . $name . '\');return false;');
        $button->set('name', 'flickrset');
        $button->set('link', 'javascript:void(0)');

        return $button;
    }

}

?>