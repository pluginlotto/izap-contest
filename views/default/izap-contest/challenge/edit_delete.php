<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

if($vars['entity']->canEdit()) {
  echo elgg_view('output/url', array(
      'href' => func_set_href_byizap(array(
      'context' => GLOBAL_IZAP_CONTEST_PAGEHANDLER_CHALLENGE,
      'page' => 'edit',
      'vars' => array($vars['entity']->getGuid())
      )),
  'text' => elgg_echo('zcontest:challenge:edit'),
  ));
  echo ' / ';
  echo elgg_view("output/confirmlink", array(
      'href' => $vars['url'] . "action/challenge/delete?guid=" . $vars['entity']->getGUID().'&curl='.urlencode($vars['url'].'pg/challenge/list/'.$_SESSION['user']->username),
      'text' => elgg_echo('zcontest:challenge:delete'),
      'confirm' => elgg_echo('zcontest:challenge:delete'),
  ));
}