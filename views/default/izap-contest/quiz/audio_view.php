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
<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/izap-contest/audioplayer/audio-player.js"></script>
<!-- set up the player -->
<script type="text/javascript">
  AudioPlayer.setup("<?php echo $vars['url']; ?>mod/izap-contest/audioplayer/player.swf", {
    width: 290
  });
</script>

<div class="audio_view" id="zplayer" >
  <script type="text/javascript">
    AudioPlayer.embed("zplayer", {soundFile: "<?php echo $vars['url']; ?>mod/izap-contest/content.php?id=<?php echo $vars['entity']->getGUID(); ?>"});
  </script>
</div>
<div class="options_view">
  <?php
  $quiz_metadata_array = unserialize($vars['entity']->quiz_metadata);
  if(isset($quiz_metadata_array[$_SESSION['user']->username])) {
    echo elgg_view("input/radio", array("internalname" => "quiz[correct_option]",  "disabled"=> 1, 'value'=>$quiz_metadata_array[$_SESSION['user']->username]['reply'], "options" => $vars['entity']->get_options()));
  }else {
    echo elgg_view("input/radio", array("internalname" => "quiz[correct_option]",  "options" => $vars['entity']->get_options()));
  }
  ?>
  <div class="clearfloat"></div>
</div>