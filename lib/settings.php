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


global $CONFIG;
return array(
        'plugin'=>array(
                'name'=>"izap-contest",
                'version' => '1.0',
                'title'=>"Contests",

                'url_title'=>"",

                'objects'=>array(

                        'izapchallenge'=>array(
                                'getUrl'=>"izap_zcontest_challenge_url",
                                'class'=>"IZAPChallenge",
                                'type' => 'object',
                        ),

                        'izapquiz'=>array(
                                'getUrl'=>"izap_zcontest_quiz_url",
                                'class'=>"IZAPQuiz",
                                'type' => 'object',
                        ),

                        'izap_challenge_results'=>array(
                                'getUrl'=>"izap_challenge_results_url",
                                'type' => 'object',
                                'searchable' => FALSE,
                        ),
                  
                ),

                'hooks'=>array(
                        'entity:icon:url' =>  array('object' => array('izap_challenge_icon_url')),
                        ''
                ),

                'actions'=>array(
                        'zcontest/settings'=>array('file' => "settings.php",'public'=>false),
                        'quiz/save'=>array('file' => "quiz/save.php",'public'=>false),
                        'challenge/save'=>array('file' => "challenge/save.php",'public'=>false),
                        'challenge/delete'=>array('file' => "challenge/delete.php",'public'=>false),
                        'quiz/delete'=>array('file' => "quiz/delete.php",'public'=>false),
                        'quiz/answer'=>array('file' => "quiz/answer.php",'public'=>false),
                        'challenge/lock'=>array('file' => "challenge/lock.php",'public'=>false),
                        'challenge/accept'=>array('file' => "challenge/accept.php",'public'=>false),
                        'challenge/challenge_friends'=>array('file' => "challenge/challenge_friends.php",'public'=>false),

                ),

                'page_handler'=>array(
                        'challenge'=>'izap_zcontest_page_handler',
                        'contest'=>'izap_zcontest_page_handler',
                        'quiz'=>'izap_zcontest_page_handler',
                ),

                'menu'=>array(
                        'pg/challenge/list/' . $_SESSION['user']->username . '/' =>array('title'=>"zcontest:contests",'public'=>false),
                ),

                'submenu'=>array(
                        'challenge' => array(
                                'pg/challenge/list/all/'=>array('title'=>"zcontest:challenge:all",'public'=>true),
                                'pg/challenge/new/'=>array('title'=>"zcontest:challenge:add",'public'=>false),
                                'pg/challenge/accepted/[PAGE_OWNER_USERNAME]/' => array(
                                        'title' => 'zcontest:challenge:accepted',
                                        'public' => FALSE,
                                ),
                                'pg/challenge/list/' . $_SESSION['user']->username . '/' =>array('title'=>sprintf(elgg_echo("zcontest:chellenge:list"),"My"),'public'=>false),
                                'pg/challenge/list/[PAGE_OWNER_USERNAME]/' =>array('title'=>sprintf(elgg_echo("zcontest:chellenge:list"), "[PAGE_OWNER_USERNAME]'s"),'public'=>true),
                        ),

                        'quiz' => array(
                                'pg/challenge/list/all/'=>array('title'=>"zcontest:challenge:all",'public'=>true),
                                'pg/challenge/new/'=>array('title'=>"zcontest:challenge:add",'public'=>false),
                                'pg/challenge/accepted/[PAGE_OWNER_USERNAME]/' => array(
                                        'title' => 'zcontest:challenge:accepted',
                                        'public' => FALSE,
                                ),
                                'pg/challenge/list/' . $_SESSION['user']->username . '/' =>array('title'=>sprintf(elgg_echo("zcontest:chellenge:list"),"My"),'public'=>false),
                                'pg/challenge/list/[PAGE_OWNER_USERNAME]/' =>array('title'=>sprintf(elgg_echo("zcontest:chellenge:list"),"[PAGE_OWNER_USERNAME]'s"),'public'=>false),
                        ),

//                        'admin' => array(
//                                'mod/zcontest/pages/admin.php'=>array('title'=>"zcontest:administration",'admin_only'=>false),
//                        ),
                ),


        ),

        'includes'=>array(
                dirname(__FILE__) => array('qcontest.php', 'challenge.php', 'quiz.php'),
        ),

        'path'=>array(
                'www'=>array(
                        'page' => $CONFIG->wwwroot . 'pg/contest/',
                        'action' => $CONFIG->wwwroot . 'action/izap-contest/',
                        'graphics' => $CONFIG->wwwroot . 'mod/izap-contest/graphics/',
                ),
                'dir'=>array(
                        'plugin'=>dirname(dirname(__FILE__))."/",
                        'actions'=>$CONFIG->pluginspath."izap-contest/actions/",
                        'lib' => dirname(__FILE__) . '/',
                        'views'=>array(
                                'home'=>"izap-contest/",
                                'challenge' => 'izap-contest/challenge/',
                                'quiz' => 'izap-contest/quiz/',
                        ),
                        'pages'=>dirname(dirname(__FILE__)).'/pages/',
                ),
        ),
);