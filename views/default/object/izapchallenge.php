<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<div class="contentWrapper">
  <h3>
    <a href="<?php echo $vars['entity']->getUrl()?>" >
      <?php echo $vars['entity']->title;?>
    </a>
  </h3>
  <?php
   if($vars['entity']->canEdit()){
   echo elgg_view("output/confirmlink", array(
                        'href' => $vars['url'] . "action/challenge/delete?guid=" . $vars['entity']->getGUID().'&curl='.urlencode(current_page_url()),
                        'text' => elgg_echo('zcontest:challenge:delete'),
                        'confirm' => elgg_echo('zcontest:challenge:delete'),
                      ));
   }
   ?>
</div>