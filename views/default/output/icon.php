<?php
$challenge_entity = $vars['challenge_entity'];
if ($challenge_entity instanceof IZAPChallenge) {
if($vars['align']){
  $align = $vars['align'];
}else{
  $align = "left";
}
?>
<div class="challenge-icon">
<a href="<?php echo $challenge_entity->getURL(); ?>" class="icon" ><img src="<?php echo $challenge_entity->getIcon($vars['size']); ?>" border="0" <?php echo $align; ?> title="<?php echo $challenge_entity->title; ?>" <?php echo $vars['js']; ?> /></a>
</div>
<?php
	}
?>