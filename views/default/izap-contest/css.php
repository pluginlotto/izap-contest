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

.quizWrapper{
-moz-background-clip:border;
-moz-background-inline-policy:continuous;
-moz-background-origin:padding;
-moz-border-radius-bottomleft:8px;
-moz-border-radius-bottomright:8px;
-moz-border-radius-topleft:8px;
-moz-border-radius-topright:8px;
background:#DEDEDE none repeat scroll 0 0;
margin:0 0 10px;
padding:10px;
}

.challengeWrapper{
-moz-background-clip:border;
-moz-background-inline-policy:continuous;
-moz-background-origin:padding;
-moz-border-radius-bottomleft:8px;
-moz-border-radius-bottomright:8px;
-moz-border-radius-topleft:8px;
-moz-border-radius-topright:8px;
background:white none repeat scroll 0 0;
margin:0 10px 10px;
padding:10px;
}

.izapRadio{
font-size: 0.8em;
font-weight: normal;
}

.image_view{
float: left;
border: 1px solid #000;
margin-right: 10px;
}

.audio_view{
border: 1px solid #000;
margin-right: 10px;
}

.options_view{
}




#zcontest_block_submenu {
	padding: 0;
margin: 0;
}
#zcontest_block_submenu ul {
	padding: 0;
	margin: 0;
}

#zcontest_block_submenu ul li{
display: inline;
}

#zcontest_block_submenu ul li a {
	text-decoration: none;
	margin: 2px 0 0 0;
	color:#4690d6;
	padding:4px 6px 4px 6px;
	font-weight: bold;
	line-height: 1.1em;
	-webkit-border-radius: 10px;
	-moz-border-radius: 10px;
}
#zcontest_block_submenu ul li a:hover {
	color:white;
	background: #0054a7;
}
.izap-notice{
color: red;
margin:0 0 0 5px;
padding:0;
font-style:italic;
font-size: 0.9em;
}

.challenge-icon {
	float:left;
	margin:0 10px 0 0;
}

.result_title_bar{

}
.result_title{
float:left;
margin:2px;
padding:2px;
font-weight:bold;
}
.correct_answer{
background-color: #E6EFB9; 
}
.wrong_answer{
background-color: #FF8D98;
}
.un_completed{
color: #FF0000;
}
.completed{
color: #02A402;
}
.progress_bar_wrapper{
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
background:none repeat scroll 0 0 #DEDEDE;
margin:0 10px 10px;
padding:10px;
}
.progress_bar{
-webkit-border-radius: 8px;
-moz-border-radius: 8px;
height:2px;
}

#group_stats {
	width:190px;
	background: #e9e9e9;
	padding:5px;
	margin:10px 0 20px 0;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
}
#group_stats p {
	margin:0;
}

#groups_info_column_right {
	float:left;
	width:230px;
	margin:0 0 0 10px;
}

.river_object_izapchallenge_created{
background: url("<?php echo func_get_www_path_byizap(array('plugin' => 'izap-contest', 'type' => 'graphics')); ?>river_post.png") no-repeat scroll left -1px transparent;
}

.river_object_izapchallenge_updated{
background: url("<?php echo func_get_www_path_byizap(array('plugin' => 'izap-contest', 'type' => 'graphics')); ?>river_post.png") no-repeat scroll left -1px transparent;
}

.river_object_izapchallenge_comment{
background: url("<?php echo func_get_www_path_byizap(array('plugin' => 'izap-contest', 'type' => 'graphics')); ?>river_icon_comment.gif") no-repeat scroll left -1px transparent;
}
