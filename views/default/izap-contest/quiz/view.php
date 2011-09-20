<?php
/***************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 ***************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

if (!$vars['entity'])
  return;
?>
<div><div>
  <?php
    if (elgg_get_logged_in_user_guid() != $vars['entity']->owner_guid) {
    echo elgg_view('page/elements/title', array('title' => ' <span class="quiz_answer">'.elgg_echo('izap-contest:quiz:quiz',array((int) $_SESSION['challenge'][$vars['entity']->container_guid]['qc']+1)).'</span>'.$vars['entity']->title . ' ?'));
  }
  ?></div>
  <form action="<?php echo IzapBase::getFormAction('answer', GLOBAL_IZAP_CONTEST_PLUGIN) ?>" method="post">
<?php echo elgg_view('input/securitytoken'); ?>
    <div class="quiz_answer">
    <?php echo elgg_echo('izap-contest:quiz:answers');?>
    </div><div style="margin:10px;">
    <?php
    if (preg_match('/image.+/', $vars['entity']->get_quiz_mime())) {
      echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/quiz/image_view', array('entity' => $vars['entity']));
    } elseif (preg_match('/audio.+/', $vars['entity']->get_quiz_mime())) {
      echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/quiz/audio_view', array('entity' => $vars['entity']));
    } elseif (elgg_is_active_plugin(GLOBAL_IZAP_VIDEOS_PLUGIN) && preg_match('/video.+/', $vars['entity']->get_quiz_mime())) {
      echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/quiz/video_view', array('entity' => $vars['entity']));
    } else {
      echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/quiz/simple_view', array('entity' => $vars['entity']));
    }
    ?></div>
    <?php
    if ($vars['entity']->canEdit() && elgg_get_logged_in_user_guid() == $vars['entity']->owner_guid) {

      echo IzapBase::controlEntityMenu(array(
          'entity' => $vars['entity'],
          'handler' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
          'vars' => array($vars['entity']->container_guid, $vars['entity']->getGUID(), elgg_get_friendly_title($vars['entity']->title))
      ));
    } else {
      if (!isset($quiz_metadata_array[$_SESSION['user']->username])):
        echo izapbase::input('hidden', array('name' => 'quiz[guid]', 'value' => $vars['entity']->guid));
        echo izapbase::input('hidden', array('name' => 'quiz[container_guid]', 'value' => $vars['entity']->container_guid));
    ?>
        <p style="float:right;">
    <?php
        echo elgg_view('input/submit', array('name' => 'quiz[answer]', 'value' => elgg_echo('izap-contest:quiz:answer')));
        echo elgg_view('input/submit', array('name' => 'quiz[skip]', 'value' => elgg_echo('izap-contest:quiz:skip')));
    ?>
        </p>
      <?php endif;
      } ?>
    <div class="clearfloat"></div>
  </form>
</div>

