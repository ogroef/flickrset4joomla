<?php

/**
 *
 * @version             $Id: flickrset_plugin.php 0.1 2014/01/01 olivier $
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

class plgContentflickrset extends JPlugin {

    var $plg_name = 'flickrset';
    var $plg_tag = 'flickrset';

    /**
     * Plugin that replaces {flickrset}-tags with flickr embeded code
     *
     * @param   string   $context    The context of the content being passed to the plugin.
     * @param   mixed    &$article   A reference to the article that is being rendered by the view.
     * @param   mixed    &$params    A reference to an associative array of relevant parameters.
     * @param   integer  $limitstart An integer that determines the "page" of the content that is to be generated.
     *
     * @return  boolean        true on success.
     */
    function onContentPrepare($context, &$article, &$params, $limitstart) {
        // Don't run this plugin when the content is being indexed
        if ($context === 'com_finder.indexer') {
            return true;
        }

        // Check if plugin is enabled
        if (JPluginHelper::isEnabled('content', $this->plg_name) == false) {
            return true;
        }

        // Includes
        require(dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->plg_name . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'sources.php');

        // Simple performance check to determine whether plugin should process further
        //  Verify if tag is found as a key in the newtagsource array
        $grabTags = str_replace("(", "", str_replace(")", "", implode(array_keys($newtagsource), "|")));

        $regex = '/\{(' . $grabTags . ')\}/i';
        $matchresult = preg_match($regex, $article->text);

        if ($matchresult == false) {
            return;
        }

        // Get plugin parameters
        $plgparam_flickrset_flickrid = trim($this->params->get('flickrset_flickrid'));
        $plgparam_flickrset_allowfullscreen = trim($this->params->get('flickrset_allowfullscreen', 'Y'));
        $plgparam_flickrset_objectwidth = trim($this->params->get('flickrset_objectwidth', 400));
        $plgparam_flickrset_objectheight = trim($this->params->get('flickrset_objectheight', 300));

        // Plugin wont be executed when flickerid is empty
        if ($plgparam_flickrset_flickrid == '') {
            return true;
        }

        // Expression to search for (positions)
        $regex = "/{" . $this->plg_tag . "}.*?{\/" . $this->plg_tag . "}/i";

        // Determine if theire are instances of $plg_tag and put in $matches
        //  when no instances found do not perform tag replacement
        if (preg_match_all($regex, $article->text, $matches)) {
            // start the replace loop
            foreach ($matches[0] as $key => $match) {
                // Remove the tags
                $tagcontent = preg_replace("/{.+?}/", "", $match);

                // Get an array of parameters
                // order of parameters: flickersetid|width|height
                $tagparams = explode('|', $tagcontent);

                // Get the flickersetid strip html/php tags
                $tagparam_flickersetid = trim(strip_tags($tagparams[0]));

                // Get the width and height tags
                $final_objectwidth = (@$tagparams[1]) ? $tagparams[1] : $plgparam_flickrset_objectwidth;
                $final_objectheight = (@$tagparams[2]) ? $tagparams[2] : $plgparam_flickrset_objectheight;

                // Determine the allow fullscreen
                $final_allowfullscreen = (@$plgparam_flickrset_allowfullscreen === 'Y') ? 'true' : 'false';

                // Set a unique ID
                $flickerset_playerID = 'FlickerSetID_' . substr(md5($tagparam_flickersetid), 1, 10) . '_' . rand();

                // An array of all different elements used in the flickerset template
                $TmplElmtParams = array(
                    "{PLAYERID}",
                    "{FLICKR_SETID}",
                    "{FLICKRID}",
                    "{OBJECT_WIDTH}",
                    "{OBJECT_HEIGHT}",
                    "{ALLOWFULLSCREEN}"
                );

                // An array of all different elements values used in the flickerset template
                $TmplElmtParamValues = array(
                    $flickerset_playerID,
                    $tagparam_flickersetid,
                    $plgparam_flickrset_flickrid,
                    $final_objectwidth,
                    $final_objectheight,
                    $final_allowfullscreen
                );

                // Perform the actual tag replacement
                $convertedtag = JFilterOutput::ampReplace(str_replace($TmplElmtParams, $TmplElmtParamValues, $newtagsource[$this->plg_tag]));

                // Output
                $regex = "/{" . $this->plg_tag . "}" . preg_quote($tagcontent) . "{\/" . $this->plg_tag . "}/i";
                $article->text = preg_replace($regex, $convertedtag, $article->text);
            } // End foreach replacing loop
        } else { //when code comes here, no flickrset tags found to replace
        }// End if find all instance of $plg_tag

        return true;
    }

}

?>