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

$challenge_guid = (int) get_input('guid');
$challange_url = urldecode(get_input('curl'));

$challenge_entity = get_entity($challenge_guid);
if($challenge_entity) {
  if($challenge_entity->delete_me()) {
    system_message(elgg_echo('zcontest:challenge:deleted'));
  }else {
    register_error(elgg_echo('zcontest:challenge:notdeleted'));
  }
}else {
  register_error(elgg_echo('zcontest:challenge:notdeleted'));
}
forward($challange_url);
exit;