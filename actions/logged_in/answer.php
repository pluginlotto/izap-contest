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

// checks if the user's logged in
izapbase::gatekeeper();

// this page saves the current answer of the user while the test is ongoing
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

// check time... if user can answer
if (!$challenge_entity->timeLeft()) {
  register_error(elgg_echo('izap-contest:challenge:error:timeout'));
  $result = $challenge_entity->save_results(FALSE);
  forward(IzapBase::setHref(array(
              'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
              'action' => 'result',
              'page_owner' => false,
              'vars' => array(
                  $challenge_entity->guid,
                  $result->guid,
                  elgg_get_friendly_title($challenge_entity->title)
              )
                  )
          )
  );
}

// set total to zero, if it is not set yet, to calculate the negative marking.
if (!isset($_SESSION['challenge'][$challenge_entity->guid]['totals'])) {
  $_SESSION['challenge'][$challenge_entity->guid]['totals'] = 0;
}
// get all access from the system to user
Izapbase::getAllAccess();
// all answers
$answers_array = unserialize($quiz_entity->options);

$answer_var = elgg_get_logged_in_user_entity()->username . '_answer';
$correct_var = elgg_get_logged_in_user_entity()->username . '_is_correct';

if ($quiz_form['answer'] == 'Answer' && $quiz_entity->correct_option == $quiz_form['correct_option']) {
  $quiz_entity->$correct_var = 'yes';
  $_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['is_correct'] = TRUE;
  $_SESSION['challenge'][$challenge_entity->guid]['totals']++;
  $_SESSION['challenge'][$challenge_entity->guid]['total_correct_answers']++;
} else {
  $quiz_entity->$correct_var = 'no';
  $_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['is_correct'] = FALSE;
  if ($quiz_form['answer'] == 'Answer') {
    if ($challenge_entity->negative_marking) {
      $_SESSION['challenge'][$challenge_entity->guid]['totals']--;
    }
  } elseif ($quiz_form['skip'] == 'Skip') {
    
  }
}

$quiz_entity->$answer_var = $quiz_form['correct_option'];
// remove access from the user
Izapbase::removeAccess();
$_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['question'] = $quiz_entity->title;
$_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['description'] = $quiz_entity->description;
$_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['solution'] = $quiz_entity->solution;
$_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['answer'] = $answers_array[$quiz_form['correct_option']];
$_SESSION['challenge'][$challenge_entity->guid]['answers'][$quiz_entity->guid]['correct_answer'] = $answers_array[$quiz_entity->correct_option];
$_SESSION['challenge'][$challenge_entity->guid]['qc']++;
forward(izapbase::setHref(array(
            'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
            'action' => 'play',
            'page_owner' => FALSE,
            'vars' => array($challenge_entity->guid, elgg_get_friendly_title($challenge_entity->title), false)
                )
        )
);