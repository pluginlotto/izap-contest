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
