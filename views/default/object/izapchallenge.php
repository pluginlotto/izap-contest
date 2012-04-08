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

global $CONFIG;
$owner = $vars['entity']->getOwnerEntity();
$video_pic = elgg_view('output/url', array(
    'href' => $vars['entity']->getUrl(),
    'text' => $vars['entity']->getThumb()
        ));

$owner_link = elgg_view('output/url', array(
    'href' => IzapBase::setHref(array(
        'action' => 'owner',
        'page_owner' => $vars['entity']->container_username,
    )),
    'text' => $owner->name,
        ));

$author_text = elgg_echo('byline', array($owner_link));

$date = elgg_view_friendly_time($vars['entity']->time_created);


if ($vars['entity']->comments_on) {
  $comments_count = $vars['entity']->countComments();
  //only display if there are commments
  if ($comments_count != 0) {
    $text = elgg_echo("comments") . " ($comments_count)";
    $comments_link = elgg_view('output/url', array(
        'href' => $vars['entity']->getURL() . '#video-comments',
        'text' => $text,
            ));
  } else {
    $comments_link = '';
  }
} else {
  $comments_link = '';
}

$subtitle = "<p>$author_text $date $comments_link</p>";

$description = strip_tags($vars['entity']->description);
$description = substr($description, 0, 200) . ((strlen($description) > 200) ? '...' : '' );

$title_link = elgg_view('output/url', array(
    'text' => substr($vars['entity']->title, 0, 55) . ((strlen($vars['entity']->title) > 55) ? '...' : '' ),
    'href' => $vars['entity']->getURL(),
        ));

$metadata = IzapBase::controlEntityMenu(array('entity' => $vars['entity'], 'handler' => GLOBAL_IZAP_CONTEST_CHALLENGE_PAGEHANDLER));
$tags = elgg_view('output/tags', array('tags' => $vars['entity']->tags));
if (elgg_get_context() == 'izap_mini_list') {
  $metadata = '';
  $tags = false;
}
$params = array(
    'entity' => $vars['entity'],
    'metadata' => $metadata,
    'title' => $title_link,
    'subtitle' => $subtitle,
    'tags' => $tags,
    'content' => $description,
);
$params = $params + $vars;
$list_body = elgg_view('object/elements/summary', $params);
echo elgg_view_image_block($video_pic, $list_body);
?>
