<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// get the video id as input
//gatekeeper();

// get quiz id
$id = (int)get_input('guid');

if (!$quiz_entity = get_entity($id))
    forward();

set_page_owner($quiz_entity->owner_guid);

$title = $quiz_entity->title;

$area2 = elgg_view_title(sprintf(elgg_echo('zcontest:quiz'), $quiz_entity->title));
$area2 .= elgg_view('izap-contest/quiz/view',array('quiz_entity' => $quiz_entity,'container_guid' => (int)get_input('container_guid')));

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);

page_draw($title,$body);