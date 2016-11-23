<?php

/**
 *
 * @version     $Id: flickrset.php 0.4 2016/08/30 olivier $
 * @package     FlickrSet4Joomla
 * @subpackage  FlickrSet4Joomla_Plugin
 * @author      flickrset_plugin_author
 * @copyright   Copyright (C) flickrset_plugin_copyright_range Open Source Matters. All rights reserved.
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

// Get Application handler
jimport('joomla.environment.browser');

class plgContentflickrset extends FlickrSet4JoomlaPluginHelper {

    // Loading the language file on instantiation
    protected $autoloadLanguage = true;
    
    // Constants: defaulting the options
    const default_allowfullscreen = 'Y';
    const default_link_type = 'S';
    const default_mobile_link_type = 'S';
    const default_objectwidth = 400;
    const default_objectheight = 300;
    
    // Flickr API url - method - format
    protected $flickrapiurl = 'https://api.flickr.com/services/rest/?';
    protected $flickrphotosetsgetInfomethod = 'flickr.photosets.getInfo';
    protected $flickrrestformat = 'php_serial';
    
    // Plugin name
    var $plg_name = 'flickrset';
    
    // These are used when rendering the flickrset
    var $plg_version              = '';
    var $plg_copyrights_start     = '';
    var $plg_flickrsetimg         = '';
    var $plg_copyrights_end       = '';
    var $plg_created_with_display = '';
    
    // This is the tag where we look for in the article content
    var $plg_tag              = 'flickrset';
    var $plg_tag_ess          = 'flickrsetess';
    
    // These are used when navigating with a mobile device
    var $plg_tag_button       = 'flickrsetbutton';
    var $plg_tag_link         = 'flickrsetlink';
    var $plg_link_display     = '';
    
    /**
     * Private function used to log messages on screen
     * Only log messages when we are in an article context
     *
     * @param   string   $context    The context of the content being passed to the plugin.
     * @param   mixed    $plg_name   Name of the plugin.
     * @param   mixed    $log_level  Level of logging.
     * @param   integer  $log_msg    The message that is used for logging.
     *
     */
    protected function log($context, $plg_name, $log_level, $log_msg) {
        // Only show the logging messages in the article context
        if ($context === 'com_content.article') {
            $this->log_message($plg_name, $log_level , $log_msg);
        }
    }

    /**
     * Plugin that replaces {flickrset}-tags with flickr embeded code
     *  When on a mobile device we show an URL instead of a flash object
     *
     * @param   string   $context    The context of the content being passed to the plugin.
     * @param   mixed    &$article   A reference to the article that is being rendered by the view.
     * @param   mixed    &$params    A reference to an associative array of relevant parameters.
     * @param   integer  $limitstart An integer that determines the "page" of the content that is to be generated.
     *
     * @return  boolean        true on success.
     */
    function onContentPrepare($context, &$article, &$params, $limitstart) {
        $this->log($context,$this->plg_name,$this->log_level_module,'Starting...');
        
        // Don't run this plugin when the content is being indexed
        if ($context === 'com_finder.indexer') {
            return true;
        }

        // Check if plugin is enabled
        if (JPluginHelper::isEnabled('content', $this->plg_name) == false) {
            $this->log($context,$this->plg_name,$this->log_level_statement, $this->plg_name.' Plugin not executed because plugin is disabled');
            return true;
        }

        // Includes
        require(dirname(__FILE__).DIRECTORY_SEPARATOR.$this->plg_name.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'sources.php');

        // Simple performance check to determine whether plugin should process further
        //  Verify if tag is found as a key in the newtagsource array
        $grabTags = str_replace("(", "", str_replace(")", "", implode(array_keys($newtagsource), "|")));

        $regex = '/\{('.$grabTags.')\}/i';
        $this->log($context,$this->plg_name,$this->log_level_statement,'Regular expression in order to determine if there are flickrset tags: '.$regex);
        $matchresult = preg_match($regex, $article->text);

        if ($matchresult == false) {
            $this->log($context,$this->plg_name,$this->log_level_statement,'Found no flickrset tags');
            return true;
        } else {
            $this->log($context,$this->plg_name,$this->log_level_statement,'Found flickrset tags');
        };

        // Get plugin parameters
        $plgparam_flickrset_flickrid = trim($this->params->get('flickrset_flickrid'));
        
        // Plugin wont be executed when default flickrid is empty
        if ($plgparam_flickrset_flickrid == '') {
            $this->log($context,$this->plg_name,$this->log_level_error,'Plugin not executed because plugin <default flickr id>-parameter is empty');
            return true;
        }
        
        // Get the other plugin parameters, we donot need them when flickrid is not setup
        $plgparam_flickrset_allowfullscreen = trim($this->params->get('flickrset_allowfullscreen', $this->default_allowfullscreen));
        $plgparam_flickrset_objectwidth = trim($this->params->get('flickrset_objectwidth', $this->default_objectwidth));
        $plgparam_flickrset_objectheight = trim($this->params->get('flickrset_objectheight', $this->default_objectheight));
        $plgparam_flickrset_flickrapikey = trim($this->params->get('flickrset_flickrapikey'));
        $plgparam_flickrset_type = trim($this->params->get('flickrset_type', $this->default_link_type));
        $plgparam_flickrset_mobile_type = trim($this->params->get('flickrset_mobile_type', $this->default_mobile_link_type));
        $this->log($context,$this->plg_name,$this->log_level_statement,'Plugin parameter flickrid/allowfullscreen/objectwidth/objectheight/flickrapikey/type/mobile_type: '.$plgparam_flickrset_flickrid.'/'.$plgparam_flickrset_allowfullscreen.'/'.$plgparam_flickrset_objectwidth.'/'.$plgparam_flickrset_objectheight.'/'.$plgparam_flickrset_flickrapikey.'/'.$plgparam_flickrset_type.'/'.$plgparam_flickrset_mobile_type);

        //Get the version number of the plugin
        $xml = JFactory::getXML(JPATH_PLUGINS.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.$this->plg_name.DIRECTORY_SEPARATOR.$this->plg_name.'.xml');
        $this->plg_version = $xml->version;
        $this->plg_copyrights_start = "\n\n<!-- \"FlickrSet\" Plugin version ".$this->plg_version." starts here -->\n";
        $this->plg_copyrights_end   = "\n<!-- \"FlickrSet\" Plugin version ".$this->plg_version." ends here -->\n\n";
        $this->log($context,$this->plg_name,$this->log_level_statement,'Runnig plugin version '.$this->plg_version);
        
        // Only when we are sure that plugin needs to be executed get mobile input
        $browser = JBrowser::getInstance();  // in the future, starting from 3.2, need to use $client = JFactory::getApplication()->client->browser; or JApplicationWebClient
        $agent = $browser->getAgentString();
        
        // Load plugin language,stylesheet file
        JPlugin::loadLanguage('plg_content_flickrset',JPATH_ADMINISTRATOR);
        JHtml::stylesheet('plg_content_flickrset/plg_content_flickrset.css', array(),true);
        
        // Expression to search for (positions)
        $regex = "/{".$this->plg_tag."}.*?{\/".$this->plg_tag."}/i";
        $this->log($context,$this->plg_name,$this->log_level_statement,'Regular expression to find positions of tags: '.$regex);

        // Determine if there are instances of $plg_tag and put them in $matches
        //  when no instances found do not perform tag replacement
        if (preg_match_all($regex, $article->text, $matches)) {
            // An array of all different elements used in the flickrset template
            $TmplElmtParams = array(
                    "{PLAYERID}",
                    "{FLICKR_SETID}",
                    "{FLICKR_SETIMG}",                
                    "{FLICKRID}",
                    "{LANGUAGE}",
                    "{OBJECT_WIDTH}",
                    "{OBJECT_HEIGHT}",
                    "{ALLOWFULLSCREEN}",
                    "{LINK_DISPLAY}",
                    "{CREATED_WITH_DISPLAY}"
                    );

            // Determine which tagsource to use depending on mobile device
            if ($browser->isMobile() || stristr($agent, 'mobile')) {
               $this->log($context,$this->plg_name,$this->log_level_statement,'Running on a MOBILE browser: '.$agent);
               // Show flickrset depending on the plugin mobile setting
               if ($plgparam_flickrset_mobile_type == 'L') {
                  $usedtagsource = $newtagsource[$this->plg_tag_link];
                  $this->log($context,$this->plg_name,$this->log_level_statement,'1) Used tag source: '.$this->plg_tag_link);
               } else {
                 if ($plgparam_flickrset_mobile_type == self::default_mobile_link_type) {
                    $usedtagsource = $newtagsource[$this->plg_tag_ess];
                    $this->log($context,$this->plg_name,$this->log_level_statement,'2) Used tag source: '.$this->plg_tag_ess);
                 } else {
                   $usedtagsource = $newtagsource[$this->plg_tag_button];
                   $this->log($context,$this->plg_name,$this->log_level_statement,'3) Used tag source: '.$this->plg_tag_button);
                 }
               }
            } else {
               $this->log($context,$this->plg_name,$this->log_level_statement,'Running on a NON MOBILE browser: '.$agent);
               // Show flickrset depending on the plugin setting
               if ($plgparam_flickrset_type == self::default_link_type) {
                  $usedtagsource = $newtagsource[$this->plg_tag_ess];
                  $this->log($context,$this->plg_name,$this->log_level_statement,'4) Used tag source: '.$this->plg_tag_ess);
               } else {
                 $usedtagsource = $newtagsource[$this->plg_tag];
                 $this->log($context,$this->plg_name,$this->log_level_statement,'5) Used tag source: '.$this->plg_tag);
               }
            }
              
            // Get the current language
            $lang = JFactory::getLanguage();
            $this->log($context,$this->plg_name,$this->log_level_statement,'Found language: '.$lang->getTag());
            
            // start the replace loop
            foreach ($matches[0] as $key => $match) {
                $this->log($context,$this->plg_name,$this->log_level_statement,'Processing tag: '.$match);
                
                // Remove the tags
                $tagcontent = preg_replace("/{.+?}/", "", $match);
                $this->log($context,$this->plg_name,$this->log_level_statement,'content without tags: '.$tagcontent);

                // Get an array of parameters
                // order of parameters: flickrsetid|width|height|flickrid|AllowFullScreen
                $tagparams = explode('|', $tagcontent);

                // Get the flickrsetid strip html/php tags
                $tagparam_flickrsetid = trim(strip_tags($tagparams[0]));

                // Get the width and height tags
                $final_objectwidth = (@$tagparams[1]) ? $tagparams[1] : $plgparam_flickrset_objectwidth;
                $final_objectheight = (@$tagparams[2]) ? $tagparams[2] : $plgparam_flickrset_objectheight;

                // Get the flickrid tag
                $final_flickrid = (@$tagparams[3]) ? $tagparams[3] : $plgparam_flickrset_flickrid;

                // Get the allow fullscreen tag
                $tag_allowfullscreen = (@$tagparams[4]) ? $tagparams[4] : $plgparam_flickrset_allowfullscreen;
                $final_allowfullscreen = (@$tag_allowfullscreen === 'Y') ? 'true' : 'false';

                // Set a unique ID
                $flickrset_playerID = 'FlickrSetID_'.substr(md5($tagparam_flickrsetid), 1, 10).'_'.rand();

                //Call Flickr API to get flickrset information
                //  only needs to be called when on a mobile device or when Flickr slideshow is chosen in the plugin
                if ( $browser->isMobile() || 
                     stristr($agent, 'mobile') ||
                     $plgparam_flickrset_type == self::default_link_type ||
                     $plgparam_flickrset_mobile_type == self::default_mobile_link_type
                   ) {
                     $flickrapi = $this->flickrapiurl.'method='.$this->flickrphotosetsgetInfomethod.'&api_key='.$plgparam_flickrset_flickrapikey.'&photoset_id='.$tagparam_flickrsetid.'&format='.$this->flickrrestformat;
                     $this->log($context,$this->plg_name,$this->log_level_statement,'Flickr API: '.$flickrapi);
                     $resp = file_get_contents($flickrapi);
                     $resp_obj = unserialize($resp);
                     if ($resp_obj['stat'] == 'ok') {
                         $flickrset_title = $resp_obj['photoset']['title']['_content'];
                         if ( $plgparam_flickrset_type == self::default_link_type ||
                              $plgparam_flickrset_mobile_type == self::default_mobile_link_type
                            ) {
                              $flickrset_primary = $resp_obj['photoset']['primary'];
                              $flickrset_secret = $resp_obj['photoset']['secret'];
                              $flickrset_server = $resp_obj['photoset']['server'];
                              $flickrset_farm = $resp_obj['photoset']['farm'];
                         }
                     }
                }
                
                // Construct the link name when on mobile device
                //  More information about the different suffixes can be found here: https://www.flickr.com/services/api/misc.urls.html
                if ($browser->isMobile() || stristr($agent, 'mobile')) {
                    $this->plg_created_with_display = '';
                    $this->plg_link_display = JText::sprintf('PLG_FLICKERSET_PROMPT_LINK_DISPLAY',$flickrset_title);
                    // On a mobile device we override the width in percentage in order to get it correct on the device.
                    $final_objectwidth = '100%';
                    $final_sizesuffix = 'm';
                } else {
                    $this->plg_created_with_display = JText::sprintf('PLG_FLICKERSET_CREATED_WITH_DISPLAY');
                    $this->plg_link_display = $flickrset_title;
                    $final_sizesuffix = 'n';
                };
                
                //Building the image url for the flickr slideshow
                $this->plg_flickrsetimg = 'https://farm'.$flickrset_farm.'staticflickr.com/'.$flickrset_server.'/'.$flickrset_primary.'_'.$flickrset_secret.'_'.$final_sizesuffix.'.jpg';

                // An array of all different elements values used in the flickrset template
                $TmplElmtParamValues = array(
                    $flickrset_playerID,
                    $tagparam_flickrsetid,
                    $this->plg_flickrsetimg,
                    $final_flickrid,
                    $lang->getTag(),
                    $final_objectwidth,
                    $final_objectheight,
                    $final_allowfullscreen,
                    $this->plg_link_display,
                    $this->plg_created_with_display
                );

                // Perform the actual tag replacement
                $convertedtag = $this->plg_copyrights_start.JFilterOutput::ampReplace(str_replace($TmplElmtParams, $TmplElmtParamValues, $usedtagsource)).$this->plg_copyrights_end;

                // Output
                $regex = "/{".$this->plg_tag."}".preg_quote($tagcontent)."{\/".$this->plg_tag."}/i";
                $article->text = preg_replace($regex, $convertedtag, $article->text);

            } // End foreach replacing loop
        } else { //when code comes here, no flickrset tags found to replace
            $this->log($context,$this->plg_name,$this->log_level_module,'No flickrset tags found to replace');
        }// End if find all instance of $plg_tag

        $this->log($context,$this->plg_name,$this->log_level_module,'End');

        return true;
    }

}

?>
