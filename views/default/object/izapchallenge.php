<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.0
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
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