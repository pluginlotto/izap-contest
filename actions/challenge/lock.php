<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

gatekeeper();

$challenge_guid = get_input('guid');


$challenge_entity = new IZAPChallenge($challenge_guid);

$challenge_entity->lock = ($challenge_entity->lock)?0:1;

if(!$challenge_entity->save()){
  register_error("Can not lock/unlock");
}
system_message("Challenge is ".($challenge_entity->lock)?"Locked":"Unlocked");

forward($_SERVER['HTTP_REFERER']);
exit;