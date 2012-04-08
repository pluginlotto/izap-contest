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

// add subtype with class
if (get_subtype_id('object', GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE)) {
  update_subtype('object', GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE, GLOBAL_IZAP_CONTEST_CHALLENGE_CLASS);
} else {
  add_subtype('object', GLOBAL_IZAP_CONTEST_CHALLENGE_SUBTYPE, GLOBAL_IZAP_CONTEST_CHALLENGE_CLASS);
}

if (get_subtype_id('object', GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE)) {
  update_subtype('object', GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE, GLOBAL_IZAP_CONTEST_QUIZ_CLASS);
} else {
  add_subtype('object', GLOBAL_IZAP_CONTEST_QUIZ_SUBTYPE, GLOBAL_IZAP_CONTEST_QUIZ_CLASS);
}