<?php
/*
* To change this template, choose Tools | Templates
* and open the template in the editor.
*/
require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");
gatekeeper();
set_page_owner($_SESSION['user']->guid);
$area1 = elgg_view_title(elgg_echo('zcontest:challenge:add'));
$area1 .= elgg_view("izap-contest/challenge/form/new_edit");
page_draw(elgg_echo('zcontest:challenge:add'),elgg_view_layout("two_column_left_sidebar", '' , $area1 ));