<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

?>
<script type="text/javascript" src="<?php echo $vars['url']; ?>mod/izap-contest/audioplayer/audio-player.js"></script>
<!-- set up the player -->
<script type="text/javascript">
  AudioPlayer.setup("<?php echo $vars['url']; ?>mod/izap-contest/audioplayer/player.swf", {
    width: 290
  });
</script>

<div class="audio_view" id="zplayer">
  <script type="text/javascript">
    AudioPlayer.embed("zplayer", {soundFile: "<?php echo $vars['url']; ?>mod/izap-contest/content.php?id=<?php echo $vars['quiz_entity']->getGUID(); ?>"});
  </script>
</div>
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