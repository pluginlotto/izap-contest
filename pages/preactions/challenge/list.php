<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . "/engine/start.php");
// get page owner entity
$page_owner = page_owner_entity();

$listing_options = array();
$listing_options['type'] = 'object';
$listing_options['subtype'] = 'izapchallenge';
if($page_owner == $_SESSION['user']) {
  $area2 = elgg_view_title(elgg_echo('zcontest:challenge:my'));
  $listing_options['owner_guid'] = $page_owner->guid;
}elseif($page_owner) {
  $area2 = elgg_view_title(sprintf(elgg_echo('zcontest:user'),$page_owner->name));
  $listing_options['owner_guid'] = $page_owner->guid;
}else {
  set_input('username', get_loggedin_user()->username);
  $area2 = elgg_view_title(elgg_echo('zcontest:challenge:all'));
}


  $list = elgg_list_entities($listing_options);

  if(empty($list) || $list == ''){
    $area2 .= '<div class="contentWrapper">' . elgg_echo('zcontest:notfound') . '</div>';
  }
  else{
    $area2 .= $list;
  }

// get tags and categories

$body = elgg_view_layout("two_column_left_sidebar", '', $area2);
page_draw(sprintf(elgg_echo('zcontest:user'),$page_owner->name),$body);