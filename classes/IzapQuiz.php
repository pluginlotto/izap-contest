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

class IzapQuiz extends ZContest {

  protected $form_attributes;

  protected function initialise_attributes() {
    parent::initializeAttributes();
    $this->attributes['subtype'] = GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE;
  }

  public function __construct($guid = null) {
    parent::__construct($guid);

    $this->form_attributes = array(
        'title' => array(),
        'description' => array(),
        'container_guid' => array(),
        'access_id' => array(),
        'solution' => array(),
        'tags' => array(),
        'qtype' => array(),
        'correct_option' => array()
    );
  }

  /**
   * returns the form_attributes
   * 
   * @return  <array>
   */
  public function getAttributesArray() {
    return $this->form_attributes;
  }

  /**
   *
   * @param   <boolean>  $force. True will ignore the media deletion and just drop the entity
   * 
   * @return  <boolean>          True on success else false
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

      return delete_entity($this->guid, true);
    }
    return false;
  }

  /**
   * saves the quiz
   * @param    IzapChallenge   $ch
   * @return   <boolean>            true on success else false
   */
  public function save(IzapChallenge $ch = null) {

    return parent::save(true, array('river' => false));
  }

  /**
   * gives the mime type of the quiz
   * 
   * @return     <string>
   */
  public function get_quiz_mime() {
    $media_array = unserialize($this->related_media);
    if ($media_array != '' && isset($media_array['file_type']))
      return $media_array['file_type'];
    return $this->qtype;
  }

  /**
   * gives the videofeed from the videoApi
   * @param   <array>  $size
   * 
   * @return                     videosrc
   */
  private function get_video($size = false) {
    $video = new IZAPVideoApi();
    $video = $video->getVideoEntity($this->video_guid);
    return $video->videosrc;
  }

  /**
   * gives the media for the quiz
   * @param   <type>  $size
   * 
   * @return  <file>         media file
   */
  public function get_media($size = false) {
    $media_array = unserialize($this->related_media);
    if (preg_match('/image.+/', $media_array['file_type'])) {
      return $this->get_file($media_array, $size);
    } elseif (preg_match('/audio.+/', $media_array['file_type'])) {
      return $this->get_file($media_array);
    } elseif (preg_match('/video.+/', $media_array['file_type'])) {
      return $this->get_video($size);
    }
  }

  /**
   * returns the options of the quiz
   * 
   * @return    <array>
   */
  public function get_options() {
    $arra = unserialize($this->options);
    foreach ($arra as $key => $val) {
      $ret[' ' . $val] = (string) $key;
    }
    return $ret;
    return array_flip(unserialize($this->options));
  }

  /**
   * returns the correct answer of the quiz
   * @param   <type>   $force  true if want to have corrected answer for non-owner user
   * @return  <string>
   */
  public function getCorrectAnswer($force = FALSE) {
    if (elgg_get_logged_in_user_guid() == $this->owner_guid || $force) {
      return $this->correct_option;
    }

    return FALSE;
  }

  /**
   * gives the url of the quiz
   * 
   * @return  <string> 
   */
  function getURL() {
    $title = elgg_get_friendly_title($this->title);
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
        'action' => 'view',
        'vars' => array($this->container_guid, $this->guid, $title)
    ));
  }

  /**
   * returns the thumb of the quiz
   * 
   * @return  <string>  $image
   */
  public function getThumb() {
    $image = '<div>';
    $image .= '<img src="' . elgg_get_site_url() . 'mod/izap-contest/content.php?id=' . $this->guid . '&size=medium' . '"/>';
    $image .= '</div>';
    return $image;
  }

}