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

gatekeeper();

$challenge_form = get_input('challenge');

$_SESSION['zcontest']['challenge'] = $challenge_form;

$challenge_entity = new IZAPChallenge($challenge_form['guid']);

$required  = array(
        'title', 'required_correct',
);


if($challenge_entity->lock) {
  register_error("Locked challenge can not be updated.");
  unset($_SESSION['zcontest']['challenge']);
  forward($challenge_entity->getURL());
  exit;
}

foreach($challenge_form as $key => $val) {
  if(in_array($key, $required) && $val == '') {
    $error_message[] = elgg_echo('zcontest:challenge:error:' . $key);
  }
  $challenge_entity->$key = $val;
}

if(sizeof($error_message)) {
  register_error(implode("\n", $error_message));
  forward($_SERVER['HTTP_REFERER']);
}

$challenge_entity->re_attempt = ($challenge_form['re_attempt'])?1:0;
$challenge_entity->could_edit = ($challenge_form['could_edit'])?1:0;
$challenge_entity->negative_marking = ($challenge_form['negative_marking'])?1:0;
$challenge_entity->tags = string_to_tag_array($challenge_form['tags']);
if($challenge_entity->max_quizzes < 2) {
  $challenge_entity->max_quizzes = 2;
}


if(!empty($_FILES['related_media']['name'])) {
  $supproted_media = array('audio/mp3','image/jpeg','image/gif','image/png','image/jpg','image/jpe','image/pjpeg','image/x-png');
  if(!in_array($_FILES['related_media']['type'],$supproted_media)) {
    register_error(elgg_echo('There is no support for this uploaded file'));
    forward($_SERVER['HTTP_REFERER']); //failed, so forward to previous page
    exit;
  }
  $thumb = preg_match("/image\/jpeg|image\/gif|image\/png|image\/jpg|image\/jpe|image\/pjpeg|image\/x-png/",$_FILES['related_media']['type'])?
          array('medium' => '200'):
          false;
  $challenge_entity->izap_upload_generate_thumbs($_FILES, $thumb);
}

if(!$challenge_entity->save_me()) {
  register_error("Error in challenge creation.");
  forward($_SERVER['HTTP_REFERER']);
  exit;
}

// This will inherit the access_id from challenge to quiz. Check if the entity is going to be edit
//if so than check if the old access id same. if so than skip this process.
if(isset($challenge_form['guid']) && $old_challenge_access_id != $challenge_entity->access_id) {
  $quizzes_in_this_challenge = get_entities('object','izapquiz',$challenge_form['guid']);
  foreach($quizzes_in_this_challenge as $quiz_key => $quiz_entity) {
    $quiz_entity->access_id = $challenge_entity->access_id;
    $quiz_entity->save();
  }
}

// saving some extra metadata.. to save queries
$challenge_entity->slug = friendly_title($challenge_entity->title);
$challenge_entity->owner_username = get_loggedin_user()->username;
$challenge_entity->owner_name = get_loggedin_user()->name;
$challenge_entity->container_username = get_entity($challenge_entity->container_guid)->username;
$challenge_entity->container_name = get_entity($challenge_entity->container_guid)->name;


system_message($challenge_form['guid']?"Challenge updated successfully":"Challenge created successfully");

if($challenge_form['guid']) {
  $river_action = 'updated';
}else {
  $river_action = 'created';
}

add_to_river('river/object/zcontest/common', $river_action, get_loggedin_userid(), $challenge_entity->guid);
unset($_SESSION['zcontest']['challenge']);
forward($challenge_entity->getURL());
exit;

