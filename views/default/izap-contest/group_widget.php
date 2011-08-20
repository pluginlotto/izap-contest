<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$challenges = elgg_get_entities(array('container_guid' => $vars['entity']->guid, 'type' => 'object', 'subtype' => GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE));
?>
<div class="group_widget">
  <?php
  echo elgg_view_title(elgg_echo('zcontest:challenge:group:list'));
  if($challenges) {
    foreach($challenges as $challenge):
      echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/listing', array('entity' => $challenge));
    endforeach;
    ?>
  <div class="forum_latest">
    <a href="<?php echo
    $CONFIG->wwwroot . 'pg/' . GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER .
            '/list/' . $vars['entity']->guid . '/' . $vars['entity']->username?>"><?php echo elgg_echo('zcontest:challenge:group:list:all')?></a>
  </div>
    <?php
  }else {
    ?>
  <div class="forum_latest"><?php echo elgg_echo('zcontest:notfound');?></div>
    <?php
  }
  ?>
</div>
