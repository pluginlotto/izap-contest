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

// this is the result page of the completed challenge
$result = $vars['result'];
$obtained_percentage = $result->total_percentage;
$width = $obtained_percentage;

if ($obtained_percentage <= 0) {
  $width = 1;
}
?>
<?php echo elgg_view('page/elements/title', array('title' => elgg_echo('izap-contest:challenge:result') . ': ' . $result->title)); ?>
<div class="contentWrapper">
  <?php
  echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/result_statistics', array('array' => unserialize($result->description)));
  ?>
</div>

<div class="contentWrapper">
  <div class="progress_bar_wrapper">
    <b><?php echo elgg_echo('izap-contest:challenge:passing_percentage'); ?>: <?php echo $result->required_percentage ?>%</b>
    <div style="background-color: white; width: 80%">
      <div class="progress_bar" style="background-color: #00FF00; width: <?php echo $result->required_percentage ?>%;"></div>
    </div>
  </div>
  <div class="progress_bar_wrapper">
    <b><?php echo elgg_echo('izap-contest:challenge:obtained_percentage'); ?>: <?php echo $obtained_percentage ?>%</b>
    <div style="background-color: white; width: 80%">
      <div class="progress_bar" style="background-color: <?php echo ($result->status == 'passed') ? '#00FF00' : '#FF0000' ?>;width: <?php echo $width ?>%;">    </div>
    </div>
  </div>
</div>

<div class="contentWrapper">
  <b><?php echo elgg_echo('izap-contest:result:total'); ?>: <?php echo $result->total_score; ?></b>
  <?php if ($result->is_completed == 'no') { ?>
    <b class="un_completed"><em><?php echo elgg_echo('izap-contest:challenge:not_completed'); ?></em></b>
  <?php } ?>

  <a href="<?php echo izapbase::setHref(array('context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER, 'action' => 'result', 'page_owner' => FALSE, 'vars' => array($result->container_guid, elgg_get_friendly_title($result->title)))) ?>" class="cancel_button">
    <?php echo elgg_echo('izap-contest:challenge:my_results') ?>
  </a>
</div>
<?php
unset($_SESSION['challenge'][$vars['contest']]);
unset($_SESSION['proper_started'][$vars['contest']]);
?>

