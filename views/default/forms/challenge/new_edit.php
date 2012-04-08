<?php
/* * ***********************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * *************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// this is the form for adding/editing a new challenge
IzapBase::loadLib(array('plugin' => GLOBAL_IZAP_CONTEST_PLUGIN, 'lib' => 'izap-contest'));

$challenge_entity = izap_array_to_object(isset($vars['challenge_entity']) ? $vars['challenge_entity'] : array('access_id' => defined('ACCESS_DEFAULT') ? ACCESS_DEFAULT : 1));
?>

<div>
  <form action="<?php echo IzapBase::getFormAction('challenge_save', GLOBAL_IZAP_CONTEST_PLUGIN) ?>" method="post" enctype="multipart/form-data">
    <?php echo elgg_view('input/securitytoken'); ?>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:title'); ?>
        <?php echo elgg_view("input/text", array("name" => "attributes[_title]", "value" => $challenge_entity->title)) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:media'); ?>
        <?php echo elgg_view("input/file", array("name" => "related_media")) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:reqcorrect'); ?>
        <?php echo elgg_view("input/text", array("name" => "attributes[_required_correct]", "value" => $challenge_entity->required_correct)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:maxquizzes'); ?>
        <?php echo elgg_view("input/text", array("name" => "attributes[max_quizzes]", "value" => $challenge_entity->max_quizzes)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:timer'); ?>
        <?php echo elgg_view("input/text", array("name" => "attributes[timer]", "value" => $challenge_entity->timer)) ?>
      </label>
      <?php echo elgg_view('output/notice', array('izap_notice' => elgg_echo('izap-contest:challenge:timer:notice'))); ?>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:reattempt'); ?>
        <?php echo elgg_view("input/text", array("name" => "attributes[re_attempt]", "value" => $challenge_entity->re_attempt)) //, "options" => array(elgg_echo('izap-contest:challenge:reattempt') => 1)?>
      </label>
      <?php echo elgg_view('output/notice', array('izap_notice' => elgg_echo('izap-contest:leave_empty'))); ?>
    </p>

    <p>
      <label>
        <?php echo elgg_view("input/checkboxes", array("name" => "attributes[negative_marking]", "options" => array(elgg_echo('izap-contest:challenge:negativemarking') => 1), "value" => $challenge_entity->negative_marking)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:description'); ?>
        <?php echo elgg_view("input/longtext", array("name" => "attributes[description]", "value" => $challenge_entity->description)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:terms'); ?>
        <?php echo elgg_view("input/longtext", array("name" => "attributes[terms]", "value" => $challenge_entity->terms)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo("tags"); ?>
        <?php echo elgg_view("input/tags", array("name" => "attributes[tags]", "value" => $challenge_entity->tags)) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:comments'); ?>
        <?php
        echo elgg_view('input/dropdown', array(
            'name' => 'attributes[comments_on]',
            'value' => $challenge_entity->comments_on,
            'options_values' => array('1' => elgg_echo('izap-contest:on'), '0' => elgg_echo('izap-contest:off'))
        ));
        ?>
      </label>
    </p>
    <p>
      <label><?php echo elgg_echo('access'); ?></label>
      <?php echo elgg_view('input/access', array('name' => 'attributes[access_id]', 'value' => $challenge_entity->access_id)) ?>
    </p>
    <?php
    if ($vars['challenge_entity']):
      echo elgg_view('input/hidden', array('name' => 'attributes[guid]', 'value' => $challenge_entity->guid));
    else:
      echo elgg_view('input/hidden', array('name' => 'attributes[container_guid]', 'value' => elgg_get_page_owner_guid()));
    endif;
    echo elgg_view('input/hidden', array('name' => 'attributes[plugin]', 'value' => GLOBAL_IZAP_CONTEST_PLUGIN));
    ?>
    <p>
      <?php echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('save'))); ?>
    </p>
  </form>
</div>