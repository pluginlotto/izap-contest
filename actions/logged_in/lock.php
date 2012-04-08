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

gatekeeper();

// locks a challenge if user wants it to be unavailable for other users for a particular time
$challenge_guid = get_input('guid');
$challenge_entity = new IzapChallenge($challenge_guid);
$challenge_entity->lock = ($challenge_entity->lock) ? 0 : 1;
if (!$challenge_entity->save()) {
  register_error("Can not lock/unlock");
}
system_message("Challenge is " . ($challenge_entity->lock) ? "Locked" : "Unlocked");

forward($_SERVER['HTTP_REFERER']);
exit;