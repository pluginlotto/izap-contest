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

// Make sure we're logged in
gatekeeper();
// Get input data
$quiz_form = get_input('quiz');
// Cache to the session

// Make sure the title isn't blank
$quiz_entity = new IZAPquiz($quiz_form['guid']);
$quiz_entity->izap_grant_edit();

$challenge_entity = get_entity($quiz_entity->container_guid);
if(!$challenge_entity->can_play()) {
  register_error(elgg_echo('zcontest:challenge:not_accepted_yet'));
  forward($challenge_entity->getURL());
}

// check time... if user can ansser
if(!$challenge_entity->timeLeft()) {
  register_error(elgg_echo('zcontest:challenge:error:timeout'));
  forward($challenge_entity->getURL());
}

// set total to zero, if it is not set yet, to calculate the negative marking.
if(!isset ($_SESSION['challenge']['totals'])) {
  $_SESSION['challenge']['totals'] = 0;
}
// get all access from the system to user
func_hook_access_over_ride_byizap(array('status' => TRUE));
// all answers
$answers_array = unserialize($quiz_entity->options);

$answer_var = get_loggedin_user()->username . '_answer';
$correct_var = get_loggedin_user()->username . '_is_correct';

if ($quiz_form['answer'] == 'Answer' && $quiz_entity->correct_option == $quiz_form['correct_option']) {
  $quiz_entity->$correct_var = 'yes';
  $_SESSION['challenge']['answers'][$quiz_entity->guid]['is_correct'] = TRUE;
  $_SESSION['challenge']['totals']++;
  $_SESSION['challenge']['total_correct_answers']++;
  system_message(elgg_echo(':)! Correct answer.'));
}else {
  $quiz_entity->$correct_var = 'no';
  $_SESSION['challenge']['answers'][$quiz_entity->guid]['is_correct'] = FALSE;
  if($quiz_form['answer'] == 'Answer') {
  if($challenge_entity->negative_marking) {
    $_SESSION['challenge']['totals']--;
  }
  register_error(elgg_echo(':(! Wrong answer.'));
  }elseif($quiz_form['skip'] == 'Skip'){
    register_error(elgg_echo(':(! Skipped.'));
  }
}

$quiz_entity->$answer_var = $quiz_form['correct_option'];
// remove access from the user
func_hook_access_over_ride_byizap(array('status' => FALSE));
$_SESSION['challenge']['answers'][$quiz_entity->guid]['question'] = $quiz_entity->title;
$_SESSION['challenge']['answers'][$quiz_entity->guid]['description'] = $quiz_entity->description;
$_SESSION['challenge']['answers'][$quiz_entity->guid]['solution'] = $quiz_entity->solution;
$_SESSION['challenge']['answers'][$quiz_entity->guid]['answer'] = $answers_array[$quiz_form['correct_option']];
$_SESSION['challenge']['answers'][$quiz_entity->guid]['correct_answer'] = $answers_array[$quiz_entity->correct_option];
$_SESSION['challenge']['qc']++;
forward($CONFIG->wwwroot . 'pg/challenge/play/' . $challenge_entity->guid . '/' . friendly_title($challenge_entity->title));
exit;