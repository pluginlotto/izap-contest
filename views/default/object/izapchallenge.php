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
global $IZAPTEMPLATE;
if(get_context() == 'search') {
  $IZAPTEMPLATE->render('challenge/listing', array('entity' => $vars['entity']));
}else {
$extra .= '<b>'.elgg_echo("zcontest:challenge:total_attempted").':</b> '.(int) $vars['entity']->total_attempted . '<br />';
$extra .= '<b>'.elgg_echo("zcontest:challenge:total_passed").':</b> '.(int) $vars['entity']->total_passed . '<br />';
if(!empty($vars['entity']->required_correct)) {
      $extra .=  "<b>".elgg_echo("zcontest:challenge:must_answer").":</b> ".$vars['entity']->required_correct."%</p>";
    }else {
      $extra .=  "<b>".elgg_echo("zcontest:challenge:must_answer").":</b> 100%</p>";
    }
echo $IZAPTEMPLATE->render('output/entity_row', array('entity' => $vars['entity'], 'extra' => $extra));
}