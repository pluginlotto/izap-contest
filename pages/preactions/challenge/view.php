<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

// get the video id as input
//gatekeeper();

// get quiz id
$id = (int)get_input('guid');

if (!$challenge_entity = get_entity($id))
    forward();

set_context('quiz');
set_page_owner($challenge_entity->owner_guid);
$title = $challenge_entity->title;

$area2 = elgg_view_title(sprintf(elgg_echo('zcontest:challenge'), $challenge_entity->title));
$area2 .= elgg_view('izap-contest/challenge/view',array('challenge_entity' => $challenge_entity));

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);

page_draw($title,$body);