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
class ZContest extends ElggFile{
  public function __construct($guid = null){
    parent::__construct($guid);
  }
  public function izap_get_attributes(){
    return $this;
  }

  protected function get_file($media_array , $size = false){ // $size = fasle will return original file contents.
    $location = strtolower(get_class($this));
    if($size){
      $this->setFilename($location.'/'.$media_array['thumbs'][$size]);
    }else{
      $this->setFilename($location.'/'.$media_array['file_name']);
    }
    return $this->grabFile();
  }

  public function izap_grant_edit(){
    if(get_class($this)=='IZAPQuiz'){
      register_plugin_hook('permissions_check', 'object', 'izap_quiz_edit_grant');
    }
  }

  public function izap_revoke_edit(){
    if(get_class($this) == 'IZAPQuiz'){
      $key = array_search('izap_quiz_edit_grant',$CONFIG->hooks['permissions_check']['object']);
      unset($key);
    }
  }


  /**
   *
   * @param <string> $filearray # $_FILES array posted from your form
   * @param <string> $location # location of the file you want to save in. This is with respect to home of the user in file matrix.
   * @param <array> $thumbsarray # Array of thumbs you want to create
   */
  public function izap_upload_generate_thumbs($filearray, $thumbsarray = array('tiny' => '25', 'small' => '40', 'medium' => '100x100', 'large' => '200x200', 'master' => '550x550'), $location=false){
    $location = (!$location)?strtolower(get_class($this)).'/':$location;
    foreach($filearray as $fkey => $fvalue){
      $fieldname = $fkey;
      $original_name = $fvalue['name'];
      $type = $fvalue['type'];
    }
    $filename = $this->izap_remove_special_characters($original_name);
    $this->setFilename($location.$filename);
    $this->open('write');
    $this->write(get_uploaded_file($fieldname));
    $this->close();
    $stored_file = $this->getFilenameOnFilestore();
    $array_to_be_stored = array('file_name' => $filename,'file_type'=>$type);
    if($thumbsarray){
      foreach($thumbsarray as $key => $val){
        $size = preg_split('/[Xx]/', $val);
        $thumb_index = strtolower(is_string($key)?$key:$val);
        $thumb_name = $thumb_index."_".$filename;
        $thumbnail = get_resized_image_from_existing_file($stored_file,$size[0],($size[1])?$size[1]:$size[0],($size[1])?false:true);
        $this->setFilename($location.$thumb_name);
        if($this->open("write")){
          $this->write($thumbnail);
          $thumbs[$thumb_index] = $thumb_name;
        }
        $this->close();
      }
      $array_to_be_stored['thumbs'] = $thumbs;
    }
    $this->$fieldname = serialize($array_to_be_stored);
  }


  public function izap_debug_entity($guid){
    $sql = "SELECT * FROM  my_metastrings ms,
            (SELECT md.value_id, md.name_id, md.access_id FROM my_entities me ,
              my_entity_subtypes mes, my_metadata md where me.subtype=mes.id
            AND me.guid = '".$guid."'
            AND mes.subtype='".strtolower(get_class($this))."'
            AND md.entity_guid = me.guid) tm where ms.id = tm.value_id or ms.id = tm.name_id
            ORDER by name_id;";
    return get_data($sql);
  }
 

/**
 *
 * @param <array> $fn_array, Array of all related media
 * @param <string> $location of the file you want to delete from
 * @return <boolean> true on success 
 */

  public function izap_delete_files($fn_array, $location = false){
    $location = (!$location)?strtolower(get_class($this)).'/':$location;
    if(count($fn_array['thumbs'])){
      foreach($fn_array['thumbs'] as $thmbkey => $thmbname){
      $this->setFilename($location.'/'.$thmbname);
      $success = (is_file($this->getFilenameOnFilestore()))?@unlink($this->getFilenameOnFilestore()):true;
      if(!$success){
        return false;
      }
    }     
  }
  $this->setFilename($location.'/'.$fn_array['file_name']);
  return (is_file($this->getFilenameOnFilestore()))?@unlink($this->getFilenameOnFilestore()):true;
}
  

/**
 *
 * @param <string> $attrib_name name to be clear
 * @return <string> Remove all special characters
 */
  private function izap_remove_special_characters($attr_name){
    $new_name = preg_replace("/[^a-zA-Z0-9\.]+/","_",strtolower(trim($attr_name)));
    $new_name = strlen($new_name)>20?substr($new_name, -20):$new_name;
		return time().'_'.$new_name;
  }

  
}
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
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
function izap_qcontest_form($mainArray, $action, $formValues, $langkey = '', $postArray = 'izap', $requiredMark = '*', $reurnForm = TRUE, $formId = 'izapForm'){
  global $CONFIG;

  // create the fields fromt the array
  foreach ($mainArray as $name => $values) {
    // creats the fields
    $form .= izap_qcontest_field($name, $values, $formValues->$name, $labelText, $postArray, $requiredMark);
  }

  // if we want to return the complete form
  if($reurnForm){
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
function izap_array_to_object($attr){
  if(is_object($attr)){
    return $attr;
  }elseif(!is_array($attr)){
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
function izap_qcontest_field($name, $options, $formValues, $labelText = '', $postArray = 'izap', $requiredMark = '*'){
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
  if($options['type'] == 'hidden'){
    $final = $tmpField;
  }else{
    $final = sprintf($label, $tmpField);
  }

return $final;
}



function zp($attr){
    echo  "<pre>";
    print_r($attr);
    echo "</pre>";
}
