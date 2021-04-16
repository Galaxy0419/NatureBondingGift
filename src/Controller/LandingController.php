<?php

namespace App\Controller;
/**
* @property \App\Model\Table\PhotosTable $Photos
* @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
    */

class LandingController extends AppController{

    public function home()
    {
        $this->viewBuilder()->setLayout('bones'); //uses bones.php in layout folder as the base layout.
        $this->loadModel('Photos'); //loading Photos model to retrieve photo data from the database.
        $photos= $this->Photos->find(); //retrieves all entities (records) from the Photos table and stores in the variable photos.
        $this->set('photos',$photos); //sends the photos variable to the view (home.php) as photos.

    }
}
