<?php
/**************************************************
* iZAP Web Solutions                              *
* Copyrights (c) 2005-2009. iZAP Web Solutions.   *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Kumar<tarun@izap.in>"
 */

// only for the loggedin users
gatekeeper();
set_input('username', get_loggedin_user()->username);
$contest = new IZAPChallenge(get_input('container_guid'));
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