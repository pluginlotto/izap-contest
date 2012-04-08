<?php

/* * ***********************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * *************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// here the new created quiz is being saved
// Make sure we're logged in
IzapBase::gatekeeper();
if (IzapBase::hasFormError()) {
  if (sizeof(IzapBase::getFormErrors())) {
    foreach (IzapBase::getFormErrors() as $error) {
      register_error(elgg_echo($error));
    }
  }
  forward(REFERRER);
  exit;
}

// Get input data
$quiz_form = IzapBase::getPostedAttributes();
if (!isset($quiz_form['correct_option'])) {
  register_error(elgg_echo('izap-contest:quiz:error:no_options'));
  forward(REFERER);
}
$_SESSION['zcontest']['quiz'] = $quiz_form;

// Make sure the title isn't blank
$quiz_entity = new IzapQuiz($quiz_form['guid']);
IzapBase::updatePostedAttribute('tags', string_to_tag_array($quiz_entity['tags']));
$quiz_entity->setAttributes();
if ($quiz_form['qtype'] == 'video') {
  $video_api = new IZAPVideoApi($quiz_form['related_media']);
  $video = $video_api->createVideoEntity();
  if (isset($video_api->errors)) {
    foreach ($video_api->errors as $error)
      register_error($error);
  }
  $quiz_entity->video_guid = $video->guid;
}

// Set its owner to the current user
$challenge_entity = get_entity($quiz_form['container_guid']);
if (!$quiz_form['guid']) {
  $quiz_entity->container_guid = $quiz_form['container_guid'];
  $quiz_entity->access_id = $challenge_entity->access_id;
}

// Set its title and description appropriately
foreach ($quiz_form as $key => $val) {
  if (preg_match('/opt:[0-9]/', $key)) {
    if ($val != '') {
      $options[(string) $key] = (string) $val;
    }
  } else {
    if ($key == 'related_media') {
      $quiz_entity->$key = serialize(array('file_url' => $val, 'file_type' => 'video/flash_object'));
    }
  }
}
if (is_array($options) && sizeof($options) && $quiz_entity->correct_option != '') {
  $quiz_entity->options = serialize($options);
} else {
  $error_message[] = elgg_echo('izap-contest:quiz:error:no_options');
}
if (!empty($_FILES['related_media']['name'])) {
  $supproted_media = array('audio/mp3', 'audio/mpeg', 'image/jpeg', 'image/gif', 'image/png', 'image/jpg', 'image/jpe', 'image/pjpeg', 'image/x-png');
  if (!in_array($_FILES['related_media']['type'], $supproted_media)) {
    register_error(elgg_echo('There is no support for this uploaded file'));
    forward($REFERER); //failed, so forward to previous page
    exit;
  }
  $thumb = preg_match("/image\/jpeg|image\/gif|image\/png|image\/jpg|image\/jpe|image\/pjpeg|image\/x-png/", $_FILES['related_media']['type']) ?
          array('tiny' => '30x50', 'sqr' => '70', 'large' => '200x300') :
          false;
  $quiz_entity->izap_upload_generate_thumbs($_FILES);
}

$_SESSION['zcontest']['quiz'] = $quiz_form;

if (!$quiz_entity->save($challenge_entity)) {
  register_error("Error in saving question.");
  forward($REFERER);
  exit;
}

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

if ($quiz_form['guid']) {
  $rurl = ($quiz_entity->getUrl());
} else {
  $rurl = ($challenge_entity->getUrl());
}

forward($rurl);
