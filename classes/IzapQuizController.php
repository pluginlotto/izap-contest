<?php

/* * *************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

class IzapQuizController extends IzapController {

  public function __construct($page) {
    parent::__construct($page);
  }

  public function actionNew() {
    IzapBase::gatekeeper();
    $container_challenge = get_entity($this->url_vars[1]);
    $type = get_input('type');
    elgg_set_page_owner_guid($container_challenge->container_guid);
    $this->page_elements['filter'] = '';
    $this->page_elements['page_title'] = $container_challenge->title . elgg_echo('izap-contest:quiz:add');
    $this->page_elements['title'] = elgg_echo('izap-contest:quiz:add');
    $this->page_elements['content'] = elgg_view('forms/quiz/new_edit', array('container_guid' => $this->url_vars[1], 'mtype' => $type));
    $this->drawPage();
  }

 /**
  * displays the Detail view of the quiz
  */
  public function actionView() {
    $id = $this->url_vars[3];

    if (!$quiz_entity = get_entity($id))
      forward(IzapBase::setHref(array('context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER, 'action' => 'view', 'vars' => array($this->url_vars[2], get_entity($this->url_vars[2])->title))));

    $challenge = get_entity($quiz_entity->container_guid);
    if (elgg_get_logged_in_user_guid() != $challenge->owner_guid && !$challenge->can_play()) {
      forward($challenge->getURL());
    }
    elgg_set_page_owner_guid($challenge->container_guid);

    $title = $quiz_entity->title;
    $this->page_elements['filter'] = '';
    $this->page_elements['title'] = '<a href="' . $challenge->getURL() . '">' . $challenge->title . '</a> ';
    $this->page_elements['page_title'] = $challenge->title;
    $this->page_elements['content'] = '<div class="quiz_answer">' . elgg_echo('izap-contest:quiz', array($quiz_entity->title)) . '</div>';
    $this->page_elements['content'] .= elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/quiz/view', array('entity' => $quiz_entity, 'container_guid' => (int) $this->url_vars[2]));
    $this->drawPage();
  }

  /**
   * displays the Edit quiz form
   */
  public function actionEdit() {

    IzapBase::gatekeeper();
    $quiz = get_entity($this->url_vars[3]);
    if (!$quiz->canEdit()) {
      forward(REFERER);
    }
    $container_challenge = get_entity($this->url_vars[2]);
    $type = get_input('type');
    elgg_set_page_owner_guid($container_challenge->container_guid);
    $this->page_elements['filter'] = '';
    $this->page_elements['title'] = '<a href="' . $container_challenge->getURL() . '">' . $container_challenge->title . '</a>' . elgg_echo('izap-contest:quiz:edit');
    $this->page_elements['page_title'] = $container_challenge->getURL() . $container_challenge->title . elgg_echo('izap-contest:quiz:edit');
    $this->page_elements['content'] = elgg_view('forms/quiz/new_edit', array('container_guid' => $this->url_vars[2], 'mtype' => $type, 'quiz_entity' => $quiz));
    $this->drawPage();
  }

}