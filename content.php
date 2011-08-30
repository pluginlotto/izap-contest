<?php
/***************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2011. iZAP                  *
 * All rights reserved                             *
 ***************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forum/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
$entity_guid = (int) get_input('id');
$size = get_input('size');
$entity = get_entity($entity_guid);
$contents = $entity->get_media($size);
IzapBase::cacheHeaders(array(
        'content_type' => $entity->getMimeType(),
        'file_name' => elgg_get_friendly_title($entity->title),
));
echo $contents;
exit;