<?php

/* * *************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// here the request to accept the challenge is being send to the friend
IzapBase::gatekeeper();
$friends = get_input('friend');
$challenge = new IzapChallenge(get_input('challenge_guid'));
if (sizeof($friends)) {
  $challenge->inviteFriends($friends);
}
forward(REFERER);

