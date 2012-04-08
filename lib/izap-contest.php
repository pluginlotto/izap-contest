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

/**
 * this converts the array into object
 *
 * @param   array  $array
 * 
 * @return  object
 */
function izap_array_to_object($attr) {
  if (is_object($attr)) {
    return $attr;
  } elseif (!is_array($attr)) {
    return false;
  }

  $obj = new stdClass();
  foreach ($attr as $key => $value) {
    $obj->$key = $value;
  }
  return $obj;
}
