<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/
class IZAPQuiz extends ZContest {
  protected function initialise_attributes() {
    parent::initialise_attributes();
    $this->attributes['subtype'] = "izapquiz";
  }

  public function __construct($guid = null) {
    parent::__construct($guid);
  }
  /**
   *
   * @param <boolean> $force. True will ignore the media deletion and just drop the entity
   * @return <boolean> True on success else false
   */
  public function delete_me($force = false) {
    if($this->izap_delete_files(unserialize($this->related_media)) || $force) {

      $challenge_object = get_entity($this->container_guid);
      $quizzes = unserialize($challenge_object->quizzes);
      unset($quizzes[$this->guid]);
      $challenge_entity->total_questions = count($quizzes);
      $quizzes_string = serialize($quizzes);
      $challenge_object->quizzes = $quizzes_string;

      return delete_entity($this->guid, TRUE);
    }
    return false;
  }

  public function save_me(IZAPChallenge $ch = null) {
    if(!$ch->lock) {
      return $this->save();
    }
    else {
      return false;
    }
  }

  public function get_quiz_mime() {
    $media_array = unserialize($this->related_media);
    return $media_array['file_type'];
  }

  private function get_video($media, $size = false) {
    $flash_video_object = new IZAPVideoApi($media['file_url']);
    list($width, $height) = explode('x', $size);
    return $flash_video_object->getFeed($width, $height);
  }

  public function get_media($size = false) {
    $media_array = unserialize($this->related_media);
    if(preg_match('/image.+/',$media_array['file_type'])) {
      return $this->get_file($media_array,$size);
    }elseif(preg_match('/audio.+/',$media_array['file_type'])) {
      return $this->get_file($media_array);
    }elseif(preg_match('/video.+/',$media_array['file_type'])) {
      return $this->get_video($media_array, $size);
    }
  }
  public function get_options() {
    return array_flip(unserialize($this->options));
  }
}