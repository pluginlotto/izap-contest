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


<?php if($vars['challenge_entity']->max_quizzes && $vars['challenge_entity']->total_questions < $vars['challenge_entity']->max_quizzes):?>
<div class="contentWrapper">
  <em style="color:red;">
    <?php echo elgg_echo('izap-contest:challenge:not_enough_questions') . $vars['challenge_entity']->max_quizzes . '</b>';?>
  </em>
</div>
<?php endif;?>

<?php if($vars['challenge_entity']->quizzes): ?>
  <?php echo elgg_view_title('Related quizzes' . ' ('.$vars['challenge_entity']->total_questions.')') ?>
<div class="contentWrapper">
    <?php
    echo elgg_list_entities(array(
      'type' => 'object',
      'subtype' => GLOBAL_IZAP_CONTEST_SUBTYPE_QUIZ,
      'container_guid' => $vars['challenge_entity']->guid));
    ?>
</div>
<?php endif; ?>
