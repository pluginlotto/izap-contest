<?php
  include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
  $entity_guid = (int) get_input('id');
  $size = get_input('size');
  $entity = get_entity($entity_guid);
  $contents = $entity->get_media($size);
  $expires = 14 * 60*60*24;
  $mime = $entity->getMimeType();
  header("Content-Type: $mime");
  header("Content-Length: " . strlen($contents));
  header("Cache-Control: public", true);
  header("Pragma: public", true);
  header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $expires) . ' GMT', true);
  echo $contents;
  exit;
?>
