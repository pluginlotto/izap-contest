<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
?>

<div class="quizWrapper">
  <h3>
    <a href="<?php echo $vars['entity']->getUrl()?>" >
      <?php echo $vars['entity']->title;?>
    </a>
  </h3>
  <?php
  echo ($vars['entity']->canEdit())?elgg_view("output/confirmlink", array(
  'href' => $vars['url'] . "action/quiz/delete?guid=" . $vars['entity']->getGUID().'&curl='.urlencode(current_page_url()),
  'text' => elgg_echo('delete'),
  'confirm' => elgg_echo('zcontest:quiz:delete'),
  )):'';
  ?><!--
   /
   <a href="<?php echo $vars['url']?>pg/quiz/edit/<?php echo $vars['entity']->container_guid?>/<?php echo $vars['entity']->guid?>?type=<?php echo $vars['entity']->qtype;?>">
     <?php echo elgg_echo('zcontest:quiz:edit');?>
   </a>
    -->
</div>