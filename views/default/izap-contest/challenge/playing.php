<?php
/* * ************************************************
 * PluginLotto.com                                  *
 * Copyrights (c) 2005-2011. iZAP                   *
 * All rights reserved                              *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

$challenge = $vars['challenge'];
$quiz = $vars['quiz'];
$quiz_time = (int) $challenge->timer * 60;
$spent_time = time() - ((int) $_SESSION['challenge'][$challenge->guid]['start_time']);
$left_time = $quiz_time - $spent_time;
$redirect = IzapBase::setHref(array(
            'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
            'action' => 'saveResults',
            'page_owner' => false,
            'vars' => array($challenge->guid)
        ));
?>

<div class="contentWrapper">
  <?php
  if ($quiz_time > 0) {
    echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/timer', array(
        'left_time' => $left_time,
        'challenge' => $challenge,
        'class' => 'timer',
        'redirect' => $redirect));
  }
  echo elgg_view('izap-contest/quiz/view', array('entity' => $quiz));
  ?>
</div>
