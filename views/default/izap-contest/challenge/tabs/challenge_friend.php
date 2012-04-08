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

// this is a form that 'challenging a friend option i s given
$friends_array = elgg_get_logged_in_user_entity()->getFriends('', 999999);
foreach ($friends_array as $friend) {
  $value[] = $friend->guid;
}
?><!--displays the form for challenge a friend-->
<form action="<?php echo IzapBase::getFormAction('challenge_friends', GLOBAL_IZAP_CONTEST_PLUGIN) ?>" method="POST">
  <?php 
  
  //this is the form for channenge a friend
  echo elgg_view('input/securitytoken');
  echo elgg_view('input/friendspicker', array('entities' => $friends_array, 'value' => $value));
  echo elgg_view('input/hidden', array('name' => 'challenge_guid', 'value' => $vars['entity']->guid));
  echo elgg_view('input/submit', array('value' => elgg_echo('izap-contest:challenge:challenge_friends')));
  ?>
</form>