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

//c($_SESSION['zcontest']['quiz']);

$quiz_entity = izap_array_to_object(
        ($_SESSION['zcontest']['quiz']) ? $_SESSION['zcontest']['quiz']:
        ((isset($vars['quiz_entity'])) ? $vars['quiz_entity']->izap_get_attributes():
        array('access_id' => get_entity($vars['container_guid'])->access_id )) );

?>

<div class="contentWrapper">
  <?php if(!$vars['quiz_entity']) {?>
  <div id="elgg_horizontal_tabbed_nav">
    <ul>
      <li class="<?php echo ($vars['mtype']=='simple')?'selected':'' ?>"><a href="?type=simple">Simple</a></li>
      <li class="<?php echo ($vars['mtype']=='image')?'selected':'' ?>"><a href="?type=image">Image</a></li>
      <li class="<?php echo ($vars['mtype']=='audio')?'selected':'' ?>" ><a href="?type=audio">Audio</a></li>
      <?php if(is_plugin_enabled('izap_videos')): ?>
      <li class="<?php echo ($vars['mtype']=='video')?'selected':'' ?>"><a href="?type=video">Video</a></li>
      <?php endif; ?>
    </ul>
  </div>
  <?php }?>
  <form action="<?php echo $vars['url']; ?>action/quiz/save" method="post" enctype="multipart/form-data">
    <?php echo elgg_view('input/securitytoken');?>
    <p>
      <label>
        <?php echo elgg_echo('zcontest:quiz:title'); ?>
        <?php  echo elgg_view("input/text", array("internalname" => "quiz[title]", "value" => $quiz_entity->title))  ?>
      </label>
    </p>
    <?php include(dirname(__FILE__)."/".$vars['mtype']."media.php"); ?>

    <?php if(!$vars['quiz_entity']) {?>
    <div id="option-array">
      <p id="option1">
        <label>
            <?php echo elgg_echo('zcontest:quiz:option'); ?>
            <?php  echo elgg_view("input/text", array("internalname" => "quiz[opt:1]", "js" => "onblur=leave_corresponding_option(1) onfocus=focus_corresponding_option(1) onkeyup=correct_option_label(this.value,1)"))  ?>
        </label>
        <a id="addmore" href="#">Add more</a>
      </p>
    </div>

    <p>
      <label><?php echo elgg_echo('zcontest:quiz:correct'); ?></label><br />
      <span  id="correct-option-array">
        <label id="correct1">
          <input name="quiz[correct_option]" value="opt:1" class="input-radio" type="radio">
          <span class="izapRadio" id="rlabel1">option 1</span>
          <br />
        </label>
      </span>
    </p>
      <?php }else {
      $options = unserialize($quiz_entity->options);
      ?>
    <p>
      <label>
          <?php echo elgg_echo('zcontest:quiz:option'); ?><br />
      </label>
    </p>
      <?php
      foreach($options as $key => $val) {
        ?>
    <p>
      <input name="quiz[correct_option]" value="<?php echo $key?>" class="input-radio" type="radio" <?php echo ($quiz_entity->correct_option == $key) ? 'CHECKED' : '';?> />
          <?php  echo elgg_view("input/text", array("internalname" => "quiz[".$key."]", "value" => $val, 'class' => 'general-text'));?>
    </p>
        <?php
      }
    }
    ?>
    <p>
      <label>
        <?php echo elgg_echo('zcontest:quiz:description'); ?>
        <?php  echo elgg_view("input/longtext", array("internalname" => "quiz[description]", "value" => $quiz_entity->description))  ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo('zcontest:quiz:solution'); ?>
        <?php  echo elgg_view("input/longtext", array("internalname" => "quiz[solution]", "value" => $quiz_entity->solution))  ?>
      </label>
    </p>
    <p>
      <label>
        <?php echo elgg_echo("tags"); ?>
        <?php  echo elgg_view("input/tags", array( "internalname" => "quiz[tags]","value" => $quiz_entity->tags))  ?>
      </label>
    </p>

    <?php if($vars['quiz_entity']):?>
    <input type="hidden" name="quiz[guid]" value="<?php echo $quiz_entity->getGUID() ?>" />
    <?php endif;?>
    <input type="hidden" name="quiz[container_guid]" value="<?php echo $vars['container_guid'] ?>" />
    <input type="hidden" name="rurl" value="<?php echo get_input('rurl'); ?>" />
    <input type="hidden" name="quiz[qtype]" value="<?php echo ($vars['mtype'] == '') ? 'simple' : $vars['mtype'] ?>" />
    <p><input type="submit" name="submit" value="<?php echo elgg_echo('save') ?>" /></p>
  </form>
</div>
<script language="javascript" type="text/javascript">
  var counter=2;
  $('document').ready(function(){
    $("#addmore").click(function(){
      $("#option-array").append('<p id="option'+counter+'"><label><?php echo elgg_echo('zcontest:quiz:option')?><input onblur="leave_corresponding_option('+counter+')" onfocus="focus_corresponding_option('+counter+')" onkeyup="correct_option_label(this.value,'+counter+')" type="text" name="quiz[opt:'+counter+']" class="input-text"></label><a href="javascript:del_options(\''+counter+'\');">Delete</a></p>');
      $("#correct-option-array").append('<label id="correct'+counter+'"><input name="quiz[correct_option]" value="opt:'+counter+'" class="input-radio" type="radio"><span class="izapRadio" id="rlabel'+counter+'">option 1</span> <br /></label>');
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