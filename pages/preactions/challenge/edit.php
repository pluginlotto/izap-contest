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
$challenge_guid = (int)get_input('guid');
if(!$challenge_entity = get_entity($challenge_guid)){
  forward();
}
if(!$challenge_entity->canEdit()){
  forward();
}
set_page_owner($_SESSION['user']->guid);
$title = $challenge_entity->title;
$area2 = elgg_view_title(sprintf(elgg_echo('zcontest:challenge:edit'),$title));
$area2 .= elgg_view('izap-contest/challenge/form/new_edit',array('challenge_entity' => $challenge_entity));
$body = elgg_view_layout("two_column_left_sidebar", '', $area2);
page_draw($title, $body);