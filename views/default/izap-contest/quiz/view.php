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

if(!$vars['quiz_entity'])
  return;
?>
<?php echo elgg_view_title(trim($vars['quiz_entity']->title))?>
<div class="contentWrapper">
  <form action="<?php echo $vars['url']; ?>action/quiz/answer" method="post">
    <?php echo elgg_view('input/securitytoken');?>
    <?php
    if(preg_match('/image.+/', $vars['quiz_entity']->get_quiz_mime())) {
      include(dirname(__FILE__).'/image_view.php');
    }elseif(preg_match('/audio.+/', $vars['quiz_entity']->get_quiz_mime())) {
      include(dirname(__FILE__).'/audio_view.php');
    }elseif(is_plugin_enabled('izap_videos') && preg_match('/video.+/', $vars['quiz_entity']->get_quiz_mime())) {
      include(dirname(__FILE__).'/video_view.php');
    }else {
      include(dirname(__FILE__).'/simple_view.php');
    }

    ?>
    <?php if(!isset($quiz_metadata_array[$_SESSION['user']->username])): ?>
    <input type="hidden" name="quiz[guid]" value="<?php echo $vars['quiz_entity']->guid ?>" />
    <input type="hidden" name="quiz[container_guid]" value="<?php echo $vars['quiz_entity']->container_guid ?>" />
    <p style="float:right;">
      <input type="submit" name="quiz[answer]" value="<?php echo elgg_echo('zcontest:quiz:answer') ?>" />
      <input type="submit" name="quiz[skip]" value="<?php echo elgg_echo('zcontest:quiz:skip') ?>" />
    </p>
    <?php endif; ?>
    <div class="clearfloat"></div>
  </form>
</div>

