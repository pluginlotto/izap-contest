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
$challenge_entity = $vars['challenge_entity'];
if ($challenge_entity instanceof IzapChallenge) {
if($vars['align']){
  $align = $vars['align'];
}else{
  $align = "left";
}
?>
<div class="challenge-icon">
  <a href="<?php echo $challenge_entity->getURL(); ?>" class="icon" ><img src="<?php echo $challenge_entity->getIconURL($vars['size']); ?>" border="0" <?php echo $align; ?> title="<?php echo $challenge_entity->title; ?>" <?php echo $vars['js']; ?> /></a>
</div>
<?php
	}
?>