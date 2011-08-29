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

if(!$vars['entity'])
  return;
?>
<div>
  <?php
  
  if(elgg_get_logged_in_user_guid() != $vars['entity']->owner_guid) {
    echo elgg_view('page/elements/title',array('title'=>$vars['entity']->title . ' ?'));
  }
  ?>
  <form action="<?php echo IzapBase::getFormAction('answer', GLOBAL_IZAP_CONTEST_PLUGIN)?>" method="post">
    <?php echo elgg_view('input/securitytoken');?>
    <?php
    
    if(preg_match('/image.+/', $vars['entity']->get_quiz_mime())) {
    include(dirname(__FILE__).'/image_view.php');
    }elseif(preg_match('/audio.+/', $vars['entity']->get_quiz_mime())) {
    include(dirname(__FILE__).'/audio_view.php');
    }elseif(elgg_is_active_plugin(GLOBAL_IZAP_VIDEOS_PLUGIN) && preg_match('/video.+/', $vars['entity']->get_quiz_mime())) {
      include(dirname(__FILE__).'/video_view.php');
    }else {
      include(dirname(__FILE__).'/simple_view.php');
    }

    ?>
    <?php
    if($vars['entity']->canEdit() && elgg_get_logged_in_user_guid() == $vars['entity']->owner_guid) {

      echo IzapBase::controlEntityMenu(array(
            'entity' => $vars['entity'],
            'handler' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
            'vars' => array($vars['entity']->container_guid, $vars['entity']->getGUID(), elgg_get_friendly_title($vars['entity']->title))
        ));

     
    }else {
      if(!isset($quiz_metadata_array[$_SESSION['user']->username])):
              echo izapbase::input('hidden',array('name' => 'quiz[guid]','value' =>$vars['entity']->guid));
              echo izapbase::input('hidden',array('name' => 'quiz[container_guid]','value' => $vars['entity']->container_guid));
      ?>
    <p style="float:right;">
      <?php
      echo elgg_view('input/submit',array('name' => 'quiz[answer]','value' => elgg_echo('izap-contest:quiz:answer')));
      echo elgg_view('input/submit',array('name' => 'quiz[skip]','value' => elgg_echo('izap-contest:quiz:skip')));
      ?>
    </p>
      <?php endif;
    }?>
    <div class="clearfloat"></div>
  </form>
</div>

