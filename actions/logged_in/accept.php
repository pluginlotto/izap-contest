<?php

/* * ***********************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 * *************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// this page accepts the selected challlenge of the user
izapbase::gatekeeper();
global $CONFIG;

$challenge_form = get_input('challenge');
$challenge_entity = new IzapChallenge($challenge_form['guid']);

Izapbase::getAllAccess();
$user_array = (array) $challenge_entity->accepted_by;
$user_array[] = elgg_get_logged_in_user_guid();
$user_array = array_unique($user_array);
$challenge_entity->accepted_by = array();
$challenge_entity->accepted_by = $user_array;
IzapBase::removeAccess();

// session gets start when user accepts a challenge and playing a challenge
$_SESSION['proper_started'][$challenge_entity->guid] = true;
forward(Izapbase::setHref(array(
            'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
            'action' => 'play',
            'page_owner' => false,
            'vars' => array($challenge_entity->guid, elgg_get_friendly_title($challenge_entity->title))
        )));
