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

<?php if($vars['challenge_entity']->canEdit()): ?>
<div class="contentWrapper">
  <div id="zcontest_block_submenu">
    <div class="zsubmenu">
      <ul>
        <?php if(!$vars['challenge_entity']->lock) {?>
        <li>
          <a href="<?php echo $CONFIG->wwwroot . "pg/quiz/new/". $vars['challenge_entity']->guid."/".$_SESSION['user']->username."?type=simple" ?>">
              <?php echo elgg_echo('zcontest:quiz:add')  ?>
          </a>
        </li>
        <li>
          <a href="<?php echo $CONFIG->wwwroot . "pg/challenge/edit/". $vars['challenge_entity']->guid; ?>">
              <?php echo elgg_echo('zcontest:challenge:edit')  ?>
          </a>
        </li>
        <li><?php
            echo elgg_view("output/confirmlink", array(
            'href' => $vars['url'] . "action/challenge/delete?guid=" . $vars['challenge_entity']->getGUID().'&curl='.urlencode($vars['url'].'pg/challenge/list/'.$_SESSION['user']->username),
            'text' => elgg_echo('zcontest:challenge:delete'),
            'confirm' => elgg_echo('zcontest:challenge:delete'),
            ));
            ?>
        </li>
        <?php }?>
        <!--
        <li>
            <?php
            echo elgg_view("output/confirmlink", array(
            'href' => $vars['url'] . "action/challenge/lock?guid=" . $vars['challenge_entity']->getGUID(),
            'text' => $vars['challenge_entity']->lock?"Unlock":"Lock"
            ));
            ?>
        </li>
        -->

        <li>
          <a href="?view_as_challenger=yes">
            <?php echo elgg_echo('zcontest:challenge:view_as_challenger')?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
<?php endif; ?>

<?php if($vars['challenge_entity']->max_quizzes && $vars['challenge_entity']->total_questions < $vars['challenge_entity']->max_quizzes):?>
<div class="contentWrapper">
  <em style="color:red;">
    <?php echo elgg_echo('zcontest:challenge:not_enough_questions') . $vars['challenge_entity']->max_quizzes . '</b>';?>
  </em>
</div>
<?php endif;?>

<?php if($vars['challenge_entity']->quizzes): ?>
  <?php echo elgg_view_title('Related quizzes' . ' ('.$vars['challenge_entity']->total_questions.')') ?>
<div class="contentWrapper">
    <?php
    echo elgg_list_entities(array('type' => 'object', 'subtype' => 'izapquiz', 'container_guid' => $vars['challenge_entity']->guid));
    ?>
</div>
<?php endif; ?>
