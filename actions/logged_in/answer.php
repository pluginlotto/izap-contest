<?php

/* * *************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// Make sure we're logged in
izapbase::gatekeeper();
// Get input data
$quiz_form = get_input('quiz');
// Cache to the session
// Make sure the title isn't blank
$quiz_entity = new IzapQuiz($quiz_form['guid']);
$quiz_entity->izap_grant_edit();

$challenge_entity = get_entity($quiz_entity->container_guid);
if (!$challenge_entity->can_play()) {
  register_error(elgg_echo('izap-contest:challenge:not_accepted_yet'));
  forward($challenge_entity->getURL());
}

// check time... if user can ansser
if (!$challenge_entity->timeLeft()) {
  register_error(elgg_echo('izap-contest:challenge:error:timeout'));
  forward($challenge_entity->getURL());
}

// set total to zero, if it is not set yet, to calculate the negative marking.
if (!isset($_SESSION['challenge']['totals'])) {
  $_SESSION['challenge']['totals'] = 0;
}
// get all access from the system to user
Izapbase::getAllAccess();
// all answers
$answers_array = unserialize($quiz_entity->options);

$answer_var = elgg_get_logged_in_user_entity()->username . '_answer';
$correct_var = elgg_get_logged_in_user_entity()->username . '_is_correct';

if ($quiz_form['answer'] == 'Answer' && $quiz_entity->correct_option == $quiz_form['correct_option']) {
  $quiz_entity->$correct_var = 'yes';
  $_SESSION['challenge']['answers'][$quiz_entity->guid]['is_correct'] = TRUE;
  $_SESSION['challenge']['totals']++;
  $_SESSION['challenge']['total_correct_answers']++;
} else {
  $quiz_entity->$correct_var = 'no';
  $_SESSION['challenge']['answers'][$quiz_entity->guid]['is_correct'] = FALSE;
  if ($quiz_form['answer'] == 'Answer') {
    if ($challenge_entity->negative_marking) {
      $_SESSION['challenge']['totals']--;
    }
  } elseif ($quiz_form['skip'] == 'Skip') {

  }
}

$quiz_entity->$answer_var = $quiz_form['correct_option'];
// remove access from the user
Izapbase::removeAccess();
$_SESSION['challenge']['answers'][$quiz_entity->guid]['question'] = $quiz_entity->title;
$_SESSION['challenge']['answers'][$quiz_entity->guid]['description'] = $quiz_entity->description;
$_SESSION['challenge']['answers'][$quiz_entity->guid]['solution'] = $quiz_entity->solution;
$_SESSION['challenge']['answers'][$quiz_entity->guid]['answer'] = $answers_array[$quiz_form['correct_option']];
$_SESSION['challenge']['answers'][$quiz_entity->guid]['correct_answer'] = $answers_array[$quiz_entity->correct_option];
$_SESSION['challenge']['qc']++;
forward(izapbase::setHref(array(
            'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
            'action' => 'play',
            'page_owner' => FALSE,
            'vars' => array($challenge_entity->guid, friendly_title($challenge_entity->title))
                )
        )
);
