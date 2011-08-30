<?php
/***************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 ***************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */
?>
<div class="image_view">
<?php
echo $vars['entity']->get_media();
?>
</div>
<div class="options_view">
<?php
$quiz_metadata_array = unserialize($vars['entity']->quiz_metadata);
if (isset($quiz_metadata_array[$_SESSION['user']->username])) {
  echo elgg_view("input/radio", array("name" => "quiz[correct_option]", "disabled" => 1, 'value' => $quiz_metadata_array[$_SESSION['user']->username]['reply'], "options" => $vars['entity']->get_options()));
} else {
  echo elgg_view("input/radio", array("name" => "quiz[correct_option]", "options" => $vars['entity']->get_options(), 'value' => $vars['entity']->getCorrectAnswer()));
}
?>
  <div class="clearfloat"></div>
</div>