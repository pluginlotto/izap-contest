<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

?>
<div class="options_view">
  <?php
  $quiz_metadata_array = unserialize($vars['quiz_entity']->quiz_metadata);
  if(isset($quiz_metadata_array[$_SESSION['user']->username])) {
    echo elgg_view("input/radio", array("internalname" => "quiz[correct_option]",  "disabled"=> 1, 'value'=>$quiz_metadata_array[$_SESSION['user']->username]['reply'], "options" => $vars['quiz_entity']->get_options()));
  }else {
    echo elgg_view("input/radio", array("internalname" => "quiz[correct_option]",  "options" => $vars['quiz_entity']->get_options()));
  }
  ?>

  <div class="clearfloat"></div>
</div>
