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

$entity = $vars['entity'];

$title_link = elgg_extract('title', $vars, '');
if ($title_link === '') {
  if (isset($entity->title)) {
    $text = $entity->title;
  } else {
    $text = $entity->name;
  }
  $params = array(
      'text' => $text,
      'href' => $entity->getURL(),
  );
  $title_link = elgg_view('output/url', $params);
}

$metadata = elgg_extract('metadata', $vars, '');
$subtitle = elgg_extract('subtitle', $vars, '');
$content = elgg_extract('content', $vars, '');

$tags = elgg_extract('tags', $vars, '');
if ($tags !== false) {
  $tags = elgg_view('output/tags', array('tags' => $entity->tags));
}

if ($metadata) {
  echo $metadata;
}
echo "<h3>$title_link</h3>";
echo "<div class=\"elgg-subtext\">$subtitle</div>";
echo $tags;
if ($content) {
  echo "<div class=\"elgg-content\">$content</div>";
}
