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
$friends_array = get_loggedin_user()->getFriends('', 999999);
foreach($friends_array as $friend) {
  $value[] = $friend->guid;
}
?>
<form action="<?php echo $vars['url']?>action/challenge/challenge_friends" method="POST">
  <?php 
  echo elgg_view('input/securitytoken');
  echo elgg_view('friends/picker', array('entities' => $friends_array, 'value' => $value));
  echo elgg_view('input/hidden', array('internalname' => 'challenge_guid', 'value' => $vars['entity']->guid));
  echo elgg_view('input/submit', array('value' => elgg_echo('zcontest:challenge:challenge_friends')));
  ?>
</form>