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

class IzapChallenge extends ZContest {

  protected $is_playing;
  protected $current_question;
  protected $form_attributes;

  protected function initializeAttributes() {
    parent::initializeAttributes();
    $this->attributes['subtype'] = GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE;
  }

  public function __construct($guid = null, $start_play = false) {
    parent::__construct($guid);

    if ($start_play) {

      $this->is_playing = true;
      $this->start_playing();
    }

    // set default form attributes
    $this->form_attributes = array(
        'title' => array(),
        'description' => array(),
        'container_guid' => array(),
        'access_id' => array(),
        'required_correct' => array(),
        'max_quizzes' => array(),
        'timer' => array(),
        're_attempt' => array(),
        'negative_marking' => array(),
        'terms' => array(),
        'tags' => array(),
        'comments_on' => array()
    );
  }

  /**
   * returns the form_attributes of the object
   */
  public function getAttributesArray() {
    return $this->form_attributes;
  }

  /**
   *
   * @param  <boolean>  $force. True will ignore the media deletion and just drop the entity
   * @return <boolean>          True on success else false
   */
  public function delete($force = false) {
    if ($this->izap_delete_files(unserialize($this->related_media)) || $force) {
      $quizzes_array = unserialize($this->quizzes);

      // deleting all related quizzes
      if (count($quizzes_array) > 0) {
        foreach ($quizzes_array as $quiz_guid => $quiz_val) {
          $quiz = get_entity($quiz_val);
          if ($quiz) {
            $quiz->delete();
          }
        }
      }

      return delete_entity($this->guid, true);
    }
    return false;
  }

  /**
   * calls the save of the parent class to save the object
   */
  public function save() {
    return parent::save();
  }

  /**
   * returns the total number of quizes of the contest
   */
  public function total_quizzes() {
    $quizzes = count(($this->quizzes) ? unserialize($this->quizzes) : null);
    return(($quizzes) ? $quizzes : 0);
  }

  /**
   * returns the media file to the contest
   * @param  <mixed>   size of the media
   * 
   * @return <mixed>  file or false on failure
   */
  public function get_media($size = false) {
    $media_array = unserialize($this->related_media);
    return $this->get_file($media_array, $size);
  }

  /**
   * returns if the user has accepted the challenge
   * @param  <string>    user_guid
   * 
   * @return <boolean> 
   */
  public function can_play($user_guid = 0) {
    // get the array of all the users who accepted the challenge
    $accepted_by = (array) $this->accepted_by;

    // if user guid is not supplied then, get loggeding user
    if (!$user_guid) {
      $user_guid = elgg_get_logged_in_user_guid();
    }

    // if still no user_guid, then go back
    if (!$user_guid) {
      return false;
    }

    // check if user has really accepted the challegne
    if (in_array($user_guid, $accepted_by)) {
      return true;
    }

    // if it reaches here, then false
    return false;
  }

  /** 
   *  returns if user is allowed to play the challenge
   *  checks if user has accepted it
   *  checks if user can re-attempt it
   *  checks if the time for the challenge has expired
   *  @param   <string>   user_guid
   * 
   *  @return  <string>
   */
  public function canAttempt($user_guid = 0) {

    // check if required number of questions are available or not
    if ($this->total_questions < $this->max_quizzes) {
      return false;
    }

    // get the array of all the users who accepted the challenge
    $accepted_by = (array) $this->accepted_by;

    // if user guid is not supplied then, get loggeding user
    if (!$user_guid) {
      $user_guid = elgg_get_logged_in_user_guid();
    }

    // if still no user_guid, then go back
    if (!$user_guid) {
      return false;
    }

    $return = False;
    // check if user has really accepted the challegne
    if (!in_array($user_guid, $accepted_by)) {
      $return = true;
    }
    if (!$return && $this->re_attempt != '') {
      $user_var = elgg_get_logged_in_user_entity()->username . '_last_attempt';
      $last_attempt = (int) $this->$user_var;
      if (time() > ($last_attempt + (int) ($this->re_attempt * 60 * 60))) {
        return true;
      } else {
        return false;
      }
    } else {
      return $return;
    }

    // if it reaches here, then false
    return false;
  }

  /**
   * start the contest by starting session
   */
  public function start_playing() {
    // get the currently playing challenge
    $challenge_being_played = $_SESSION['challenge'];

    // if it in not the this challenge, then replace it
    if (!array_key_exists($this->guid, $challenge_being_played)) {

      // set all values to result
      $_SESSION['challenge'][$this->guid]['start_time'] = time();
      $_SESSION['challenge'][$this->guid]['completed'] = false;
      $_SESSION['challenge'][$this->guid]['active'] = true;
      // get all guids for the questions
      $all_questions_array = unserialize($this->quizzes);

      // shuffle to make them random
      shuffle($all_questions_array);

      // now get the amount you want for the test
      $randon_keys = array_rand($all_questions_array, $this->max_quizzes);

      foreach ($randon_keys as $k => $q) {
        $questions_array[] = $all_questions_array[$q];
      }

      if (sizeof($questions_array)) {
        foreach ($questions_array as $question) {
          if ($question_entity = get_entity($question)) {
            if ($question_entity->getSubtype() == 'izapquiz') {
              $_SESSION['challenge'][$this->guid]['questions'][] = $question;
            }
          }
        }
      }
    }
  }

