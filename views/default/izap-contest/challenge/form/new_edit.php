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

$action = 'challenge/save';
//c($_SESSION['zcontest']['challenge']);
//c($vars['challenge_entity']);

$challenge_entity = izap_array_to_object(
                        ($_SESSION['zcontest']['challenge'])?$_SESSION['zcontest']['challenge']:
                        ( isset($vars['challenge_entity'])?$vars['challenge_entity']->izap_get_attributes():array('access_id' => defined('ACCESS_DEFAULT')?ACCESS_DEFAULT:1) )
                    );
?>

<div class="contentWrapper">
  <form action="<?php echo $vars['url']; ?>action/<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <?php echo elgg_view('input/securitytoken');?>
    <p>
       <label>
        <?php echo elgg_echo('zcontest:title'); ?>
        <?php  echo elgg_view("input/text", array("internalname" => "challenge[title]", "value" => $challenge_entity->title))  ?>
      </label>
    </p>
    <p>
       <label>
        <?php echo elgg_echo('zcontest:challenge:media'); ?>
        <?php  echo elgg_view("input/file", array("internalname" => "related_media"))  ?>
      </label>
    </p>
    <p>
       <label>
        <?php echo elgg_echo('zcontest:challenge:reqcorrect'); ?>
        <?php  echo elgg_view("input/text", array("internalname" => "challenge[required_correct]", "value" => $challenge_entity->required_correct))  ?>
      </label>
    </p>

    <p>
       <label>
        <?php echo elgg_echo('zcontest:challenge:maxquizzes'); ?>
        <?php  echo elgg_view("input/text", array("internalname" => "challenge[max_quizzes]", "value" => $challenge_entity->max_quizzes))  ?>
      </label>
    </p>

    <p>
       <label>
        <?php echo elgg_echo('zcontest:challenge:timer'); ?>
        <?php  echo elgg_view("input/text", array("internalname" => "challenge[timer]", "value" => $challenge_entity->timer))  ?>
      </label>
       <?php echo elgg_view('output/notice', array('izap_notice' => elgg_echo('zcontest:challenge:timer:notice'))); ?>
    </p>

     <p>
       <label>
        <?php  echo elgg_view("input/checkboxes", array("internalname" => "challenge[re_attempt]", "options" => array(elgg_echo('zcontest:challenge:reattempt') => 1),  "value" => $challenge_entity->re_attempt))  ?>
      </label>
    </p>

    <p>
       <label>
        <?php  echo elgg_view("input/checkboxes", array("internalname" => "challenge[negative_marking]", "options" => array(elgg_echo('zcontest:challenge:negativemarking') => 1),  "value" => $challenge_entity->negative_marking))  ?>
      </label>
    </p>

    <p>
       <label>
        <?php echo elgg_echo('zcontest:description'); ?>
        <?php  echo elgg_view("input/longtext", array("internalname" => "challenge[description]", "value" => $challenge_entity->description))  ?>
      </label>
    </p>

    <p>
       <label>
        <?php echo elgg_echo('zcontest:terms'); ?>
        <?php  echo elgg_view("input/longtext", array("internalname" => "challenge[terms]", "value" => $challenge_entity->terms))  ?>
      </label>
    </p>
    
    <p>
      <label>
        <?php echo elgg_echo("tags"); ?>
        <?php  echo elgg_view("input/tags", array( "internalname" => "challenge[tags]","value" => $challenge_entity->tags))  ?>
      </label>
    </p>

    <p>
      <label><?php echo elgg_echo('access'); ?></label>
      <?php echo elgg_view('input/access', array('internalname' => 'challenge[access_id]','value' => $challenge_entity->access_id)) ?>
    </p>
    <?php if($vars['challenge_entity']):  ?>
      <input type="hidden" name="challenge[guid]" value="<?php echo $challenge_entity->guid ?>">
    <?php else:
      ?>
      <input type="hidden" name="challenge[container_guid]" value="<?php echo page_owner_entity()->guid ?>">
        <?php
      endif; ?>
    <p><input type="submit" name="submit" value="<?php echo elgg_echo('save') ?>" /></p>
  </form>
</div>