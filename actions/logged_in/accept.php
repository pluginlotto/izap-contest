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

gatekeeper();
global $CONFIG;

$challenge_form = get_input('challenge');
$challenge_entity = new IzapChallenge($challenge_form['guid']);

Izapbase::getAllAccess(); //func_hook_access_over_ride_byizap(array('status' => TRUE));
$user_array = (array) $challenge_entity->accepted_by;
$user_array[] = elgg_get_logged_in_user_guid();
$user_array = array_unique($user_array);
$challenge_entity->accepted_by = array();
$challenge_entity->accepted_by = $user_array;
IzapBase::removeAccess(); //func_hook_access_over_ride_byizap(array('status' => FALSE));


forward(Izapbase::setHref(array(
            'context' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER,
            'action' => 'play',
            'page_owner' => false,
            'vars' => array($challenge_entity->guid, friendly_title($challenge_entity->title))
        )));
//forward($CONFIG->wwwroot . 'pg/challenge/play/' . $challenge_entity->guid . '/' . friendly_title($challenge_entity->title));
