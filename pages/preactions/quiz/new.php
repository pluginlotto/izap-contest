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
gatekeeper();
$container_guid = get_input('container_guid');
$type = get_input('type');
set_page_owner($_SESSION['user']->guid);
$area1 = elgg_view_title(elgg_echo('zcontest:quiz:add'));
$area1 .= elgg_view("izap-contest/quiz/form/new_edit",array('container_guid' => $container_guid, 'mtype' => $type));
page_draw(elgg_echo('zcontest:quiz:add'),elgg_view_layout("two_column_left_sidebar", '' , $area1 ));