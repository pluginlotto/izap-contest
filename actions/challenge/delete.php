<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

gatekeeper();

$challenge_guid = (int) get_input('guid');
$challange_url = urldecode(get_input('curl'));

$challenge_entity = new IZAPChallenge($challenge_guid);
if($challenge_entity->delete_me()){
  system_message(elgg_echo('zcontest:challenge:deleted'));
}else{
  register_error(elgg_echo('zcontest:challenge:notdeleted'));
}
forward($challange_url);
exit;