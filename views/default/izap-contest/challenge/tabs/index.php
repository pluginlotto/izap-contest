<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version 1.0
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
*/

$challenge = $vars['entity'];
$tab_array[] = array(
        'title'=>elggb_echo('comments'),
        'content'=>elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'tabs/comments',array('entity'=>$challenge)),
);
$tab_array[] = array(
        'title'=>elggb_echo('send_to_friend'),
        'content'=>elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'tabs/send_to_friend',array('entity'=>$challenge)),
);if(isloggedin()) {
  $tab_array[] = array(
          'title'=>elgg_echo('zcontest:challenge:challenge_friend'),
          'content'=>elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'tabs/challenge_friend',array('entity'=>$challenge)),
  );
}$tab_array[] = array(
        'title'=>elggb_echo('terms'),
        'content'=>elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'tabs/terms',array('entity'=>$challenge)),
);

echo izap_elgg_bridge_view('tabs', array('tabsArray'=> $tab_array));
