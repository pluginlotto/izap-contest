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

//shows the detail view of the result page
$result = $vars['entity'];
?>
<div class="contentWrapper">
  <a href="<?php echo izapbase::setHref(array('context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER, 'action' => 'result', 'page_owner' => FALSE, 'vars' => array($result->container_guid, $result->guid, elgg_get_friendly_title($result->title)))) ?>">
    <div>
      <div style="float: left; margin-right: 10px; width: 22%">
        #<?php echo $result->guid; ?>
      </div>

      <div style="float: left; margin-right: 10px; width: 22%">
        <?php echo elgg_view_friendly_time($result->time_created); ?>
      </div>

      <div style="float: left; margin-right: 10px; width: 12%">
        <?php echo (int) $result->total_score; ?>
      </div>

      <div style="float: left; margin-right: 10px; width: 12%">
        <?php echo (int) ($result->total_percentage < 0) ? 0 : $result->total_percentage; ?>%
      </div>

      <div style="float: right; margin-right: 10px; width: 22%">
        <?php if ($result->status == 'failed') { ?>
          <b class="un_completed"><em><?php echo $result->status; ?></em></b>
        <?php } else { ?>
          <b class="completed"><em><?php echo $result->status; ?></em></b>
        <?php } ?>
      </div>

    </div>
    <div class="clearfloat"></div>
  </a>
</div>