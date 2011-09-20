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

if($vars['challenge_entity']->max_quizzes && $vars['challenge_entity']->total_questions < $vars['challenge_entity']->max_quizzes):?>
<div>
  <em style="color:red;">
    <?php echo elgg_echo('izap-contest:challenge:not_enough_questions') . $vars['challenge_entity']->max_quizzes . '</b>';?>
  </em>
</div>
<?php endif;?>

<?php if($vars['challenge_entity']->quizzes): ?>
  <?php echo elgg_view('page/elements/title',array('title'=>'Related quizzes' . ' ('.$vars['challenge_entity']->total_questions.')'. $vars['control_menu'])); ?>
<div>
    <?php
    echo elgg_list_entities(array(
      'type' => 'object',
      'subtype' => GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE,
      'container_guid' => $vars['challenge_entity']->guid));
    ?>
</div>
<?php endif;
?>
