<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");
gatekeeper();
$container_guid = get_input('container_guid');
$type = get_input('type');
set_page_owner($_SESSION['user']->guid);
$area1 = elgg_view_title(elgg_echo('zcontest:quiz:add'));
$area1 .= elgg_view("izap-contest/quiz/form/new_edit",array('container_guid' => $container_guid, 'mtype' => $type));
page_draw(elgg_echo('zcontest:quiz:add'),elgg_view_layout("two_column_left_sidebar", '' , $area1 ));