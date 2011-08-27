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
define('GLOBAL_IZAP_CONTEST_PLUGIN', 'izap-contest');
define('GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER', 'challenge');
define('GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER', 'quiz');
define('GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE', 'izapchallenge');
define('GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE', 'izapquiz');
define('GLOBAL_IZAP_CONTEST_CHALLENGE_CLASS', 'IzapChallenge');

elgg_register_event_handler('init', 'system', 'izap_zcontest_init');

function izap_zcontest_init() {
  global $CONFIG;
  if (elgg_is_active_plugin(GLOBAL_IZAP_ELGG_BRIDGE)) {
    izap_plugin_init(GLOBAL_IZAP_CONTEST_PLUGIN);
  } else {
    register_error('This plugin needs izap-elgg-bridge');
    disable_plugin(GLOBAL_IZAP_CONTEST_PLUGIN);
  }

  // asking group to include the izap_files
  if (is_callable('add_group_tool_option')) {
    add_group_tool_option(GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE, elgg_echo('izap-contest:challenge:group:enable'), true);
  }
  elgg_register_page_handler(GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER, GLOBAL_IZAP_PAGEHANDLER);
  elgg_register_page_handler(GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER, GLOBAL_IZAP_PAGEHANDLER);
  elgg_register_action(GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER, GLOBAL_IZAP_PAGEHANDLER);
  elgg_register_menu_item('site', new ElggMenuItem('izap-contest', elgg_echo('izap-contest:contests'), IzapBase::setHref(array(
                      'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                      'action' => 'list',
                      'vars' => array('all'),
                      'page_owner' => false
                  ))));

  if (elgg_get_context () == GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER) {

    $menu_item_add = new ElggMenuItem('izap-contest:challenge_add', elgg_echo('izap-contest:challenge:add'), IzapBase::setHref(array(
                        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                        'action' => 'add'
                    )));
    elgg_register_menu_item('page', $menu_item_add);

    $menu_item_list = new ElggMenuItem('izap-contest:challenge_list', elgg_echo('izap-contest:challenge:all'), IzapBase::setHref(array(
                        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                        'action' => 'list',
                        'page_owner' => false,
                        'vars' => array('all')
                    )));
    elgg_register_menu_item('page', $menu_item_list);

    $menu_item_my_list = new ElggMenuItem('izap-contest:challenge_my_list', sprintf(elgg_echo("izap-contest:chellenge:list"), "My"), IzapBase::setHref(array(
                        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                        'action' => 'list',
                        'page_owner' => false,
                        'vars' => array($_SESSION['user']->username)
                    )));
    elgg_register_menu_item('page', $menu_item_my_list);

    $menu_item_my_accepted = new ElggMenuItem('izap-contest:challenge_my_myaccepted', elgg_echo('izap-contest:challenge:accepted'), IzapBase::setHref(array(
                        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                        'action' => 'accepted',
                    )));
    elgg_register_menu_item('page', $menu_item_my_accepted);
  }
}

