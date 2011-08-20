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

$page_owner = page_owner_entity();
if(!$page_owner) {
  set_input('username', get_loggedin_user()->username);
  $page_owner = page_owner_entity();
}

$area2 = elgg_view_title($page_owner->name . '\'s ' . elgg_echo('zcontest:challenge:accepted'));
$list = list_entities_from_metadata('accepted_by', $page_owner->guid, 'object', GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE);

if(empty($list) || $list == '') {
  $area2 .= '<div class="contentWrapper">' . elgg_echo('zcontest:notfound') . '</div>';
}
else {
  $area2 .= $list;
}

// get tags and categories

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);
page_draw(sprintf(elgg_echo('zcontest:user'),$page_owner->name),$body);