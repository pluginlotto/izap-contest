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


function izap_zcontest_init() {
  global $CONFIG;
  if(is_plugin_enabled('izap-elgg-bridge')) {
    func_init_plugin_byizap(array('plugin'=>array('name'=>'izap-contest')));
  }else{
    register_error('This plugin needs izap-elgg-bridge');
    disable_plugin('izap-contest');
  }
}

function izap_zcontest_page_handler($tmp_page) {

  // removing the blank elements
  foreach($tmp_page as $key => $value) {
    if($value && $value != '') {
      $page[$key] = $value;
    }
  }

  izap_process_uncompleted_challenge($page[0]);
  $action = empty($page[0])?null:$page[0];
  if(isset($page[1]) && isset($page[2]) && is_numeric($page[1]) && is_numeric($page[2]) ) {
    set_input('container_guid',$page[1]);
    set_input('guid',$page[2]);
  }elseif(isset($page[1]) && isset($page[2]) && is_numeric($page[1]) && is_string($page[2]) ) {
    set_input('container_guid',$page[1]);
    set_input('username', $page[2]);
  }elseif(isset($page[1]) && isset($page[2]) && is_numeric($page[2]) && is_string($page[1]) ) {
    set_input('guid',$page[2]);
    set_input('username', $page[1]);
  }elseif(isset($page[1]) && !isset($page[2]) && is_numeric($page[1])) {
    set_input('guid',$page[1]);
  }elseif(isset($page[1]) && !isset($page[2]) && is_string($page[1])) {
    set_input('username',$page[1]);
  }
  switch($action) {
    default:
      if(get_context() == 'challenge') {
        $izap_file_path = dirname(__FILE__).'/pages/preactions/challenge/';
      }elseif(get_context() == 'quiz') {
        $izap_file_path = dirname(__FILE__).'/pages/preactions/quiz/';
      }else {
        $izap_file_path = dirname(__FILE__).'/pages/preactions/';
      }
      if(!include($izap_file_path . $action . '.php')) {
        include(dirname(__FILE__).'/pages/preactions/list.php');
      }
      return true;
      break;
  }
  return false;
}

function izap_zcontest_challenge_url($entity) {
  global $CONFIG;
  $title = friendly_title($entity->title);
  $current_url =  current_page_url();
  if(!strpos($current_url, 'action') && !strpos($current_url, 'pg/challenge') && !strpos($current_url, 'pg/quiz') && $entity->owner_guid == get_loggedin_userid()) {
    $extra = '?view_as_challenger=yes';
  }
  return $CONFIG->url . "pg/challenge/view/".get_entity($entity->owner_guid)->username."/" . $entity->guid . "/" . $title . $extra;
}


function izap_zcontest_quiz_url($entity) {
  global $CONFIG;
  $title = friendly_title($entity->title);
  return $CONFIG->url . "pg/quiz/view/".$entity->container_guid."/" . $entity->guid . "/" . $title;
}

function izap_challenge_results_url($entity) {
  global $CONFIG;
  return $CONFIG->wwwroot . 'pg/challenge/result/' . $entity->container_guid . '/' . $entity->guid . '/' . friendly_title($entity->title);
}
function izap_quiz_edit_grant($hook, $entity_type, $returnvalue, $params) {
  return true;
}

function izap_challenge_icon_url($hook, $entity_type, $returnvalue, $params) {
  global $CONFIG;
  if(!empty($params['entity']->related_media))
    return $CONFIG->wwwroot.'mod/izap-contest/content.php?id='.$params['entity']->guid.'&size='.$params['size'];
  else
    return $CONFIG->wwwroot.'mod/izap-contest/graphics/defaultlarge.gif';
}

register_elgg_event_handler('init', 'system', 'izap_zcontest_init');