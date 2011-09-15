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


/**
 * this converts the array into object
 *
 * @param array $array
 * @return object
 */
function izap_array_to_object($attr) {
  if(is_object($attr)) {
    return $attr;
  }elseif(!is_array($attr)) {
    return false;
  }

  $obj = new stdClass();
  foreach ($attr as $key => $value) {
    $obj->$key = $value;
  }
  return $obj;
}


//function izap_process_uncompleted_challenge($page) {
//  global $CONFIG;
//  $context = get_context();
//  // if user is not on the play page
//  if(!($context == 'challenge' && ($page == 'play' || $page == 'result'))) {
//    // if user have left play page, the declare his/her result
//    if((int)$_SESSION['challenge']['contest'] > 0) {
//      $challenge = new IzapChallenge($_SESSION['challenge']['contest']);
//      $result = $challenge->save_results(FALSE);
//      forward($CONFIG->wwwroot . 'pg/challenge/result/' . $challenge->guid . '/' . $result->guid . '/');
//    }
//  }
//
//}