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

class IzapChallengeController extends IzapController {

  public function __construct($page) {
    parent::__construct($page);
  }

  public function actionList() {
// check for page owner of the current page
    $page_owner = elgg_get_page_owner_entity();

    $listing_options = array();
    $listing_options['type'] = 'object';
    $listing_options['subtype'] = GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE;
    if ($page_owner == $_SESSION['user']) {
      $this->page_elements['title'] = elgg_echo('izap-contest:challenge:my');
      $listing_options['container_guid'] = $page_owner->guid;
    } elseif ($page_owner) {
      $this->page_elements['title'] = elgg_echo('izap-contest:user', array($page_owner->name));
      $listing_options['container_guid'] = $page_owner->guid;
    } else {
      //set_input('username', elgg_get_logged_in_user_entity()->username);
      $this->page_elements['title'] = elgg_echo('izap-contest:challenge:all');
    }
    $list = elgg_list_entities($listing_options);
    $this->page_elements['content'] = $list;
    $this->drawPage();
  }

  public function actionAdd() {
    IzapBase::gatekeeper();
    $this->page_elements['filter'] = '';
    $this->page_elements['title'] = elgg_view('page/elements/title',array('title'=>elgg_echo('izap-contest:challenge:add')));
    $this->page_elements['content'] = elgg_view('forms/challenge/new_edit');
    $this->drawPage();
  }

  public function actionEdit() {
    IzapBase::gatekeeper();
    $challenge_entity = get_entity($this->url_vars[2]);
    if (!$challenge_entity->canEdit()) {
      forward(REFERER);
    }
    $this->page_elements['filter'] = '';
    $this->page_elements['title'] = elgg_view('page/elements/title',array('title'=>elgg_echo('izap-contest:challenge:edit')));
    $this->page_elements['content'] = elgg_view('forms/challenge/new_edit', array('challenge_entity' => $challenge_entity));
    $this->drawPage();
  }

  public function actionAccepted() {
    $page_owner = elgg_get_page_owner_entity();

    $this->page_elements['title'] = elgg_view('page/elements/title',array('title'=>$page_owner->name . '\'s ' . elgg_echo('izap-contest:challenge:accepted')));
    $list = elgg_list_entities_from_metadata(array(
                'type' => 'object',
                'subtype' => GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE,
                'metadata_name' => 'accepted_by',
                'metadata_value' => $page_owner->guid
                    )
    );

    if (empty($list) || $list == '') {
      $this->page_elements['content'] = '<div class="contentWrapper">' . elgg_echo('izap-contest:notfound') . '</div>';
    } else {
      $this->page_elements['content'] = $list;
    }
    $this->drawpage();
  }

  public function actionView() {

    $id = (int) $this->url_vars[2];
    $challenge_entity = get_entity($id);
    if (!elgg_instanceof($challenge_entity, 'object', GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE, GLOBAL_IZAP_CONTEST_CHALLENGE_CLASS))
     forward(IzapBase::setHref(array('context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,'action' => 'list','page_owner' => false,'vars' =>array('all'))));
    $control_menu = IzapBase::controlEntityMenu(array('entity' => $challenge_entity, 'handler' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER));
    $title = $challenge_entity->title;
    $this->page_elements['filter'] = '';
    $this->page_elements['title'] = elgg_view('page/elements/title', array('title' => elgg_echo('izap-contest:challenge', array($title)))) . $control_menu;
    if (!get_input('view_as_challenger', FALSE) && $challenge_entity->owner_guid == elgg_get_logged_in_user_guid()) {

      if (!$challenge_entity->lock) {
        $quiz_add = new ElggMenuItem('izap-contest:quiz:add',
                        elgg_echo('izap-contest:quiz:add'),
                        IzapBase::setHref(array(
                            'context' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
                            'action' => 'new',
                            'page_owner' => false,
                            'vars' => array($challenge_entity->guid, $_SESSION['user']->username)
                                )
                        ) . "?type=simple"
        );
        elgg_register_menu_item('page', $quiz_add);
      }

      $challenger_view = new ElggMenuItem('izap-contest:challenge:view_as_challenger', elgg_echo('izap-contest:challenge:view_as_challenger'), IzapBase::setHref(array(
                          'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                          'action' => 'view',
                          'vars' => array($this->url_vars[2], 'full' => true)
                      )) . "?view_as_challenger=yes");

      elgg_register_menu_item('page', $challenger_view);

      $this->page_elements['content'] = elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/owner_view', array('challenge_entity' => $challenge_entity));
    } else {
      $this->page_elements['content'] = elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/challenger_view', array('challenge_entity' => $challenge_entity, 'full_view' => $this->url_vars[3]));
    }

    $this->drawPage();
  }

  public function actionResult() {
    $contest = $this->url_vars[1];

    if ((int) ($this->url_vars[2])) {
      $result = get_entity($this->url_vars[2]);
      $this->page_elements['content'] = elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/result', array('result' => $result));
    } else {
      $options = array(
          'type' => 'object',
          'subtype' => 'izap_challenge_results',
          'owner_guid' => elgg_get_logged_in_user_guid(),
          'container_guid' => $contest->guid,
          'limit' => 20,
      );

      $this->page_elements['title'] = elgg_view('page/elements/title',array('title'=>elgg_echo('izap-contest:challenge:my_results')));
      $list = elgg_list_entities($options);
      if ($list != '') {
        $this->page_elements['content'] = elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/result_listing_header');
        $this->page_elements['content'] .= $list;
      } else {
        $this->page_elements['content'] = '<div class="contentWrapper">' . elgg_echo('izap-contest:challenge:not_played') . '</div>';
      }
    }
    $this->drawpage();
  }

  public function actionPlay() {

    $container_guid = $this->url_vars[1];
    $contest = new IzapChallenge($container_guid, TRUE);

    if (!$contest->can_play()) {
      register_error(elgg_echo('izap-contest:challenge:not_accepted_yet'));
      forward($contest->getURL());
    }

    $quiz = $contest->current_question();
    $this->page_elements['content'] = elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/playing', array('challenge' => $contest, 'quiz' => $quiz));
    $this->drawPage();
  }

  public function actionIcon() {
    $challenge = get_entity($this->url_vars[1]);
    $size = $this->url_vars[2];

    $image_name = 'contest/' . $challenge->guid . '/icon' . (($size) ? $size : 'small') . '.jpg';
    $content = IzapBase::getFile(array(
                'source' => $image_name,
                'owner_guid' => $challenge->owner_guid,
            ));

    if (empty($content)) {
      $content = file_get_contents(elgg_get_plugins_path() . 'izap-forum/_graphics/no-pic.png');
    }

    $header_array = array();
    $header_array['content_type'] = 'image/jpeg';
    $header_array['file_name'] = elgg_get_friendly_title($challenge->title);
    IzapBase::cacheHeaders($header_array);
    echo $content;
  }

}