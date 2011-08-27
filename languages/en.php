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
add_translation('en', array(
    'item:object:izap_challenge_results' => 'Challenge results',
    'izapchallenge:river:annotate' => 'comment',
    /**
     * Menu items and titles
     */
    'izap-contest:title' => 'Title',
    'izap-contest:description' => 'Description',
    'izap-contest:terms' => 'Terms & Conditions',
    'izap-contest:quiz' => "Quiz: %s ?",
    'izap-contest:contests' => 'Contests',
    'izap-contest:contest' => "Contest",
    'izap-contest:quiz:my' => "My quizzes",
    'izap-contest:quiz:all' => "All site quizzes",
    'item:object:izapquiz' => "Quizzes",
    'izap-contest:administration' => "Contest management",
    'izap-contest:quiz:create' => "New quiz",
    'izap-contest:quiz:userlist' => 'My quizzes',
    'izap-contest:quiz:add' => 'Add new quiz',
    'izap-contest:quiz:title' => 'Question',
    'izap-contest:quiz:option' => 'Available option',
    'izap-contest:quiz:description' => 'Description',
    'izap-contest:quiz:solution' => 'Solution',
    'izap-contest:quiz:edit' => 'Edit quiz',
    'izap-contest:quiz:correct' => 'Correct option',
    'izap-contest:quiz:audio' => 'Upload audio file (mp3)',
    'izap-contest:quiz:video' => 'Upload video file(mp4, mpeg, avi, wma)',
    'izap-contest:quiz:image' => 'Upload image (jpg, png, gif)',
    'izap-contest:quiz:deleted' => 'Quiz is deleted successfully',
    'izap-contest:quiz:notdeleted' => 'Sorry! couldn\'t delete quiz.',
    'izap-contest:quiz:delete' => 'Delete quiz',
    'izap-contest:quiz:answer' => 'Answer',
    'izap-contest:quiz:skip' => 'Skip',
    'izap-contest:quiz:error:no_options' => 'No options provided or no correct answer specified',
    'izap-contest:quiz:form_error:empty:title' => 'Please provide quesiton',
    'izap-contest:challenge:not_played' => 'You have not taken this challenge yet',
    'izap-contest:off' => 'Off',
    'izap-contest:on' => 'On',
    'izap-contest:comments' => 'Comments',
    'izap-contest:form_error:empty:title' =>'Please provide the challenge name.',
    'izap-contest:form_error:empty:required_correct' =>'Please provide the required percentage to pass the challenge.',

    
    'item:object:izapchallenge' => 'Challenges',
    'izap-contest:challenge' => 'Challenge: %s',
    'izap-contest:challenge:challenge_friend' => 'Challenge friends',
    'izap-contest:challenge:edit' => 'Edit challenge',
    'izap-contest:challenge:add' => 'Add new challenge',
    'izap-contest:chellenge:userlist' => 'My challenges',
    'izap-contest:user' => 'Contests of %s',
    'izap-contest:notfound' => 'No contest found',
    'izap-contest:challenge:all' => 'All site challenges',
    'izap-contest:challenge:my' => 'My challenges',
    'izap-contest:chellenge:list' => '%s challenges',
    'izap-contest:challenge:delete' => 'Delete challenge',
    'izap-contest:challenge:notdeleted' => 'Sorry! couldn\'t delete challenge.',
    'izap-contest:challenge:deleted' => 'Challenge deleted successfully.',
    'izap-contest:challenge:media' => 'Image',
    'izap-contest:challenge:reqcorrect' => 'Required to be correct (%)',
    'izap-contest:challenge:maxquizzes' => 'Minimum random quizzes to offer (minimum of 2 or just leave blank)',
    'izap-contest:challenge:reattempt' => 'Enable re-attempt after 48hrs.',
    'izap-contest:challenge:coundreanswer' => 'Could edit once answered',
    'izap-contest:challenge:negativemarking' => 'Enable negative marking',
    'izap-contest:challenge:timer' => 'Timer (in minutes)',
    'izap-contest:challenge:timer:notice' => 'Leave blank to keep it unlimited.',
    'izap-contest:challenge:accepted' => 'Accepted challenges',
    'izap-contest:challenge:not_accepted_yet' => 'You have not accepted this challenge yet.',
    'izap-contest:challenge:result' => 'Result',
    'izap-contest:challenge:challenge_friends' => 'Challenge friends',
    'izap-contest:challenge_invitation' => 'You have been challenged',
    'izap-contest:challenge_inivitation_message' => '%s has challenged. To accept the challenge visit: %s',
    'izap-contest:challenge:not_completed' => 'Challenge not completed.',
    'izap-contest:challenge:completed' => 'Challenge completed.',
    'izap-contest:challenge:take_now' => 'Take challenge now',
    'izap-contest:challenge:my_results' => 'My results',
    'izap-contest:challenge:time_used' => 'Total time used: %s seconds',
    'izap-contest:challenge:time_used_minute' => 'Total time used: %s minutes %s seconds',
    'izap-contest:challenge:total_attempted' => 'Total attempted',
    'izap-contest:challenge:total_passed' => 'Total passed',
    'izap-contest:challenge:your_total_attempted' => 'Your attempts',
    'izap-contest:challenge:your_total_passed' => 'Your passed',
    'izap-contest:challenge:marks' => 'Marks',
    'izap-contest:challenge:next_attempt' => 'Next attempt in ',
    'izap-contest:challenge:last_attempt' => 'Last attempted ',
    'izap-contest:challenge:passing_percentage' => 'Required',
    'izap-contest:challenge:obtained_percentage' => 'Obtained',
    'izap-contest:challenge:successfully_challenged' => 'You have successfully challenged your friends',
    
    
    'izap-contest:challenge:not_enough_questions' => 'Users will not be able to take the challenge, as
    minimum number of required quiz are not provided. Or you can edit the Challenge. <b>Minimum required
    quizzes: ',
    'izap-contest:challenge:view_as_challenger' => 'Preview challenge',
    'izap-contest:challenge:error:timeout' => 'Time out. You have exceded the maximum time limit',
    'river:created:object:izapchallenge' => '%s has added new challenge %s',
    'river:updated:object:izapchallenge' => '%s has updated challenge %s',
    'izap-contest:challenge:owner' => 'Owner',
    'izap-contest:challenge:must_answer' => 'Must answer',
    'izap-contest:challenge:total_quiz' => 'Total quizzes',
    'izap-contest:challenge:max_time_in_min' => 'Maximum time in minutes',
    'izap-contest:challenge:can_re_attempt' => 'You can re-attempte the quiz after 48 hrs.',
    'izap-contest:challenge:cant_re_attempt' => 'You can not re-attempte the quiz.',
    'izap-contest:challenge:negative_marking' => 'Negative marking is applicable.',
    'izap-contest:challenge:no_negative_markting' => 'No negative marking.',
    'izap-contest:challenge:all_questions' => 'All questions',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:challenge:' => '',
    'izap-contest:result:id' => 'Result id',
    'izap-contest:result:time' => 'Time',
    'izap-contest:result:score' => 'Total score',
    'izap-contest:result:percentage' => 'Marks',
    'izap-contest:result:status' => 'Status',
    'izap-contest:result:' => '',
    'izap-contest:result:question' => 'Question',
    'izap-contest:result:correct_answer' => 'Correct answer',
    'izap-contest:result:your_answer' => 'Your answer',
    'izap-contest:result:status' => 'Status',
    'izap-contest:result:total' => 'Total score',
    // CHALLENGE group
    'izap-contest:challenge:group:enable' => 'Enable Challenge for Groups',
    'izap-contest:challenge:group:add' => 'Add Group Challenge',
    'izap-contest:challenge:group:list' => 'Group Challenges',
    'izap-contest:challenge:group:list:all' => 'All group Challenges',

    //send to friend

    'izap-contest:your_name' => 'Your name *',
    'izap-contest:your_email' =>'Your email *',
    'izap-contest:your_friend_name' =>"Your friend's name *",
    'izap-contest:your_friend_email' =>"Your friend's email *",
    'izap-contest:message' => 'Message *',
    'izap-contest:not_valid_email' => 'The email is not valid',
    'izap-contest:not_valid_entity' => 'Error loading entity',
    'izap-contest:success_send_to_friend' => 'Mail sent successfully',
    'izap-contest:error_send_to_friend' => 'Unable to send your mail right now, Server might be busy. Please try after some time.',

));
