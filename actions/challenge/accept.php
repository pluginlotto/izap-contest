<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

gatekeeper();
global $CONFIG;

$challenge_form = get_input('challenge');
$challenge_entity = new IZAPChallenge($challenge_form['guid']);

func_hook_access_over_ride_byizap(array('status' => TRUE));
  $user_array = (array) $challenge_entity->accepted_by;
  $user_array[] = get_loggedin_userid();
  $user_array = array_unique($user_array);
  $challenge_entity->accepted_by = array();
  $challenge_entity->accepted_by = $user_array;
func_hook_access_over_ride_byizap(array('status' => FALSE));

forward($CONFIG->wwwroot . 'pg/challenge/play/' . $challenge_entity->guid . '/' . friendly_title($challenge_entity->title));
exit;