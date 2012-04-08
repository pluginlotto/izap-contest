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

class ZContest extends IzapObject {

  public function __construct($guid = null) {
    parent::__construct($guid);
  }

  protected function initialiseAttributes() {
    parent::initializeAttributes();
  }

  public function izap_get_attributes() {
    return $this;
  }

  /**
   * returns the file of related_media
   * @param   <type>  $media_array
   * @param   <type>  $size
   * 
   * @return  <type>
   */
  protected function get_file($media_array, $size = false) { // $size = fasle will return original file contents.
    $location = strtolower(get_class($this));
    if ($size) {
      $this->setFilename($location . '/' . $media_array['thumbs'][$size]);
    } else {
      $this->setFilename($location . '/' . $media_array['file_name']);
    }
    return $this->grabFile();
  }

  /**
   * gives the permission to edit the quiz
   */
  public function izap_grant_edit() {
    if (get_class($this) == 'IzapQuiz') {
      register_plugin_hook('permissions_check', 'object', 'izap_quiz_edit_grant');
    }
  }

  /**
   * revokes the permission for editing the quiz
   *
   */
  public function izap_revoke_edit() {
    if (get_class($this) == 'IzapQuiz') {
      $key = array_search('izap_quiz_edit_grant', $CONFIG->hooks['permissions_check']['object']);
      unset($key);
    }
  }

  /**
   *
   * @param <string> $filearray    # $_FILES array posted from your form
   * @param <string> $location     # location of the file you want to save in. This is with respect to home of the user in file matrix.
   * @param <array>  $thumbsarray  # Array of thumbs you want to create
   */
  public function izap_upload_generate_thumbs($filearray, $thumbsarray = array('tiny' => '25', 'small' => '40', 'medium' => '100x100', 'large' => '200x200', 'master' => '550x550'), $location=false) {
    $location = (!$location) ? strtolower(get_class($this)) . '/' : $location;
    foreach ($filearray as $fkey => $fvalue) {
      $fieldname = $fkey;
      $original_name = $fvalue['name'];
      $type = $fvalue['type'];
    }
    $filename = $this->izap_remove_special_characters($original_name);
    $this->setFilename($location . $filename);
    $this->open('write');
    $this->write(get_uploaded_file($fieldname));
    $this->close();
    $stored_file = $this->getFilenameOnFilestore();
    $array_to_be_stored = array('file_name' => $filename, 'file_type' => $type);
    if ($thumbsarray) {
      foreach ($thumbsarray as $key => $val) {
        $size = preg_split('/[Xx]/', $val);
        $thumb_index = strtolower(is_string($key) ? $key : $val);
        $thumb_name = $thumb_index . "_" . $filename;
        $thumbnail = get_resized_image_from_existing_file($stored_file, $size[0], ($size[1]) ? $size[1] : $size[0], ($size[1]) ? false : true);
        $this->setFilename($location . $thumb_name);
        if ($this->open("write")) {
          $this->write($thumbnail);
          $thumbs[$thumb_index] = $thumb_name;
        }
        $this->close();
      }
      $array_to_be_stored['thumbs'] = $thumbs;
    }
    $this->$fieldname = serialize($array_to_be_stored);
  }

  /**
   *
   * @param   <array> $fn_array, Array of all related media
   * @param   <string> $location of the file you want to delete from
   * 
   * @return  <boolean> true on success
   */
  public function izap_delete_files($fn_array, $location = false) {
    $location = (!$location) ? strtolower(get_class($this)) . '/' : $location;
    if (count($fn_array['thumbs'])) {
      foreach ($fn_array['thumbs'] as $thmbkey => $thmbname) {
        $this->setFilename($location . '/' . $thmbname);
        $success = (is_file($this->getFilenameOnFilestore())) ? @unlink($this->getFilenameOnFilestore()) : true;
        if (!$success) {
          return false;
        }
      }
    }
    $this->setFilename($location . '/' . $fn_array['file_name']);
    return (is_file($this->getFilenameOnFilestore())) ? @unlink($this->getFilenameOnFilestore()) : true;
  }

  /**
   *
   * @param    <string>  $attrib_name name to be clear
   *
   *  @return  <string>  Remove all special characters
   */
  private function izap_remove_special_characters($attr_name) {
    $new_name = preg_replace("/[^a-zA-Z0-9\.]+/", "_", strtolower(trim($attr_name)));
    $new_name = strlen($new_name) > 20 ? substr($new_name, -20) : $new_name;
    return time() . '_' . $new_name;
  }

}
