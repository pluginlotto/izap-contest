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

$array = $vars['array'];
?>
<ol>
  <?php
  if (is_array($array) && sizeof($array)):
    foreach ($array as $quiz_guid => $stats):
      $class = ($stats['is_correct']) ? 'correct_answer' : 'wrong_answer';
      $status = ($stats['is_correct']) ? 'correct.png' : 'wrong.png';
      ?>
      <li>
        <p>
        <h3>
          <?php echo ($stats['question']); ?>
        </h3>
        <div class="contentWrapper">
          <?php echo ($stats['description']); ?><br />
          <img src="<?php echo $CONFIG->wwwroot . '/mod/' . GLOBAL_IZAP_CONTEST_PLUGIN . '/_graphics/' . $status ?>" />
          <b><?php echo elgg_echo('izap-contest:result:your_answer') . '</b>: ' . $stats['answer'] ?>
            <br />
            <b><?php echo elgg_echo('izap-contest:result:correct_answer') . '</b>: ' . $stats['correct_answer'] ?>
              <br />
              <em>
                <?php echo $stats['solution'] ?>
              </em>
              </div>
              </p>
              </li>
              <?php
            endforeach;
          endif;
          ?>
          </ol>