<?php
/**************************************************
* iZAP Web Solutions                              *
* Copyrights (c) 2005-2009. iZAP Web Solutions.   *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Kumar<tarun@izap.in>"
 */

gatekeeper();
$friends = get_input('friend');
$challenge = new IZAPChallenge(get_input('challenge_guid'));
if(sizeof($friends)) {
 $challenge->inviteFriends($friends);
}
forward($_SERVER['HTTP_REFERER']);
exit;
