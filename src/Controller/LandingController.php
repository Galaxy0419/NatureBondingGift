<?php

namespace App\Controller;
/**
* @property \App\Model\Table\PhotosTable $Photos
* @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
    */

class LandingController extends AppController{

    public function home()
    {
        $this->viewBuilder()->setLayout('bones');
        $this->loadModel('Photos');
        $photos= $this->Photos->find();
        $this->set('photos',$photos);

    }
}
