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

global $CONFIG;
$attribs = IzapBase::getPostedAttributes();
if (IzapBase::hasFormError()) {
  register_error(elgg_echo("izap_elgg_bridge:error_empty_input_fields"));
  forward(REFERER);
}

if (!filter_var($attribs['send_email'], FILTER_VALIDATE_EMAIL) || !filter_var($attribs['email'], FILTER_VALIDATE_EMAIL)) {
  register_error(elgg_echo('izap-contest:not_valid_email'));
  forward(REFERER);
}

$entity = get_entity($attribs['guid']);
if (!$entity) {
  register_error(elgg_echo('izap-contest:not_valid_entity'));
  forward(REFERER);
}

$params = array();
$params['to'] = $attribs['send_email'];
$params['from'] = $attribs['email'];
$params['from_username'] = $attribs['name'];
$params['subject'] = elgg_echo('izap-contest:challenge_subject',array($entity->title));
$params['msg'] = "
  Hello, {$attribs['send_name']} \n
  I liked this challenge, {$entity->getURL()}. Go through it .\n
  <p>{$attribs['msg']}</p>
  From:\n
    {$attribs['name']},
    {$attribs['email']}.
  ";
// send email
$success = IzapBase::sendMail($params);


// Success message
if ($success) {
  system_message(elgg_echo('izap-contest:success_send_to_friend'));
  unset($_SESSION['postArray']);
} else {
  register_error(elgg_echo('izap-contest:error_send_to_friend'));
}
forward($entity->getURL());
