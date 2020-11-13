<?php

function clean_up(){
  $path = drupal_get_path('module', 'prison_list');

  foreach (scandir($path.'/config/install', 1) as $file){
    if ($file != "." && $file != "..") {
      $config_id = substr($file, 0, -4);
      \Drupal::messenger()->addMessage("File: ".$file);
      \Drupal::logger('my_module')->notice("Working on file: ".$file);
// Logs an error
      $raw_data = file_get_contents($path.'/config/install/'.$file);
      Drupal::configFactory()->reset($config_id);
      Drupal::configFactory()->getEditable($config_id)->delete();

//      \Drupal::configFactory()->getEditable($config_id)
//        ->setData(Yaml::decode($raw_data))
//        ->save();
    }
  }
}

clean_up();
