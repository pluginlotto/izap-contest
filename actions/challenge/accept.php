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