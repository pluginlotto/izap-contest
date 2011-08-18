<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

class IzapChallengeController extends IzapController {

  public function __construct($page) {
    parent::__construct($page);
  }

  public function actionList() {
// check for page owner of the current page
    $page_owner = elgg_get_page_owner_entity();

    $listing_options = array();
    $listing_options['type'] = 'object';
    $listing_options['subtype'] = GLOBAL_IZAP_CONTEST_SUBTYPE_CHALLENGE;
    if ($page_owner == $_SESSION['user']) {
      $this->page_elements['title'] = elgg_view_title(elgg_echo('izap-contest:challenge:my'));
      $listing_options['container_guid'] = $page_owner->guid;
    } elseif ($page_owner) {
      $this->page_elements['title'] = elgg_view_title(sprintf(elgg_echo('izap-contest:user'), $page_owner->name));
      $listing_options['container_guid'] = $page_owner->guid;
    } else {
      set_input('username', get_loggedin_user()->username);
      $this->page_elements['title'] = elgg_view_title(elgg_echo('izap-contest:challenge:all'));
    }

    $this->page_elements['content'] = $list;
    $this->drawPage();


    $list = elgg_list_entities($listing_options);
  }

  public function actionAdd(){
    IzapBase::gatekeeper();
$this->page_elements['filter'] ='';
    $this->page_elements['title'] = elgg_view_title(elgg_echo('izap-contest:challenge:add'));
    $this->page_elements['content'] = elgg_view('forms/challenge/new_edit');
    $this->drawPage();
  }

  public function actionView(){
    c($this->url_vars);exit;
    $id = (int)get_input('guid');

if (!$challenge_entity = get_entity($id))
    forward();
set_context('quiz');
$title = $challenge_entity->title;

$this->page_elements['title'] = elgg_view_title(sprintf(elgg_echo('zcontest:challenge'), $challenge_entity->title));
$this->page_elements['content']= elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN.'/challenge/view',array('challenge_entity' => $challenge_entity));
$this->drawPage();
  }

}