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

class IzapQuizController extends IzapController {

  public function __construct($page) {
    parent::__construct($page);
  }

  public function actionNew() {

    $container_challenge = get_entity($this->url_vars[1]);
    $type = get_input('type');
    elgg_set_page_owner_guid($container_challenge->container_guid);
    $this->page_elements['filter'] ='';
    $this->page_elements['title'] = elgg_view_title('<a href="' . $container_challenge->getURL() . '">' . $container_challenge->title . '</a> :' . elgg_echo('izap-contest:quiz:add'));
    $this->page_elements['content'] = elgg_view('forms/quiz/new_edit',array('container_guid' => $this->url_vars[1], 'mtype' => $type));
    $this->drawPage();
  }


  public function actionView(){
    $id = $this->url_vars[3];

if (!$quiz_entity = get_entity($id))
    forward();

$challenge = get_entity($quiz_entity->container_guid);
if(elgg_get_logged_in_user_guid() != $challenge->owner_guid && !$challenge->can_play()) {
  forward($challenge->getURL());
}
elgg_set_page_owner_guid($challenge->container_guid);

$title = $quiz_entity->title;
$this->page_elements['filter'] ='';
$this->page_elements['title'] = elgg_view_title('<a href="'.$challenge->getURL().'">' . $challenge->title . '</a> :' . sprintf(elgg_echo('izap-contest:quiz'), $quiz_entity->title));
$this->page_elements['content'] = elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN.'/quiz/view',array('entity' => $quiz_entity,'container_guid' => (int)$this->url_vars[2]));
$this->drawPage();
  }

  public function actionEdit(){

    
  }
}