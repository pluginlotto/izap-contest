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

// only for the loggedin users
gatekeeper();
$guid = get_input('container_guid');
$contest = new IZAPChallenge($guid,TRUE);

if(!$contest->can_play()) {
  register_error(elgg_echo('zcontest:challenge:not_accepted_yet'));
  forward($contest->getURL());
}

$quiz = $contest->current_question();
  $area2 = elgg_view(func_get_template_path_byizap(array('type'=>'challenge', 'plugin' => 'izap-contest')). 'playing', array('challenge' => $contest, 'quiz' => $quiz));
$body = elgg_view_layout("two_column_left_sidebar", '', $area2);

// Display page
page_draw($contest->title,$body);