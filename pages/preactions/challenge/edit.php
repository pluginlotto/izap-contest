<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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