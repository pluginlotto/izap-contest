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

class IzapChallenge extends ZContest {

  protected $is_playing;
  protected $current_question;

  protected function initializeAttributes() {
    parent::initializeAttributes();
    $this->attributes['subtype'] = GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE;
  }

  public function __construct($guid = null, $start_play = FALSE) {
    parent::__construct($guid);
    
    if ($start_play) {
      $this->is_playing = TRUE;
      $this->start_playing();
    }

    // 
    //
    // DO NOT UNCOMMENT THIS CODE : BY CHETAN SHARMA WE NEED TO THINK ALOT ABOUT THIS.
    //
    //
    // set default form attributes
//    $this->form_attributesaasa = array(
//        'title' => array(),
//        'description' => array(),
//        'container_guid' => array(),
//        'access_id' => array(),
//        'required_correct' => array(),
//        'max_quizzes' => array(),
//        'timer' => array(),
//        're_attempt' => array(),
//        'negative_marking' => array(),
//        'terms' => array(),
//        'tags' => array(),
//        'comments_on' => array()
//    );
  
  }

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

  public function save() {
    if (!$this->lock)
      return parent::save();
    else
      return false;
  }

  public function total_quizzes() {
    $quizzes = count(($this->quizzes) ? unserialize($this->quizzes) : null);
    return(($quizzes) ? $quizzes : 0);
  }

  public function get_media($size = false) {
    $media_array = unserialize($this->related_media);
    return $this->get_file($media_array, $size);
  }

  public function can_play($user_guid = 0) {
    // get the array of all the users who accepted the challenge
    $accepted_by = (array) $this->accepted_by;

    // if user guid is not supplied then, get loggeding user
    if (!$user_guid) {
      $user_guid = get_loggedin_userid();
    }

    // if still no user_guid, then go back
    if (!$user_guid) {
      return FALSE;
    }

    // check if user has really accepted the challegne
    if (in_array($user_guid, $accepted_by)) {
      return TRUE;
    }

    // if it reaches here, then false
    return FALSE;
  }

  public function canAttempt($user_guid = 0) {

    // check if required number of questions are available or not
    if ($this->total_questions < $this->max_quizzes) {
      return FALSE;
    }

    // get the array of all the users who accepted the challenge
    $accepted_by = (array) $this->accepted_by;

    // if user guid is not supplied then, get loggeding user
    if (!$user_guid) {
      $user_guid = get_loggedin_userid();
    }

    // if still no user_guid, then go back
    if (!$user_guid) {
      return FALSE;
    }

    $return = FALSE;
    // check if user has really accepted the challegne
    if (!in_array($user_guid, $accepted_by)) {
      $return = TRUE;
    }

    if (!$return && $this->re_attempt) {
      $user_var = get_loggedin_user()->username . '_last_attempt';
      $last_attempt = (int) $this->$user_var;
      if (time() > ($last_attempt + 48 * 60 * 60)) {
        return TRUE;
      } else {
        return FALSE;
      }
    } else {
      return $return;
    }

    // if it reaches here, then false
    return FALSE;
  }

  public function start_playing() {
    // get the currently playing challenge
    $challenge_being_played = $_SESSION['challenge']['contest'];
    // if it in not the this challenge, then replace it
    if ($challenge_being_played != $this->guid) {

      // set all values to result
      $_SESSION['challenge']['contest'] = $this->guid;
      $_SESSION['challenge']['start_time'] = time();
      $_SESSION['challenge']['completed'] = FALSE;
      $all_questions_array = unserialize($this->quizzes);

      shuffle($all_questions_array);
      $randon_keys = array_rand($all_questions_array, $this->max_quizzes);
      foreach ($randon_keys as $k => $q) {
        $questions_array[] = $all_questions_array[$q];
      }

      if (sizeof($questions_array)) {
        foreach ($questions_array as $question) {
          if ($question_entity = get_entity($question)) {
            if ($question_entity->getSubtype() == 'izapquiz') {
              $_SESSION['challenge']['questions'][] = $question;
            }
          }
        }
      }
    }
  }

  public function timeLeft() {
    $diff = time() - ((int) $_SESSION['challenge']['start_time']);
    $maximum_time = 60 * (($this->timer) ? $this->timer : 10000);

    if ($diff < $maximum_time) {
      return TRUE;
    }

    return FALSE;
  }

  public function current_question() {
    global $CONFIG;
    // get current question from the session
    $this->current_question = get_entity($_SESSION['challenge']['questions'][(int) $_SESSION['challenge']['qc']]);
    // only return if it validates
    if ($this->current_question && $this->current_question instanceof IZAPQuiz) {
      return $this->current_question;
    } else {
      $result = $this->save_results();
      forward($CONFIG->wwwroot . 'pg/challenge/result/' . $this->guid . '/' . $result->guid . '/' . friendly_title($this->title));
    }
  }

  public function save_results($complete_status = TRUE) {

    $_SESSION['challenge']['completed'] = $complete_status;
    $challenge = $_SESSION['challenge'];

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

    func_hook_access_over_ride_byizap(array('status' => TRUE)); // force save
    $user_var = get_loggedin_user()->username . '_last_attempt';
    $this->$user_var = time();
    $this->total_attempted = (int) $this->total_attempted + 1;
    $user_var = get_loggedin_user()->username . '_total_attempted';
    $this->$user_var = (int) $this->$user_var + 1;

    if ($result->status == 'passed') {
      $pass_var = get_loggedin_user()->username . '_total_passed';
      $this->total_passed = (int) $this->total_passed + 1;
      $this->$pass_var = (int) $this->$pass_var + 1;
    }

    $result->save();
    func_hook_access_over_ride_byizap(array('status' => FALSE));

    return $result;
  }

  public function inviteFriends($friends_array) {
    if (!sizeof($friends_array)) {
      return false;
    }

    foreach ($friends_array as $friend_guid) {
      if ($friend_guid != $this->owner_guid) {
        notify_user(
                $friend_guid,
                get_loggedin_user()->guid,
                elgg_echo('zcontest:challenge_invitation'),
                sprintf(elgg_echo('zcontest:challenge_inivitation_message'), get_loggedin_user()->name, $this->getUrl()
                )
        );
      }
    }
  }

  public function getURL() {
    global $CONFIG;
    $title = friendly_title($this->title);

    $container_name = $this->container_username;
    if ($container_name == '') {
      $container_entity = get_entity($this->container_guid);
      $container_name = $container_entity->username;
    }

    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
        'action' => 'view',
        'vars' => array($this->guid, $title)
    ));
  }

  public function getIconURL($size = 'small') {
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
        'action' => 'icon',
        'page_owner' => FALSE,
        'vars' => array($this->guid, $size,)
    )) . $this->time_updated . ".jpg";
  }

  public function getThumb() {
    $image = '<div>';
    $image .= '<img src="'.$this->getIconURL('small').'"/>';
    $image .= '</div>';
    return $image;
  }

}