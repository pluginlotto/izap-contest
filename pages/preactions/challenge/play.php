<?php
/**************************************************
* iZAP Web Solutions                              *
* Copyrights (c) 2005-2009. iZAP Web Solutions.   *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Kumar<tarun@izap.in>"
 */

// only for the loggedin users
gatekeeper();
set_input('username', get_loggedin_user()->username);
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
page_draw(elgg_echo('izap_offer_article:detail'),$body);