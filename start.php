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
     elgg_extend_view('groups/tool_latest', GLOBAL_IZAP_CONTEST_PLUGIN . '/group_module');
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
                        'action' => 'add',
                    )));
    elgg_register_menu_item('page', $menu_item_add);

    $menu_item_list = new ElggMenuItem('izap-contest:challenge_list', elgg_echo('izap-contest:challenge:all'), IzapBase::setHref(array(
                        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                        'action' => 'list',
                        'page_owner' => false,
                        'vars' => array('all')
                    )));
    elgg_register_menu_item('page', $menu_item_list);

    $menu_item_my_list = new ElggMenuItem('izap-contest:challenge_my_list', elgg_echo("izap-contest:chellenge:list", array("My")), IzapBase::setHref(array(
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
                          'vars' => array($pageowner->username
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

  }
}

register_elgg_event_handler('pagesetup', 'system', 'group_menus_izap_contest');


