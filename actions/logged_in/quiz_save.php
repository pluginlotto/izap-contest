<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
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
if (IzapBase::hasFormError()) {
  if (sizeof(IzapBase::getFormErrors())) {
    foreach (IzapBase::getFormErrors() as $error) {
      register_error(elgg_echo('izap-contest:quiz' . $error));
    }
  }
  forward(REFERRER);
  exit;
}
// Get input data
$quiz_form = IzapBase::getPostedAttributes();
$_SESSION['zcontest']['quiz'] = $quiz_form;

// Make sure the title isn't blank
$quiz_entity = new IzapQuiz($quiz_form['guid']);

// Set its owner to the current user
$challenge_entity = get_entity($quiz_form['container_guid']);
if (!$quiz_form['guid']) {
  $quiz_entity->container_guid = $quiz_form['container_guid'];
  $quiz_entity->access_id = $challenge_entity->access_id;
}



if (!$challenge_entity->canEdit() || $challenge_entity->lock) {
  register_error("Can not add new quiz in locked challenge.");
  unset($_SESSION['zcontest']['quiz']);
  forward($challenge_entity->getURL());
  exit;
}

// Set its title and description appropriately
foreach ($quiz_form as $key => $val) {

  if (preg_match('/opt:[0-9]/', $key)) {
    if ($val != '') {
      $options[$key] = $val;
    }
  } else {
    if ($key == 'related_media') {
      $quiz_entity->$key = serialize(array('file_url' => $val, 'file_type' => 'video/flash_object'));
    } else {
      $quiz_entity->$key = $val;
    }
  }
}
if (is_array($options) && sizeof($options) && $quiz_entity->correct_option != '') {
  $quiz_entity->options = serialize($options);
} else {
  $error_message[] = elgg_echo('izap-contest:quiz:error:no_options');
}
$quiz_entity->tags = string_to_tag_array($quiz_form['tags']);

//if(sizeof($error_message)) {
//  register_error(implode("\n", $error_message));
//  forward($REFERER);
//}
//c($_FILES['related_media']);exit;
if (!empty($_FILES['related_media']['name'])) {
  $supproted_media = array('audio/mp3', 'audio/mpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/jpg', 'image/jpe', 'image/pjpeg', 'image/x-png');
  if (!in_array($_FILES['related_media']['type'], $supproted_media)) {
    register_error(elgg_echo('There is no support for this uploaded file'));
    forward($REFERER); //failed, so forward to previous page
    exit;
  }
//  $thumb = preg_match("/image\/jpeg|image\/gif|image\/png|image\/jpg|image\/jpe|image\/pjpeg|image\/x-png/",$_FILES['related_media']['type'])?
//          array('tiny' => '30x50', 'sqr' => '70', 'large' => '200x300'):
//          false;
//    $quiz_entity->izap_upload_generate_thumbs($_FILES);
}

$_SESSION['zcontest']['quiz'] = $quiz_form;

if (!$quiz_entity->save($challenge_entity)) {
  register_error("Error in saving question.");
  forward($REFERER);
  exit;
}
IzapBase::saveImageFile(array(
            'destination' => 'contest/quiz' . $quiz_entity->guid . '/icon',
            'content' => file_get_contents($_FILES['related_media']['tmp_name']),
            'owner_guid' => $quiz_entity->owner_guid,
            'create_thumbs' => (in_array($_FILES['related_media']['type'], array(
                'image/jpeg',
                'image/gif',
                'image/png',
                'image/jpg',
                'image/jpe',
                'image/pjpeg',
                'image/x-png')
            )
            )
        ));

$tmp_quizzes = (array) unserialize($challenge_entity->quizzes);
$tmp_quizzes[$quiz_entity->guid] = $quiz_entity->guid;
foreach ($tmp_quizzes as $quiz) {
  if ((int) $quiz > 0) {
    $quizzes[] = $quiz;
  }
}
$quizzes = array_unique($quizzes);
$challenge_entity->total_questions = count($quizzes);
$challenge_entity->quizzes = serialize($quizzes);

// Success message
system_message(elgg_echo('Quiz created successfully'));
// Remove the album post cache
unset($_SESSION['zcontest']['quiz']);
// need to save some database queries first

$rurl = get_input('rurl', FALSE);
if ($rurl) {
  
} elseif ($quiz_form['guid']) {
  $rurl = ($quiz_entity->getUrl());
} else {
  $rurl = ($challenge_entity->getUrl());
}

forward($rurl);
exit;