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

?>
<?php
if(!get_input('view_as_challenger', FALSE) && $vars['challenge_entity']->owner_guid == get_loggedin_userid()){
  include(dirname(__FILE__)."/owner_view.php");
}else{
  include(dirname(__FILE__)."/challenger_view.php");
}
?>