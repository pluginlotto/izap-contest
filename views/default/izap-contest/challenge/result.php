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

$result = $vars['result'];
$obtained_percentage = $result->total_percentage;
$width = $obtained_percentage;

if($obtained_percentage <= 0) {
  $width = 1;
}
?>
<?php echo elgg_view_title(elgg_echo('zcontest:challenge:result') . ': ' . $result->title); ?>
<div class="contentWrapper">
  <?php
  echo elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'result_statistics', array('array' => unserialize($result->description)));
  ?>
</div>

<div class="contentWrapper">
  <div class="progress_bar_wrapper">
    <b><?php echo elgg_echo('zcontest:challenge:passing_percentage');?>: <?php echo $result->required_percentage?>%</b>
    <div style="background-color: white; width: 80%">
    <div class="progress_bar" style="background-color: #00FF00; width: <?php echo $result->required_percentage?>%;"></div>
    </div>
  </div>
  <div class="progress_bar_wrapper">
    <b><?php echo elgg_echo('zcontest:challenge:obtained_percentage');?>: <?php echo $obtained_percentage?>%</b>
    <div style="background-color: white; width: 80%">
    <div class="progress_bar" style="background-color: <?php echo ($result->status == 'passed') ? '#00FF00' : '#FF0000'?>;width: <?php echo $width?>%;">    </div>
    </div>
  </div>
</div>

<div class="contentWrapper">
  <b><?php echo elgg_echo('zcontest:result:total');?>: <?php echo $result->total_score;?></b>
  <?php if($result->is_completed == 'no') {?>
  <b class="un_completed"><em><?php echo elgg_echo('zcontest:challenge:not_completed');?></em></b>
    <?php }?>

  <a href="<?php echo $vars['url']. 'pg/challenge/result/'. $result->container_guid ?>/<?php echo friendly_title($result->title)?>" class="cancel_button">
    <?php echo elgg_echo('zcontest:challenge:my_results') ?>
  </a>
</div>
<?php unset($_SESSION['challenge']);?>

