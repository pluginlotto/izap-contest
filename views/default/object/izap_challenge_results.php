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

$result = $vars['entity'];
?>
<div class="contentWrapper">
  <a href="<?php echo $result->getUrl()?>">
    <div>
      <div style="float: left; margin-right: 10px; width: 22%">
        #<?php echo $result->guid;?>
      </div>

      <div style="float: left; margin-right: 10px; width: 22%">
        <?php echo friendly_time($result->time_created);?>
      </div>

      <div style="float: left; margin-right: 10px; width: 12%">
        <?php echo (int)$result->total_score;?>
      </div>

      <div style="float: left; margin-right: 10px; width: 12%">
        <?php echo (int)($result->total_percentage < 0) ? 0 : $result->total_percentage;?>%
      </div>
      
      <div style="float: right; margin-right: 10px; width: 22%">
        <?php if($result->status == 'failed') {?>
        <b class="un_completed"><em><?php echo $result->status;?></em></b>
          <?php }else {?>
        <b class="completed"><em><?php echo $result->status;?></em></b>
          <?php }?>
      </div>
      
    </div>
    <div class="clearfloat"></div>
  </a>
</div>