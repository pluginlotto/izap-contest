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

$challenge = $vars['challenge'];
$quiz = $vars['quiz'];

$diff = time() - ((int)$_SESSION['challenge']['start_time']);

$minute = 60;
$hour = $minute * 60;
$day = $hour * 24;

if ($diff < $minute) {
  $friendly_time = sprintf(elgg_echo('zcontest:challenge:time_used'), $diff);
} else if ($diff < $hour) {
  $minutes = round($diff / $minute);
  $seconds = $diff%$minute;
  
  $friendly_time = sprintf(elgg_echo('zcontest:challenge:time_used_minute'), $minutes, $seconds);
}
echo elgg_view_title(elgg_echo('zcontest:contest') . ': ' . $challenge->title);
?>
<div class="contentWrapper">
  <div style="float:right;">
    <b>
      <?php echo $friendly_time?>
    </b>
  </div>
  <?php
  echo elgg_view('izap-contest/quiz/view', array('quiz_entity' => $quiz));
  ?>
</div>