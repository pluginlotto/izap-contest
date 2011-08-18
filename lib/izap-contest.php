<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */



/**
 * it creates the form, from the provided array
 *
 * @global GLOBAL $CONFIG
 * @param array $mainArray main form array
 * @param string $action form action
 * @param object $formValues values for the elements
 * @param string $langkey initial label string from language file
 * @param string $postArray array name for posting elements
 * @param char $requiredMark anything which will attach with the require fields
 * @param boolean $reurnForm is we want the form back
 * @param string $formId form id
 * @return html
 */
function izap_qcontest_form($mainArray, $action, $formValues, $langkey = '', $postArray = 'izap', $requiredMark = '*', $reurnForm = TRUE, $formId = 'izapForm') {
  global $CONFIG;

  // create the fields fromt the array
  foreach ($mainArray as $name => $values) {
    // creats the fields
    $form .= izap_qcontest_field($name, $values, $formValues->$name, $labelText, $postArray, $requiredMark);
  }

  // if we want to return the complete form
  if($reurnForm) {
    // submit  buttom
    $form .= elgg_view('input/submit', array(
            'value' => elgg_echo($labelText . 'save'),
            'js' => 'id="butnSubmit_"' .$formId. '',
            )
    );

    // all form
    $form = elgg_view('input/form', array(
            'body' => $form,
            'action' => $CONFIG->wwwroot . 'action/' . $action,
            'enctype' => 'multipart/form-data',
            'internalid' => $formId,
            )
    );
  }

  return $form;
}

/**
 * this converts the array into object
 *
 * @param array $array
 * @return object
 */
function izap_array_to_object($attr) {
  if(is_object($attr)) {
    return $attr;
  }elseif(!is_array($attr)) {
    return false;
  }

  $obj = new stdClass();
  foreach ($attr as $key => $value) {
    $obj->$key = $value;
  }
  return $obj;
}

/**
 * this function acutally creats the input fields
 *
 * @param string $name name for the input field
 * @param array $options all the required parameters
 * @param array $formValues initial values for the fields
 * @param string $labelText starting text for the label
 * @param string $postArray array name
 * @param string $requiredMark sign for the compusory fields
 * @return html full input fields
 */
function izap_qcontest_field($name, $options, $formValues, $labelText = '', $postArray = 'izap', $requiredMark = '*') {
  $requiredText = ($options['required']) ? $requiredMark : '';
  $label = '<p><label>'.elgg_echo($labelText . $name) . ' ' . $requiredText .'<br />%s</label></p>';

  $tmpField = elgg_view('input/' . $options['type'], array(
          'internalname' => $postArray. '[' . $name . ']' . $makeArray,
          'internalid' => $options['internalid'],
          'value' => ($formValues == '') ? $options['value'] : $formValues,
          'options' => $options['options'],
          'options_values' => $options['options_values'],
          'js' => $options['js'],
          'class' => $options['class'],
          'disabled' => $options['disabled'],
          'hidden' => $options['hidden'],
          'noEditer' => $options['noEditer'],
          )
  );

  // if hidden field then lables are not needed
  if($options['type'] == 'hidden') {
    $final = $tmpField;
  }else {
    $final = sprintf($label, $tmpField);
  }

  return $final;
}



function zp($attr) {
  echo  "<pre>";
  print_r($attr);
  echo "</pre>";
}


function izap_process_uncompleted_challenge($page) {
  global $CONFIG;
  $context = get_context();
  // if user is not on the play page
  if(!($context == 'challenge' && ($page == 'play' || $page == 'result'))) {
    // if user have left play page, the declare his/her result
    if((int)$_SESSION['challenge']['contest'] > 0) {
      $challenge = new IzapChallenge($_SESSION['challenge']['contest']);
      $result = $challenge->save_results(FALSE);
      forward($CONFIG->wwwroot . 'pg/challenge/result/' . $challenge->guid . '/' . $result->guid . '/');
    }
  }

}