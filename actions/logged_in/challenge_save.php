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

// here the new challlenge that created by the user is being saved
IzapBase::gatekeeper();
if (IzapBase::hasFormError()) {
  if (sizeof(IzapBase::getFormErrors())) {
    foreach (IzapBase::getFormErrors() as $error) {
      register_error(elgg_echo($error));
    }
  }
  forward(REFERRER);
}

//get all form attributes
$challenge_form = IzapBase::getPostedAttributes();

$_SESSION['zcontest']['challenge'] = $challenge_form;

$challenge_entity = new IzapChallenge((int) $challenge_form['guid']);
IzapBase::updatePostedAttribute('tags', string_to_tag_array($challenge_form['tags']));
$challenge_entity->setAttributes();
if ($challenge_entity->max_quizzes < 2) {
  $challenge_entity->max_quizzes = 2;
}
//save the media for the quiz
$challenge_entity->izap_upload_generate_thumbs($_FILES, $thumb);

if (!$challenge_entity->save()) {
  register_error(elgg_echo("Error in challenge creation"));
  forward(REFERER);
}// checks the format of the uploaded files, if it is authorised
if (!empty($_FILES['related_media']['name'])) {
  $supproted_media = array('audio/mp3', 'image/jpeg', 'image/gif', 'image/png', 'image/jpg', 'image/jpe', 'image/pjpeg', 'image/x-png');
  if (!in_array($_FILES['related_media']['type'], $supproted_media)) {
    register_error(elgg_echo('izap-contest:no file support'));
    forward(REFERER); //failed, so forward to previous page
  }
}
// saves the uploaded files
IzapBase::saveImageFile(array(
    'destination' => 'contest/' . $challenge_entity->guid . '/icon',
    'content' => file_get_contents($_FILES['related_media']['tmp_name']),
    'owner_guid' => $challenge_entity->owner_guid,
    'create_thumbs' => True
));

// This will inherit the access_id from challenge to quiz. Check if the entity is going to be edit
//if so than check if the old access id same. if so than skip this process.
if (isset($challenge_form['guid']) && $old_challenge_access_id != $challenge_entity->access_id) {
  $quizzes_in_this_challenge = elgg_get_entities(array(
      'type' => 'object',
      'subtype' => GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE,
      'container_guid' => $challenge_form['guid']));
  foreach ($quizzes_in_this_challenge as $quiz_key => $quiz_entity) {
    $quiz_entity->access_id = $challenge_entity->access_id;
    $quiz_entity->save();
  }
}
system_message($challenge_form['guid'] ? "Challenge updated successfully" : "Challenge created successfully");

unset($_SESSION['zcontest']['challenge']);
forward($challenge_entity->getURL());


