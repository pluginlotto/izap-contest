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

$array = $vars['array'];
?>
<ol>
  <?php
  if(is_array($array) && sizeof($array)):
  foreach($array as $quiz_guid => $stats):
    $class = ($stats['is_correct']) ? 'correct_answer' : 'wrong_answer';
    $status = ($stats['is_correct']) ? 'correct.png' : 'wrong.png';
    ?>
  <li>
    <p>
    <h3>
        <?php echo ($stats['question']);?>
    </h3>
    <div class="contentWrapper">
        <?php echo ($stats['description']);?><br />
      <img src="<?php echo func_get_www_path_byizap(array('plugin' => 'izap-contest', 'type' => 'graphics')) . $status?>" />
        <b><?php echo elgg_echo('zcontest:result:your_answer') . '</b>: ' . $stats['answer']?>
      <br />
      <b><?php echo elgg_echo('zcontest:result:correct_answer') . '</b>: ' . $stats['correct_answer']?>
        <br />
        <em>
            <?php echo $stats['solution'] ?>
        </em>
    </div>
    </p>
  </li>
  <?php
  endforeach;
  endif;
  ?>
</ol>