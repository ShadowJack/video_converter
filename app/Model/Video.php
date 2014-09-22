<?php 
class Video extends AppModel {
  public $actsAs = array(
    'Upload.Upload' => array(
      'fields' => array(
        'FLV' => 'videos/:id'
      )
    )
  );
  
  public $validate = array(
    'FLV_file' => array(
      'rule' => array('fileExtension', array('flv'))
    )
  );
  
}