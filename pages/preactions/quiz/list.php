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

require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");
// get page owner entity


if($page_owner == $_SESSION['user'])
  $area2 = elgg_view_title(elgg_echo('zcontest:quiz:my'));
elseif($page_owner)
  $area2 = elgg_view_title(sprintf(elgg_echo('zcontest:user'),$page_owner->name));
else
  $area2 = elgg_view_title(elgg_echo('zcontest:quiz:all'));

  // get user videos
  $list .= list_user_objects($page_owner->guid,'izapquiz',10,false);

  if(empty($list) || $list == '')
    $area2 .= '<div class="contentWrapper">' . elgg_echo('zcontest:notfound') . '</div>';
  else
    $area2 .= $list;

// get tags and categories

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);
page_draw(sprintf(elgg_echo('zcontest:user'),$page_owner->name),$body);