<?php

/**
 *
 * @version     $Id: view.html.php 0.1 2014/02/01 Olivier $
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

// import Joomla view library
jimport('joomla.application.component.viewlegacy');

/**
 * Class Flickrset4JoomlaViewUploads
 */
class Flickrset4JoomlaViewCpanel extends JViewLegacy {

    /**
     * Display method
     *
     * @param   string  $tpl  - the template
     *
     * @return mixed|void
     */
    public function display($tpl = null) {
        $this->setToolbar();
        parent::display($tpl);
    }

    /**
     * Creates the toolbar options
     *
     * @return void
     */
    public function setToolbar() {
        JToolBarHelper::title(JText::_('COM_FLICKRSET4JOOMLA_ABOUT_TOOLBAR_TITLE'));
    }

}

?>