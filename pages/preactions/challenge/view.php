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