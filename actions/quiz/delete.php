<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

gatekeeper();

$quiz_guid = (int) get_input('guid');
$challange_url = urldecode(get_input('curl'));

$quiz_entity = new IZAPquiz($quiz_guid);
if($quiz_entity->delete_me()){
  system_message(elgg_echo('zcontest:quiz:deleted'));
}else{
  register_error(elgg_echo('zcontest:quiz:notdeleted'));
}
forward($challange_url);
exit;