<?php
/**
 *
 * @version     $Id: insertflickrset.php 0.1 2014/02/01 Olivier $
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
// no direct access
defined('_JEXEC') or die('Restricted access');

// add javascript dialog onclick code
JHtml::script('plg_editors-xtd_add_flickrset_btn/add_flickrset_btn.js', false, true);

// Import Joomla! Plugin library file
JImport('joomla.plugin.plugin');

$ename = $_GET['e_name'];
$flickrsettag = $_GET['flickrsettag'];
$addflickrsetbuttonversion = $_GET['addflickrsetbuttonversion'];
?>
<form name="insertflickrset_form" id="insertflickrset_form" onSubmit="return false;">
    <fieldset>	
        <table class="properties">
            <tr>
                <th><h3><i><?php echo JText::_('PLG_EDITORS-XTD_FLICKRSET_TITLE'); ?></i></h3></th>
            </tr>
            <tr>
                <td class="key" align="right">
                    <label for="flickrsetid"><?php echo JText::_('PLG_EDITORS-XTD_FLICKRSET_PROMPT'); ?> : </label>
                </td>
                <td nowrap>
                    <input type="number" id="flickrsetid" name="flickrsetid" required="required" autofocus="autofocus" />
                </td>
            </tr>
            <tr>
                <td class="key" align="right">
                    <label for="flickrid"><?php echo JText::_('PLG_EDITORS-XTD_FLICKRID_PROMPT'); ?> : </label>
                </td>
                <td nowrap>
                    <input type="text" id="flickrid" name="flickrid" />
                </td>
            </tr>
            <tr>
                <td class="key" align="right">
                    <label for="width"><?php echo JText::_('PLG_EDITORS-XTD_WIDTH_PROMPT'); ?> : </label>
                </td>
                <td nowrap>
                    <input type="number" id="width" name="width" />
                </td>
            </tr>
            <tr>
                <td class="key" align="right">
                    <label for="height"><?php echo JText::_('PLG_EDITORS-XTD_HEIGHT_PROMPT'); ?> : </label>
                </td>
                <td nowrap>
                    <input type="number" id="height" name="height" />
                </td>
            </tr>
            <tr>
                <td class="key" align="right">
                    <label for="allowfull"><?php echo JText::_('PLG_EDITORS-XTD_ALLOW_FULL_PROMPT'); ?> : </label>
                </td>
                <td nowrap>
                    <select id="allowfull" name="allowfull">
                        <option value="Y" selected>Yes</option>
                        <option value="N">No</option>
                    </select>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset>
        <table class="properties" align="right">
            <tr>
                <td colspan="1" align="right" valign="bottom" nowrap>
                    <input type="submit" value="<?php echo JText::_('PLG_EDITORS-XTD_FLICKRSET_ADD_BUTTON'); ?>" onClick="insertflickrset('<?= $flickrsettag ?>', '<?= $ename ?>');" class="bt">
                    <input type="button" value="<?php echo JText::_('PLG_EDITORS-XTD_FLICKRSET_CANCEL_BUTTON'); ?>" onClick="cancelflickrset();" class="bt">
                </td>
            </tr>
            <tr>
                <td colspan="1" align="left" valign="bottom" nowrap>
                    <font color="BBBBBB"><i><?php echo JText::_('PLG_EDITORS-XTD_VERSION_PROMPT'); ?> <?= $addflickrsetbuttonversion ?></i></font> 
                </td>
            </tr>
        </table>
    </fieldset>
</form>