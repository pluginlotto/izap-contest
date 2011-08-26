<?php
/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * @version 1.0
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */
IzapBase::loadLib(array('plugin' => GLOBAL_IZAP_CONTEST_PLUGIN, 'lib' => 'izap-contest'));

$challenge_entity = izap_array_to_object(isset($vars['challenge_entity']) ? $vars['challenge_entity']: array('access_id' => defined('ACCESS_DEFAULT') ? ACCESS_DEFAULT : 1));

//izap_array_to_object(
//                ($_SESSION['zcontest']['challenge']) ? $_SESSION['zcontest']['challenge'] :
//                        ( isset($vars['challenge_entity']) ? $vars['challenge_entity']->izap_get_attributes() : array('access_id' => defined('ACCESS_DEFAULT') ? ACCESS_DEFAULT : 1) )
//);
?>

<div>
  <form action="<?php echo IzapBase::getFormAction('challenge_save', GLOBAL_IZAP_CONTEST_PLUGIN) ?>" method="post" enctype="multipart/form-data">
    <?php echo elgg_view('input/securitytoken'); ?>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:title'); ?>
        <?php echo elgg_view("input/text", array("internalname" => "attributes[_title]", "value" => $challenge_entity->title)) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:media'); ?>
        <?php echo elgg_view("input/file", array("internalname" => "related_media")) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:reqcorrect'); ?>
        <?php echo elgg_view("input/text", array("internalname" => "attributes[_required_correct]", "value" => $challenge_entity->required_correct)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:maxquizzes'); ?>
        <?php echo elgg_view("input/text", array("internalname" => "attributes[max_quizzes]", "value" => $challenge_entity->max_quizzes)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:challenge:timer'); ?>
        <?php echo elgg_view("input/text", array("internalname" => "attributes[timer]", "value" => $challenge_entity->timer)) ?>
      </label>
      <?php echo elgg_view('output/notice', array('izap_notice' => elgg_echo('izap-contest:challenge:timer:notice'))); ?>
      </p>

      <p>
        <label>
        <?php echo elgg_view("input/checkboxes", array("internalname" => "attributes[re_attempt]", "options" => array(elgg_echo('izap-contest:challenge:reattempt') => 1), "value" => $challenge_entity->re_attempt)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_view("input/checkboxes", array("internalname" => "attributes[negative_marking]", "options" => array(elgg_echo('izap-contest:challenge:negativemarking') => 1), "value" => $challenge_entity->negative_marking)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:description'); ?>
        <?php echo elgg_view("input/longtext", array("internalname" => "attributes[description]", "value" => $challenge_entity->description)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-contest:terms'); ?>
        <?php echo elgg_view("input/longtext", array("internalname" => "attributes[terms]", "value" => $challenge_entity->terms)) ?>
      </label>
    </p>

    <p>
      <label>
        <?php echo elgg_echo("tags"); ?>
        <?php echo elgg_view("input/tags", array("internalname" => "attributes[tags]", "value" => $challenge_entity->tags)) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:comments');?>
        <?php echo elgg_view('input/dropdown',array(
    'internalname' => 'attributes[comments_on]',
    'value' => $challenge_entity->comments_on,
    'options_values' => array('1' => elgg_echo('izap-contest:on'), '0' => elgg_echo('izap-contest:off'))
));?>
      </label>
    </p>
    <p>
      <label><?php echo elgg_echo('access'); ?></label>
      <?php echo elgg_view('input/access', array('internalname' => 'attributes[access_id]', 'value' => $challenge_entity->access_id)) ?>
      </p>
    <?php
        if ($vars['challenge_entity']):
          echo elgg_view('input/hidden', array('internalname' => 'attributes[guid]', 'value' => $challenge_entity->guid));
        else:
          echo elgg_view('input/hidden', array('internalname' => 'attributes[container_guid]', 'value' => page_owner_entity()->guid));

     endif; ?>
          <p>
            <?php echo elgg_view('input/submit' ,array('internalname' => 'submit','value' =>elgg_echo('save')));?>
    </p>
  </form>
</div>