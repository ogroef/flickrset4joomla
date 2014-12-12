/**
 *
 * @version     $Id: add_flickrset_btn.js 0.2 2014/02/01 Olivier $
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

/**
 * cancelflickrset
 * 
 * @param char ename
 */
function cancelflickrset() {
    window.parent.SqueezeBox.close();
}

/**
 * insertflickrset
 * 
 * @param char tagname
 * @param char ename
 * 
 * Fuction inserts {flickrset} custom placement token in the folowing format
 *   {flickrset}flickrsetid|flickrid|width|height|allowfull{/flickrset}
 * 
 * @returns char
 */
function insertflickrset(tagname, ename) {
    var v_constructed_result = "{".concat(tagname, "}param1|param2|param3|param4|param5{/", tagname, "}");
    // Get the flickrsetid
    var v_flickrsetid = document.getElementById("flickrsetid").value;
    // Get the flickrid
    var v_flickrid = document.getElementById("flickrid").value;
    // Get the width dimension
    var v_width = document.getElementById("width").value;
    // Get the height dimension
    var v_height = document.getElementById("height").value;
    // Get the allowfull 
    var v_allowfull = document.getElementById("allowfull").value;

    // Replacing each token with value from input form, when no input given in form removing the token.
    if (v_flickrsetid != '')
    {
        if (v_flickrsetid !== null && isFinite(v_flickrsetid) && v_flickrsetid.length > 0)
        { // Process flickersetid
            v_constructed_result = v_constructed_result.replace("param1", v_flickrsetid);

            // Process width dimension
            if (v_width != '')
            {
                v_constructed_result = v_constructed_result.replace("param2", v_width);
            }
            else
            {
                v_constructed_result = v_constructed_result.replace("param2", '');
            }

            // Process height dimension
            if (v_height != '')
            {
                v_constructed_result = v_constructed_result.replace("param3", v_height);
            }
            else
            {
                v_constructed_result = v_constructed_result.replace("param3", '');
            }

            // Process flickerid
            if (v_flickrid != '')
            {
                v_constructed_result = v_constructed_result.replace("param4", v_flickrid);
            }
            else
            {
                v_constructed_result = v_constructed_result.replace("param4", '');
            }

            // Process allowfull
            if (v_allowfull != '')
            {
                v_constructed_result = v_constructed_result.replace("param5", v_allowfull);
            }
            else
            {
                v_constructed_result = v_constructed_result.replace("param5", '');
            }
            // Updating the editor text box with the generated tag
            window.parent.jInsertEditorText(v_constructed_result, ename);
            window.parent.SqueezeBox.close();
        }
        else
        {
            v_constructed_result = '';
        }
    }
    else
    {
        v_constructed_result = '';
    }
    return false;
}