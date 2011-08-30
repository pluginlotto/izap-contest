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

?>
<div class="izap-quiz-wrapper">
  <div class="izap-quiz-title">
    <h3>
      <a href="<?php echo $vars['entity']->getUrl() ?>" >
        <?php echo $vars['entity']->title; ?>
      </a>
    </h3>
  </div>

  <div>
    <?php
        echo IzapBase::controlEntityMenu(array(
            'entity' => $vars['entity'],
            'handler' => GLOBAL_IZAP_CONTEST_QUIZ_PAGEHANDLER,
            'vars' => array($vars['entity']->container_guid, $vars['entity']->getGUID(), elgg_get_friendly_title($vars['entity']->title))
        ));
    ?>
  </div>
</div>
<div class="clearfloat"></div>