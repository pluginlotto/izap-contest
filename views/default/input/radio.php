<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.0
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
*/
	/**
	 * Elgg radio input
	 * Displays a radio input field
	 *
	 * @package Elgg
	 * @subpackage Core

	 * @author Curverider Ltd

	 * @link http://elgg.org/
	 *
	 * @uses $vars['value'] The current value, if any
	 * @uses $vars['js'] Any Javascript to enter into the input tag
	 * @uses $vars['internalname'] The name of the input field
	 * @uses $vars['options'] An array of strings representing the options for the radio field as "label" => option
	 *
	 */

	$class = $vars['class'];
	if (!$class) $class = "input-radio";
    foreach($vars['options'] as $label => $option) {
        if (strtolower($option) != strtolower($vars['value'])) {
            $selected = "";
        } else {
            $selected = "checked = \"checked\"";
        }
        if (isset($vars['internalid'])) $id = "id=\"{$vars['internalid']}\"";
        if ($vars['disabled']) $disabled = ' disabled="yes" ';
        echo "<label><input type=\"radio\" $disabled {$vars['js']} name=\"{$vars['internalname']}\" $id value=\"".htmlentities($option, ENT_QUOTES, 'UTF-8')."\" {$selected} class=\"$class\" />{$label}</label><br />";
    }
?>