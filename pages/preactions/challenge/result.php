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

// only for the loggedin users
gatekeeper();
$contest = get_entity(get_input('container_guid'));
if((int)(get_input('guid'))) {
  $result = get_entity(get_input('guid'));
  $area2 = elgg_view(func_get_template_path_byizap(array('type'=>'challenge', 'plugin' => 'izap-contest')). 'result', array('result' => $result));
}else {
  $options = array(
    'type' => 'object',
    'subtype' => 'izap_challenge_results',
    'owner_guid' => get_loggedin_userid(),
    'container_guid' => $contest->guid,
    'limit' => 20,
  );

  $area2 = elgg_view_title(elgg_echo('zcontest:challenge:my_results'));
  $list = elgg_list_entities($options);
  if($list != '') {
  $area2 .= elgg_view(func_get_template_path_byizap(array('plugin' => 'izap-contest', 'type' => 'challenge')) . 'result_listing_header');
  $area2 .= $list;
  }else{
    $area2 .= '<div class="contentWrapper">'.elgg_echo('zcontest:challenge:not_played').'</div>';
  }
}

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);

// Display page
page_draw(elgg_echo('izap_offer_article:detail'),$body);