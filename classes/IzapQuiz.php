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

class IzapQuiz extends ZContest {

  protected function initialise_attributes() {
    parent::initialise_attributes();
    $this->attributes['subtype'] = GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE;
  }

  public function __construct($guid = null) {
    parent::__construct($guid);

//    $this->form_attributes = array(
//        'title' => array(),
//        'description' => array(),
//        'container_guid' => array(),
//        'access_id' => array(),
////        'videoUrl' => array(),
////        'videoType' => array(),
////        'tags' => array(),
////        'categories' => array(),
//        //'comments_on' =>array()
//    );
  }

  /**
   *
   * @param <boolean> $force. True will ignore the media deletion and just drop the entity
   * @return <boolean> True on success else false
   */
  public function delete($force = false) {
    if ($this->izap_delete_files(unserialize($this->related_media)) || $force) {

      $challenge_object = get_entity($this->container_guid);
      $quizzes = unserialize($challenge_object->quizzes);

      foreach ($quizzes as $key => $guid) {
        if ($guid != $this->guid) {
          $new_quizzes[] = $guid;
        }
      }

      $challenge_object->total_questions = count($new_quizzes);
      $quizzes_string = serialize($new_quizzes);
      $challenge_object->quizzes = $quizzes_string;

      return delete_entity($this->guid, TRUE);
    }
    return false;
  }

  public function save(IzapChallenge $ch = null) {
    if (!$ch->lock) {
      return parent::save(true, array('river' => false));
    } else {
      return false;
    }
  }

  public function get_quiz_mime() {
    $media_array = unserialize($this->related_media);
    if ($media_array != '' && isset($media_array['file_type']))
      return $media_array['file_type'];
    return $this->qtype;
  }

  private function get_video($media, $size = false) {
    $flash_video_object = new IZAPVideoApi($media['file_url']);
    list($width, $height) = explode('x', $size);
    return $flash_video_object->getVideoFeed($width, $height);
  }

  public function get_media($size = false) {
    $media_array = unserialize($this->related_media);
    if (preg_match('/image.+/', $media_array['file_type'])) {
      return $this->get_file($media_array, $size);
    } elseif (preg_match('/audio.+/', $media_array['file_type'])) {
      return $this->get_file($media_array);
    } elseif (preg_match('/video.+/', $media_array['file_type'])) {
      return $this->get_video($media_array, $size);
    }
  }

  public function get_options() {
    return array_flip(unserialize($this->options));
  }

//  public function getEditURL() {
//    global $CONFIG;
//
//    return $CONFIG->url . "pg/quiz/edit/" . $this->container_guid . "/" . $this->guid . "/" . friendly_title($this->title) .
//    '?rurl=' . urlencode(current_page_url());
//    ;
//  }

  public function getCorrectAnswer($force = FALSE) {
    if (get_loggedin_userid() == $this->owner_guid || $force) {
      return $this->correct_option;
    }

    return FALSE;
  }

  function getURL() {

    $title = friendly_title($this->title);
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
        'action' => 'view',
        'vars' => array($this->container_guid, $this->guid, $title)
    ));
  }

  public function getIconURL($size = 'small') {
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
        'action' => 'icon',
        'page_owner' => FALSE,
        'vars' => array($this->guid, $size,)
    )) . $this->time_updated . ".jpg";
  }

  public function getThumb() {
    $image = '<div>';
    $image .= '<img src="' . $this->getIconURL('medium') . '"/>';
    $image .= '</div>';
    return $image;
  }

}