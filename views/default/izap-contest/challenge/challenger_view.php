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
$challenge = $vars['challenge_entity'];
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
    'challenge_entity' => $challenge,
    'align' => "left",
    'size' => $iconsize,
    )
    );
    ?>
  </div>
  <div id="group_stats" style="float: left;">
    <?php 
    echo "<p>
      <b>" . elgg_echo("izap-contest:challenge:owner") . ": </b>
        <a href=\"" . get_user($challenge->owner_guid)->getURL() . "\">" . get_user($challenge->owner_guid)->name . "
          </a>
       </p>";
    ?>
    <?php echo elgg_view('input/rate', array('entity' => $challenge));?>
  </div>
</div>

<div id="groups_info_column_left">
  <?php
  if(!empty($challenge->required_correct)) {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:must_answer").":</b> ".$challenge->required_correct."%</p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:must_answer").":</b> ".elgg_echo('izap-contest:challenge:all_questions')."</p>";
  }
  if(!empty($challenge->max_quizzes)) {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:total_quiz").":</b> ".$challenge->max_quizzes."</p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:total_quiz").":</b> ".$challenge->total_quizzes()."</p>";
  }
  if(!empty($challenge->timer)) {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:max_time_in_min").":</b> ".$challenge->timer."</p>";
  }
  if($challenge->re_attempt) {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:can_re_attempt")."</b></p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:cant_re_attempt")."</b></p>";
  }
  if(!empty($challenge->negative_marking)) {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:negative_marking")."</b></p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("izap-contest:challenge:no_negative_markting")."</b></p>";
  }
  ?>
  <p class="odd"><b><?php echo elgg_echo("izap-contest:challenge:total_attempted"); ?>:</b> <?php echo (int) $challenge->total_attempted?></p>
  <p class="odd"><b><?php echo elgg_echo("izap-contest:challenge:total_passed"); ?>:</b> <?php echo (int) $challenge->total_passed?></p>
  <?php if(isloggedin()) {
    $user_var = get_loggedin_user()->username . '_total_attempted';
    $pass_var = get_loggedin_user()->username . '_total_passed';
    ?>
  <p class="odd"><b><?php echo elgg_echo("izap-contest:challenge:your_total_attempted"); ?>:</b> <?php echo (int) $challenge->$user_var?></p>
  <p class="odd"><b><?php echo elgg_echo("izap-contest:challenge:your_total_passed"); ?>:</b> <?php echo (int) $challenge->$pass_var?></p>
  <?php }?>

  <?php if($challenge->canEdit()) {?>
  <div align="right">
    <?php
    echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/edit_delete', array('entity' => $challenge));
    ?>
  </div>
  <?php }?>
</div>


<div class="clearfloat"></div>

<div class="contentWrapper"><?php echo $challenge->description; ?></div>
<?php if(isloggedin() && get_loggedin_userid() != $challenge->owner_guid) {?>
<div class="contentWrapper">
  <form action="<?php echo $vars['url']; ?>action/challenge/accept" method="post">
    <?php echo elgg_view('input/securitytoken');?>
    <input type="hidden" name="challenge[guid]" value="<?php echo $challenge->guid?>" />
    <?php if($challenge->canAttempt()) {?>
    <input type="submit" name="submit" value="<?php echo elgg_echo('izap-contest:challenge:take_now') ?>" />
    <?php }else{
      $time_var = get_loggedin_user()->username . '_last_attempt';
      $time = (int) $challenge->$time_var;
      if($time) {
      ?>
    <em>
      <?php echo elgg_echo('izap-contest:challenge:last_attempt') . friendly_time($time);?>
    </em>
    <?php }}?>
    <a
      href="<?php echo $vars['url'].
      'pg/challenge/result/'.
      $challenge->guid .'/'.
              friendly_title($challenge->title);?>"
              class="cancel_button"><?php echo elgg_echo('izap-contest:challenge:my_results') ?></a>
    
  </form>
</div>
<?php }?>
<div class="contentWrapper">
  <?php
  IzapBase::increaseViews($challenge);
  echo IzapBase::getViews($challenge);
  echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN. '/challenge/tabs/index', array('entity' => $challenge));
  ?>
</div>