<?php
/* * *************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

$challenge = $vars['challenge_entity'];
if ($vars['full_view'] == true) {
  $iconsize = "large";
} else {
  $iconsize = "medium";
}
?>
<div>
  <div id="groups_info_column_right">
    <div id="groups_icon_wrapper">
      <?php
      echo $challenge->getThumb($iconsize);
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


    </div>
    <div class ="control_menu">
      <?php
      echo $vars['control_menu'];
      ?>
    </div>
  </div>

  <div id="groups_info_column_left">
    <table  class="elgg-table-alt">
      <tbody><tr>
          <th class="contest_header" colspan="2">
            <?php echo elgg_echo('izap-contest:challenge:details'); ?>
          </th>
          <th></th>
        </tr>
        <tr>
          <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:must_answer") ?>
          </td>
          <td>
            <?php
            if (!empty($challenge->required_correct))
              echo $challenge->required_correct . '%';else
              echo elgg_echo('izap-contest:challenge:all_questions'); ?>
          </td>
        </tr><tr>
          <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:total_quiz") ?>
          </td>
          <td>
            <?php
            if (!empty($challenge->max_quizzes))
              echo $challenge->max_quizzes; else
              echo $challenge->total_quizzes(); ?>
          </td>
        </tr>
        <?php if (!empty($challenge->timer)): ?>
              <tr>
                <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:max_time_in_min") ?>
            </td>
            <td>
            <?php echo $challenge->timer; ?>
            </td>
          </tr>
        <?php
              endif;
              if ($challenge->re_attempt != '') :
        ?>
                <tr>
                  <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:can_re_attempt") ?>
              </td>
              <td>
            <?php echo $challenge->re_attempt ?> hours
              </td>
            </tr>
        <?php else : ?><tr>
                    <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:cant_re_attempt") ?>
                </td>
                <td></td>
              </tr>
        <?php endif; ?>
                  <tr>
                    <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:negative_marking") ?>
                </td><td>
            <?php
                  if (!empty($challenge->negative_marking)):
                    echo elgg_echo("izap-contest:challenge:negative_marking_applicable");
                  else:
                    echo elgg_echo("izap-contest:challenge:negative_marking_not_applicable");
                  endif;
            ?>
                </td>
              </tr>
              <tr>
                <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:total_attempted"); ?>
                </td>
                <td>
            <?php echo (int) $challenge->total_attempted ?>
                </td>
              </tr>
              <tr>
                <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:total_passed"); ?>
                </td>
                <td>
            <?php echo (int) $challenge->total_passed ?>
                </td>
              </tr>
        <?php
                  if (elgg_is_logged_in ()) :
                    $user_var = elgg_get_logged_in_user_entity()->username . '_total_attempted';
                    $pass_var = elgg_get_logged_in_user_entity()->username . '_total_passed';
        ?>
                    <tr>
                      <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:your_total_attempted"); ?>
                  </td>
                  <td>
            <?php echo (int) $challenge->$user_var ?>
                  </td>
                </tr>
                <tr>
                  <td class="contest_details">
            <?php echo elgg_echo("izap-contest:challenge:your_total_passed"); ?>
                  </td>
                  <td>
            <?php echo (int) $challenge->$pass_var ?>
                  </td>
                </tr>
        <?php endif; ?>
                  </tbody>
                </table>
              </div>
              <div class="clearfloat"></div>

              <br/>
            </div>



            <div class="contentWrapper"><?php echo $challenge->description; ?></div>
<?php if (elgg_is_logged_in() && elgg_get_logged_in_user_guid() != $challenge->owner_guid) {
?>
                      <div class="contentWrapper">
                        <form action="<?php echo IzapBase::getFormAction('accept', GLOBAL_IZAP_CONTEST_PLUGIN) ?>" method="post">
    <?php echo elgg_view('input/securitytoken'); ?>
                      <input type="hidden" name="challenge[guid]" value="<?php echo $challenge->guid ?>" />
    <?php
                      if ($challenge->canAttempt()) {
                         echo IzapBase::input('submit', array('name' => 'submit', 'value' => elgg_echo('izap-contest:challenge:take_now')));
                      } else {
                        $time_var = elgg_get_logged_in_user_entity()->username . '_last_attempt';
                        $time = (int) $challenge->$time_var;

                        if ($challenge->re_attempt != '') {
                          $quiz_time = 60 * 60 * $challenge->re_attempt;
                        $left_time = $time+$quiz_time -time();
                        $action =IzapBase::input('submit', array('name' => 'submit', 'value' => elgg_echo('izap-contest:challenge:take_now')));
                      echo '<div style="float:left">'.elgg_echo('izap-contest:next_attempt').'</div>';
                          echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN.'/challenge/timer', array('challenge' => $challenge, 'left_time' =>$left_time,'class' => 'timer2','redirect' => current_page_url() ));
                        }

                        if ($time) {
    ?>
                          <br/>
                          <em>
      <?php echo elgg_echo('izap-contest:challenge:last_attempt') . elgg_view_friendly_time($time);?>
                        </em>

    <?php
                        }
                      }
                      echo elgg_view('output/url', array(
                          'href' => izapbase::sethref(array(
                              'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                              'action' => 'result',
                              'page_owner' => false,
                              'vars' => array($challenge->guid, elgg_get_friendly_title($challenge->title))
                                  )
                          ),
                          'text' => elgg_echo('izap-contest:challenge:my_results')
                      ));
    ?>

                    </form>
                  </div>
                  <br/>
<?php } ?>
                    <div class="contentWrapper">
  <?php
                    IzapBase::increaseViews($challenge);
                    echo elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/tabs/index', array('entity' => $challenge));
  ?>
</div>