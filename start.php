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
define('GLOBAL_IZAP_CONTEST_PLUGIN', 'izap-contest');
define('GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE', 'challenge');
define('GLOBAL_IZAP_CONTEST_PAGEHANDLER_QUIZ', 'quiz');
define('GLOBAL_IZAP_CONTEST_SUBTYPE_CHALLENGE', 'izapchallenge');
define('GLOBAL_IZAP_CONTEST_SUBTYPE_QUIZ', 'izapquiz');

function izap_zcontest_init() {
  global $CONFIG;
  if(is_plugin_enabled('izap-elgg-bridge')) {
    func_init_plugin_byizap(array('plugin'=>array('name' => GLOBAL_IZAP_CONTEST_PLUGIN)));
  }else {
    register_error('This plugin needs izap-elgg-bridge');
    disable_plugin(GLOBAL_IZAP_CONTEST_PLUGIN);
  }

  // asking group to include the izap_files
  if(is_callable('add_group_tool_option')) {
    add_group_tool_option(GLOBAL_IZAP_CONTEST_SUBTYPE_CHALLENGE, elgg_echo('zcontest:challenge:group:enable'), true);
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
      if(!izap_load_file($izap_file_path . $action . '.php', array(
      'plugin' => GLOBAL_IZAP_CONTEST_PLUGIN
      ))) {
        izap_load_file(dirname(__FILE__).'/pages/preactions/list.php', array(
                'plugin' => GLOBAL_IZAP_CONTEST_PLUGIN
        ));
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
  return $CONFIG->url . "pg/challenge/view/".$entity->container_username."/" . $entity->guid . "/" . $title . $extra;
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

function group_menus_izap_contest() {
  global $CONFIG;
  $pageowner = page_owner_entity();
  // if the page owner is group and context is group
  if($pageowner instanceof ElggGroup && (get_context() == 'groups' || get_context() == GLOBAL_IZAP_CONTEST_PAGEHANDLER_QUIZ || get_context() == GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE) && ($pageowner->izapchallenge_enable == 'yes' || empty($pageowner->izapchallenge_enable))) {
    if(can_write_to_container(get_loggedin_userid(), $pageowner->guid)) {
      add_submenu_item(
              elgg_echo('zcontest:challenge:group:add'),
              $CONFIG->wwwroot . 'pg/'.GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE.'/new/'.$pageowner->guid.'/'.$pageowner->username . '/',
              GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE);
    }
    add_submenu_item(
            elgg_echo('zcontest:challenge:group:list'),
            $CONFIG->wwwroot . 'pg/'.GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE.'/list/'.$pageowner->guid.'/'.$pageowner->username . '/',
            GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE);
  }
}

register_elgg_event_handler('init', 'system', 'izap_zcontest_init');
register_elgg_event_handler('pagesetup', 'system', 'group_menus_izap_contest');