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

gatekeeper();
$container_guid = (int)get_input('container_guid');
$quiz_guid = (int)get_input('guid');
if (!$quiz_entity = get_entity($quiz_guid)){
  forward();
}
if (!$quiz_entity->canEdit()){
  forward();
}
$type = get_input('type');
set_page_owner($_SESSION['user']->guid);
$title = $quiz_entity->title;
$area2 = elgg_view_title(elgg_echo('zcontest:quiz:edit') . ': ' . $quiz_entity->title);
$area2 .= elgg_view('izap-contest/quiz/form/new_edit',array('quiz_entity' => $quiz_entity,'container_guid' => $container_guid, 'mtype' => $type));
$body = elgg_view_layout("two_column_left_sidebar", '', $area2);
page_draw($title,$body);