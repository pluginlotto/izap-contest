<?php
/***************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 ***************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */


IzapBase::loadLib(array('plugin' => GLOBAL_IZAP_CONTEST_PLUGIN, 'lib' => 'izap-contest'));
$quiz_entity = izap_array_to_object(isset($vars['quiz_entity']) ? $vars['quiz_entity'] : array('access_id' => defined('ACCESS_DEFAULT') ? ACCESS_DEFAULT : 1));
?>

<div class="contentWrapper">
  <?php if (!$vars['quiz_entity']) {
  ?>
    <div id="elgg_horizontal_tabbed_nav">
      <ul class="elgg-tabs elgg-htabs">
        <li class="<?php echo ($vars['mtype'] == 'simple') ? 'elgg-state-selected' : '' ?>"><a href="?type=simple">Simple</a></li>
        <li class="<?php echo ($vars['mtype'] == 'image') ? 'elgg-state-selected' : '' ?>"><a href="?type=image">Image</a></li>
        <li class="<?php echo ($vars['mtype'] == 'audio') ? 'elgg-state-selected' : '' ?>" ><a href="?type=audio">Audio</a></li>
      <?php if (elgg_is_active_plugin(GLOBAL_IZAP_VIDEOS_PLUGIN)): ?>
        <li class="<?php echo ($vars['mtype'] == 'video') ? 'elgg-state-selected' : '' ?>"><a href="?type=video">Video</a></li>
      <?php endif; ?>
      </ul>
    </div>
  <?php }
  ?>
      <form action="<?php echo IzapBase::getFormAction('quiz_save', GLOBAL_IZAP_CONTEST_PLUGIN) ?>" method="post" enctype="multipart/form-data">
    <?php echo elgg_view('input/securitytoken'); ?>
      <p>
        <label>
        <?php echo elgg_echo('izap-contest:quiz:title'); ?>
        <?php echo elgg_view("input/text", array("name" => "attributes[_title]", "value" => $quiz_entity->title)) ?>
      </label>
    </p>
    <?php include(dirname(__FILE__) . "/" . $vars['mtype'] . "media.php"); ?>

    <?php if (!$vars['quiz_entity']) {
 ?>
          <div id="option-array">
            <p id="option1">
              <label>
          <?php echo elgg_echo('izap-contest:quiz:option'); ?>
<?php echo elgg_view("input/text", array("name" => "attributes[_opt:1]", "js" => "onblur=leave_corresponding_option(1) onfocus=focus_corresponding_option(1) onkeyup=correct_option_label(this.value,1)")) ?>
        </label>
        <a id="addmore" href="#">Add more</a>
      </p>
    </div>

    <p>
      <label><?php echo elgg_echo('izap-contest:quiz:correct'); ?></label><br />
      <span  id="correct-option-array">
        <label id="correct1">
          <input name="attributes[_correct_option]" value="opt:1" class="input-radio" type="radio">
          <span class="izapRadio" id="rlabel1">option 1</span>
          <br />
        </label>
      </span>
    </p>
    <?php
        } else {
          $options = unserialize($quiz_entity->options);
    ?>
          <p>
            <label>
<?php echo elgg_echo('izap-contest:quiz:option'); ?><br />
        </label>
      </p>
    <?php
          foreach ($options as $key => $val) {
    ?>
            <p>
              <input name="attributes[_correct_option]" value="<?php echo $key ?>" class="input-radio" type="radio" <?php echo ($quiz_entity->correct_option == $key) ? 'CHECKED' : ''; ?> />
<?php echo elgg_view("input/text", array("name" => "attributes[" . $key . "]", "value" => $val, 'class' => 'general-text')); ?>
          </p>
    <?php
          }
        }
    ?>
        <p>
          <label>
        <?php echo elgg_echo('izap-contest:quiz:description');
        echo elgg_view("input/longtext", array("name" => "attributes[description]", "value" => $quiz_entity->description)) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('izap-contest:quiz:solution');
        echo elgg_view("input/longtext", array("name" => "attributes[solution]", "value" => $quiz_entity->solution)) ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo("tags");
        echo elgg_view("input/tags", array("name" => "attributes[tags]", "value" => $quiz_entity->tags)) ?>
      </label>
    </p>


    <?php
        if ($vars['quiz_entity']):
          echo elgg_view('input/hidden', array('name' => "attributes[guid]", "value" => $quiz_entity->getGUID()));
        endif;
        ;
        echo elgg_view('input/hidden', array('name' => "attributes[container_guid]", "value" => $vars['container_guid']));
        echo elgg_view('input/hidden', array('name' => "attributes[qtype]", "value" => ($vars['mtype'] == '') ? 'simple' : $vars['mtype']));
        echo elgg_view('input/hidden', array('name' => 'attributes[plugin]', 'value' => GLOBAL_IZAP_CONTEST_PLUGIN));
        echo izapbase::input('submit', array('name' => "Submit", "value" => elgg_echo('save')));
    ?>
      </form>
    </div>
    <script language="javascript" type="text/javascript">
      var counter=2;
      $('document').ready(function(){
        $("#addmore").click(function(){
          $("#option-array").append('<p id="option'+counter+'"><label><?php echo elgg_echo('izap-contest:quiz:option') ?><input onblur="leave_corresponding_option('+counter+')" onfocus="focus_corresponding_option('+counter+')" onkeyup="correct_option_label(this.value,'+counter+')" type="text" name="attributes[opt:'+counter+']" class="input-text"></label><a href="javascript:del_options(\''+counter+'\');">Delete</a></p>');
      $("#correct-option-array").append('<label id="correct'+counter+'"><input name="attributes[_correct_option]" value="opt:'+counter+'" class="input-radio" type="radio"><span class="izapRadio" id="rlabel'+counter+'">option 1</span> <br /></label>');
      counter++;
      return false;
    });
  });
  function del_options(id){
    $("#option"+id).remove();
    $("#correct"+id).remove();
  }
  function correct_option_label(str,ctr){
    $("#rlabel"+ctr).text(str).html();
  }

  function focus_corresponding_option(ctr){
    $("#rlabel"+ctr).css('background',"#BFFBB1");
  }
  function leave_corresponding_option(ctr){
    $("#rlabel"+ctr).css('background',"#FFFFFF");
  }
</script>