  /**
   * calculates if the time is out
   * 
   * @return   <boolean>
   */
  public function timeLeft() {
    $diff = time() - ((int) $_SESSION['challenge'][$this->guid]['start_time']);
    $maximum_time = 60 * (($this->timer) ? $this->timer : 10000);

    if ($diff < $maximum_time) {
      return true;
    }

    return false;
  }

  /**
   * returns the current questions or saves the results and forwards to result action
   * @global <array> $CONFIG
   * @return <>
   */
  public function current_question() {

    global $CONFIG;
    // get current question from the session
    $this->current_question = get_entity($_SESSION['challenge'][$this->guid]['questions'][(int) $_SESSION['challenge'][$this->guid]['qc']]);
    // only return if it validates
    if ($this->current_question && $this->current_question instanceof IzapQuiz) {
      return $this->current_question;
    } else {
      $result = $this->save_results();
      forward(IzapBase::setHref(array(
                  'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
                  'action' => 'result',
                  'vars' => array(
                      $this->guid,
                      $result->guid,
                      elgg_get_friendly_title($this->title)
                  )
                      )
              )
      );
    }
  }

  /**
   * saves the results of the contest as elggObject
   * @param <boolean> $complete_status
   * @return ElggObject $result
   */
  public function save_results($complete_status = true) {

    $_SESSION['challenge'][$this->guid]['completed'] = $complete_status;
    $challenge = $_SESSION['challenge'][$this->guid];

    $result = new ElggObject();
    $result->subtype = 'izap_challenge_results';
    $result->access_id = ACCESS_PUBLIC;
    $result->container_guid = $this->guid;
    $result->title = $this->title;
    $result->description = serialize($challenge['answers']);
    $result->total_score = (int) $challenge['totals'];
    $result->total_correct_answers = (int) $challenge['total_correct_answers'];
    $result->total_attemped_questions = (int) $challenge['qc'];
    $result->total_questions = (int) count($challenge['questions']);
    $result->required_percentage = $this->required_correct;
    $total_percentage = round((($result->total_score / $result->total_questions) * 100), 0);
    $result->total_percentage = (int) (($total_percentage) ? $total_percentage : 0);
    $result->status = ((int) $result->total_percentage < (int) $this->required_correct) ? 'failed' : 'passed';
    $result->challenge_guid = $this->guid;
    $result->is_completed = ($complete_status) ? 'yes' : 'no';
    $result->total_time_taken = time() - $challenge['start_time'];

    IzapBase::getAllAccess(); // force save
    $user_var = elgg_get_logged_in_user_entity()->username . '_last_attempt';
    $this->$user_var = time();
    $this->total_attempted = (int) $this->total_attempted + 1;
    $user_var = elgg_get_logged_in_user_entity()->username . '_total_attempted';
    $this->$user_var = (int) $this->$user_var + 1;

    if ($result->status == 'passed') {
      $pass_var = elgg_get_logged_in_user_entity()->username . '_total_passed';
      $this->total_passed = (int) $this->total_passed + 1;
      $this->$pass_var = (int) $this->$pass_var + 1;
    }

    $result->save();
    Izapbase::removeAccess();
//unset($_SESSION['challenge'][$this->guid]['active']);
    return $result;
  }

  /**
   * invites the friends to play the challenge through notification
   * @param <array> $friends_array array of the friends's guid
   */
  public function inviteFriends($friends_array) {
    if (!sizeof($friends_array)) {
      return false;
    }

    foreach ($friends_array as $friend_guid) {
      if ($friend_guid != $this->owner_guid) {
        notify_user(
                $friend_guid, elgg_get_logged_in_user_guid(), elgg_echo('izap-contest:challenge_invitation'), elgg_echo('izap-contest:challenge_inivitation_message', array(elgg_get_logged_in_user_entity()->name, $this->getUrl())
                )
        );
        system_message(elgg_echo('izap-contest:challenge:successfully_challenged'));
      }else
        register_error(elgg_echo('izap-contest:challenge:can_not_challenge_owner'));
    }
  }

  /**
   * gives the url of the contest
   * @global  $CONFIG
   * @return <string> 
   */
  public function getURL() {
    global $CONFIG;
    $title = elgg_get_friendly_title($this->title);

    $container_name = $this->container_username;
    if ($container_name == '') {
      $container_entity = get_entity($this->container_guid);
      $container_name = $container_entity->username;
    }

    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
        'action' => 'view',
        'page_owner' => $container_name,
        'vars' => array($this->guid, $title)
    ));
  }

  /**
   * gives the image source for the icon of the challenge
   * @param <string> $size
   * @return <url>
   */
  public function getIconURL($size = 'small') {
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
        'action' => 'icon',
        'page_owner' => False,
        'vars' => array($this->guid, $size,)
    )) . $this->time_updated . ".jpg";
  }

  /**
   * returns the thumb/icon for the challenge
   * @param <string> $size
   * @return <string>
   */
  public function getThumb($size) {

    $size = (isset($size) && $size != '') ? $size : 'small';
    $image = '<div>';
    $image .= '<img src="' . $this->getIconURL($size) . '"/>';
    $image .= '</div>';
    return $image;
  }

}