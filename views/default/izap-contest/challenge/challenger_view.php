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

if ($vars['full'] == true) {
  $iconsize = "large";
} else {
  $iconsize = "medium";
}
?>

<div id="groups_info_column_right">
  <div id="groups_icon_wrapper">
    <?php
    echo elgg_view(
    "output/icon", array(
    'challenge_entity' => $vars['challenge_entity'],
    'align' => "left",
    'size' => $iconsize,
    )
    );
    ?>
  </div>
  <div id="group_stats" style="float: left;">
    <?php 
    echo "<p>
      <b>" . elgg_echo("zcontest:challenge:owner") . ": </b>
        <a href=\"" . get_user($vars['challenge_entity']->owner_guid)->getURL() . "\">" . get_user($vars['challenge_entity']->owner_guid)->name . "
          </a>
       </p>";
    ?>
    <?php echo elgg_view('input/rate', array('entity' => $vars['challenge_entity']));?>
  </div>
</div>

<div id="groups_info_column_left">
  <?php
  if(!empty($vars['challenge_entity']->required_correct)) {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:must_answer").":</b> ".$vars['challenge_entity']->required_correct."%</p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:must_answer").":</b> ".elgg_echo('zcontest:challenge:all_questions')."</p>";
  }
  if(!empty($vars['challenge_entity']->max_quizzes)) {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:total_quiz").":</b> ".$vars['challenge_entity']->max_quizzes."</p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:total_quiz").":</b> ".$vars['challenge_entity']->total_quizzes()."</p>";
  }
  if(!empty($vars['challenge_entity']->timer)) {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:max_time_in_min").":</b> ".$vars['challenge_entity']->timer."</p>";
  }
  if($vars['challenge_entity']->re_attempt) {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:can_re_attempt")."</b></p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:cant_re_attempt")."</b></p>";
  }
  if(!empty($vars['challenge_entity']->negative_marking)) {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:negative_marking")."</b></p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("zcontest:challenge:no_negative_markting")."</b></p>";
  }
  ?>
  <p class="odd"><b><?php echo elgg_echo("zcontest:challenge:total_attempted"); ?>:</b> <?php echo (int) $vars['challenge_entity']->total_attempted?></p>
  <p class="odd"><b><?php echo elgg_echo("zcontest:challenge:total_passed"); ?>:</b> <?php echo (int) $vars['challenge_entity']->total_passed?></p>
  <?php if(isloggedin()) {
    $user_var = get_loggedin_user()->username . '_total_attempted';
    $pass_var = get_loggedin_user()->username . '_total_passed';
    ?>
  <p class="odd"><b><?php echo elgg_echo("zcontest:challenge:your_total_attempted"); ?>:</b> <?php echo (int) $vars['challenge_entity']->$user_var?></p>
  <p class="odd"><b><?php echo elgg_echo("zcontest:challenge:your_total_passed"); ?>:</b> <?php echo (int) $vars['challenge_entity']->$pass_var?></p>
  <?php }?>
</div>


<div class="clearfloat"><?php
  //zp(unserialize($vars['challenge_entity']->quizzes));
  ?></div>

<div class="contentWrapper"><?php echo $vars['challenge_entity']->description; ?></div>
<?php if(isloggedin()) {?>
<div class="contentWrapper">
  <form action="<?php echo $vars['url']; ?>action/challenge/accept" method="post">
    <?php echo elgg_view('input/securitytoken');?>
    <input type="hidden" name="challenge[guid]" value="<?php echo $vars['challenge_entity']->guid?>" />
    <?php if($vars['challenge_entity']->canAttempt()) {?>
    <input type="submit" name="submit" value="<?php echo elgg_echo('zcontest:challenge:take_now') ?>" />
    <?php }else{
      $time_var = get_loggedin_user()->username . '_last_attempt';
      $time = (int) $vars['challenge_entity']->$time_var;
      if($time) {
      ?>
    <em>
      <?php echo elgg_echo('zcontest:challenge:last_attempt') . friendly_time($time);?>
    </em>
    <?php }}?>
    <a href="<?php echo $vars['url']. 'pg/challenge/result/'. $vars['challenge_entity']->guid ?>/
            <?php echo friendly_title($vars['challenge_entity']->title);?>" class="cancel_button">
            <?php echo elgg_echo('zcontest:challenge:my_results') ?></a>
    
  </form>
</div>
<?php }?>
<div class="contentWrapper">
  <?php
  echo elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'tabs/index', array('entity' => $vars['challenge_entity']));
  ?>
</div>