//function izap_zcontest_page_handler($tmp_page) {
//
//  // removing the blank elements
//  foreach($tmp_page as $key => $value) {
//    if($value && $value != '') {
//      $page[$key] = $value;
//    }
//  }
//
//  izap_process_uncompleted_challenge($page[0]);
//  $action = empty($page[0])?null:$page[0];
//  set_input('username', get_loggedin_user()->username);
//  if(isset($page[1]) && isset($page[2]) && is_numeric($page[1]) && is_numeric($page[2]) ) {
//    set_input('container_guid',$page[1]);
//    set_input('guid',$page[2]);
//  }elseif(isset($page[1]) && isset($page[2]) && is_numeric($page[1]) && is_string($page[2]) ) {
//    set_input('container_guid',$page[1]);
//    set_input('username', $page[2]);
//  }elseif(isset($page[1]) && isset($page[2]) && is_numeric($page[2]) && is_string($page[1]) ) {
//    set_input('guid',$page[2]);
//    set_input('username', $page[1]);
//  }elseif(isset($page[1]) && !isset($page[2]) && is_numeric($page[1])) {
//    set_input('guid',$page[1]);
//  }elseif(isset($page[1]) && !isset($page[2]) && is_string($page[1])) {
//    set_input('username',$page[1]);
//  }
//  switch($action) {
//    default:
//      if(get_context() == 'challenge') {
//        $izap_file_path = dirname(__FILE__).'/pages/preactions/challenge/';
//      }elseif(get_context() == 'quiz') {
//        $izap_file_path = dirname(__FILE__).'/pages/preactions/quiz/';
//      }else {
//        $izap_file_path = dirname(__FILE__).'/pages/preactions/';
//      }
//      if(!izap_load_file($izap_file_path . $action . '.php', array(
//      'plugin' => GLOBAL_IZAP_CONTEST_PLUGIN
//      ))) {
//        izap_load_file(dirname(__FILE__).'/pages/preactions/list.php', array(
//                'plugin' => GLOBAL_IZAP_CONTEST_PLUGIN
//        ));
//      }
//      return true;
//      break;
//  }
//  return false;
//}
//
//function izap_zcontest_challenge_url($entity) {
//  global $CONFIG;
//  $title = friendly_title($entity->title);
//
//  $container_name = $entity->container_username;
//  if($container_name == '') {
//    $container_entity = get_entity($entity->container_guid);
//    $container_name = $container_entity->username;
//  }
//  return $CONFIG->url . "pg/challenge/view/".$container_name."/" . $entity->guid . "/" . $title . $extra;
//}
//
//
//function izap_zcontest_quiz_url($entity) {
//  global $CONFIG;
//  $title = friendly_title($entity->title);
//  return $CONFIG->url . "pg/quiz/view/".$entity->container_guid."/" . $entity->guid . "/" . $title;
//}
//
//function izap_challenge_results_url($entity) {
//  global $CONFIG;
//  return $CONFIG->wwwroot . 'pg/challenge/result/' . $entity->container_guid . '/' . $entity->guid . '/' . friendly_title($entity->title);
//}
//function izap_quiz_edit_grant($hook, $entity_type, $returnvalue, $params) {
//  return true;
//}
//
//function izap_challenge_icon_url($hook, $entity_type, $returnvalue, $params) {
//  global $CONFIG;
//  if(!empty($params['entity']->related_media))
//    return $CONFIG->wwwroot.'mod/izap-contest/content.php?id='.$params['entity']->guid.'&size='.$params['size'];
//  else
//    return $CONFIG->wwwroot.'mod/izap-contest/graphics/defaultlarge.gif';
//}
//
function group_menus_izap_contest() {
  global $CONFIG;
  $pageowner = elgg_get_page_owner_entity();
  // if the page owner is group and context is group
  if ($pageowner instanceof ElggGroup && (get_context() == 'groups' || get_context() == GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER || get_context() == GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER) && ($pageowner->izapchallenge_enable == 'yes' || empty($pageowner->izapchallenge_enable))) {
    if (can_write_to_container(elgg_get_logged_in_user_guid(), $pageowner->guid)) {

      elgg_register_menu_item('page', new ElggMenuItem('izap-contest:challenge:group:add', elgg_echo('izap-contest:challenge:group:add'),
                      izapbase::setHref(array(
                          'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                          'action' => 'add',
                          'page_owner' => false,
                          'vars' => array($pageowner->guid, $pageowner->username
                          )
                              )
                      )
              )
      )
      ;
    }
    elgg_register_menu_item('page', new ElggMenuItem('izap-contest:challenge:group:list', elgg_echo('izap-contest:challenge:group:list'),
                    IzapBase::setHref(array(
                        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                        'action' => 'list',
                        'page_owner' => false,
                        'vars' => array($pageowner->guid, $pageowner->username)
                            )
                    )
            )
    );
//    add_submenu_item(
//            elgg_echo('izap-contest:challenge:group:list'),
//            $CONFIG->wwwroot . 'pg/' . GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER . '/list/' . $pageowner->guid . '/' . $pageowner->username . '/',
//            GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER);
  }
}

register_elgg_event_handler('pagesetup', 'system', 'group_menus_izap_contest');


