<?php
/***************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 ***************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

$challenge = $vars['challenge'];
$quiz = $vars['quiz'];

$diff = time() - ((int)$_SESSION['challenge']['start_time']);

$minute = 60;
$hour = $minute * 60;
$day = $hour * 24;

if ($diff < $minute) {
  $friendly_time = elgg_echo('izap-contest:challenge:time_used', array($diff));
} else if ($diff < $hour) {
  $minutes = round($diff / $minute);
  $seconds = $diff%$minute;
  
  $friendly_time = elgg_echo('izap-contest:challenge:time_used_minute', array($minutes, $seconds));
}
echo elgg_view('page/elements/title',array('title'=>elgg_echo('izap-contest:contest') . ': ' . $challenge->title));
?>
<div class="contentWrapper">
  <div style="float:right;">
    <b>
      <?php echo $friendly_time?>
    </b>
  </div>
  <?php
  echo elgg_view('izap-contest/quiz/view', array('entity' => $quiz));
  ?>
</div>