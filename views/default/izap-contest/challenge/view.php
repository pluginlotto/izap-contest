<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php
if(!get_input('view_as_challenger', FALSE) && $vars['challenge_entity']->owner_guid == get_loggedin_userid()){
  include(dirname(__FILE__)."/owner_view.php");
}else{
  include(dirname(__FILE__)."/challenger_view.php");
}
?>