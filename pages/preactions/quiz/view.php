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

if (!$quiz_entity = get_entity($id))
    forward();

$challenge = get_entity($quiz_entity->container_guid);
if(get_loggedin_userid() != $challenge->owner_guid && !$challenge->can_play()) {
  forward($challenge->getURL());
}
set_page_owner($challenge->container_guid);

$title = $quiz_entity->title;
$area2 = elgg_view_title('<a href="'.$challenge->getURL().'">' . $challenge->title . '</a> :' . sprintf(elgg_echo('zcontest:quiz'), $quiz_entity->title));
$area2 .= elgg_view('izap-contest/quiz/view',array('quiz_entity' => $quiz_entity,'container_guid' => (int)get_input('container_guid')));

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);

page_draw($title,$body);