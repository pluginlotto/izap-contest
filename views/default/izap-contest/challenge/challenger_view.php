<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

if ($vars['full'] == true) {
  $iconsize = "large";
} else {
  $iconsize = "medium";
}
?>

<div id="groups_info_column_right"><!-- start of groups_info_column_right -->
  <div id="groups_icon_wrapper"><!-- start of groups_icon_wrapper -->
    <?php
    echo elgg_view(
    "output/icon", array(
    'challenge_entity' => $vars['challenge_entity'],
    'align' => "left",
    'size' => $iconsize,
    )
    );
    ?>
  </div><!-- end of groups_icon_wrapper -->
  <div id="group_stats" style="float: left;"><!-- start of group_stats -->
    <?php 
    echo "<p>
      <b>" . elgg_echo("groups:owner") . ": </b>
        <a href=\"" . get_user($vars['challenge_entity']->owner_guid)->getURL() . "\">" . get_user($vars['challenge_entity']->owner_guid)->name . "
          </a>
       </p>";
    ?>
    <?php echo elgg_view('input/rate', array('entity' => $vars['challenge_entity']));?>
  </div>
  <!-- end of group_stats -->
</div><!-- end of groups_info_column_right -->

<div id="groups_info_column_left"><!-- start of groups_info_column_left -->
  <?php
  if(!empty($vars['challenge_entity']->required_correct)) {
    echo "<p class=\"odd\"><b>".elgg_echo("You must answer").":</b> ".$vars['challenge_entity']->required_correct."%</p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("You must answer").":</b> All questions</p>";
  }
  if(!empty($vars['challenge_entity']->max_quizzes)) {
    echo "<p class=\"odd\"><b>".elgg_echo("Total quizzes").":</b> ".$vars['challenge_entity']->max_quizzes."</p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("Total quizzes").":</b> ".$vars['challenge_entity']->total_quizzes()."</p>";
  }
  if(!empty($vars['challenge_entity']->timer)) {
    echo "<p class=\"odd\"><b>".elgg_echo("Maximum time in minutes").":</b> ".$vars['challenge_entity']->timer."</p>";
  }
  if($vars['challenge_entity']->re_attempt) {
    echo "<p class=\"odd\"><b>".elgg_echo("You can re-attempte the quiz after 48 hrs.")."</b></p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("You can not re-attempte the quiz.")."</b></p>";
  }
  if(!empty($vars['challenge_entity']->negative_marking)) {
    echo "<p class=\"odd\"><b>".elgg_echo("Negative marking is applicable.")."</b></p>";
  }else {
    echo "<p class=\"odd\"><b>".elgg_echo("No negative marking.")."</b></p>";
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
</div><!-- end of groups_info_column_left -->


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