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

// this is the page that starts the timer of the challenge
$challenge = $vars['challenge'];
$left_time = $vars['left_time'];
if (isset($vars['redirect']) && $vars['redirect'] != '') {
  $timeout_action = 'window.location.href ="' . $vars['redirect'] . '"';
}
?>
<script type="text/javascript">
  var startTime;
  function display_c(start){

    startTime= parseFloat(start);
    var end = 0 // change this to stop the counter at a higher value
    var refresh=1000; // Refresh rate in milli seconds
    if(startTime >= end ){
      mytime=setTimeout('display_ct()',refresh)
    }
    else {
<?php echo $timeout_action; ?>;
    }
  }

  function display_ct() {

    // Calculate the number of days left
    var days=Math.floor(startTime / 86400);

    // After deducting the days calculate the number of hours left
    var hours = Math.floor((startTime - (days * 86400 ))/3600)
    // After days and hours , how many minutes are left
    var minutes = Math.floor((startTime - (days * 86400 ) - (hours *3600 ))/60)
    // Finally how many seconds left after removing days, hours and minutes.
    var secs = Math.floor((startTime - (days * 86400 ) - (hours *3600 ) - (minutes*60)))

    var x =  (days>0 ?days + " Days ":'') + (hours>0? hours + " Hours ":'')  + (minutes>0?minutes + " Minutes ":'')  + secs + " Seconds ";



    document.getElementById('ct').innerHTML = x;
    startTime= startTime- 1;

    tt=display_c(startTime);
  }
  $(document).ready(function(){

    display_c(<?php echo $left_time ?>);
  });
</script>
<div class="<?php echo $vars['class'] ?>">
  <b><span id="ct"></span></b>
</div>