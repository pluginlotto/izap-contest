<?php
/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * @version 1.0
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// this displays the additional options at the detail page of challenge
$challenge = $vars['entity'];
$tabs_array = array(
    'tabsArray' => array(
        array(
            'title' => elgg_echo('izap-contest:send_to_friend'),
            'content' => elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/tabs/send_to_friend', array('entity' => $challenge)),
        ),
        array(
            'title' => elgg_echo('izap-contest:terms'),
            'content' => elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/tabs/terms', array('entity' => $challenge)),
        ),
    )
);
if ($challenge->comments_on) {
  array_unshift($tabs_array['tabsArray'], array(
      'title' => elgg_echo('comments'),
      'content' => elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/tabs/comments', array('entity' => $challenge)),
  ));
}

if (elgg_is_logged_in()) {
  $tabs_array['tabsArray'][] = array(
      'title' => elgg_echo('izap-contest:challenge:challenge_friend'),
      'content' => elgg_view(GLOBAL_IZAP_CONTEST_PLUGIN . '/challenge/tabs/challenge_friend', array('entity' => $challenge)),
  );
}

echo elgg_view(GLOBAL_IZAP_ELGG_BRIDGE . '/views/tabs', $tabs_array);
?>
<script type="text/javascript">
  $(document).ready(function(){
    var anchor=$(location).attr('hash');
    var anchor2=$(location).attr('hash').substring(1);
    if(anchor.search('comment_')==1) {
      $.tabsByIzap('elgg_horizontal_tabbed_nav', 'tabs-0');
    }
  });
</script>
