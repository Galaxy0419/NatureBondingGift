<?php

namespace App\Controller;
/**
* @property \App\Model\Table\PhotosTable $Photos
* @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
    */

class CartController extends AppController{

    public function cart()
    {
        $this->viewBuilder()->setLayout('bones'); //uses bones.php in layout folder as the base layout.
        $this->loadModel('Photos'); //loading Photos model to retrieve photo data from the database.
        $photos= $this->Photos->find('all',['contain'=>['Categories']])->toArray();
        /*retrieves all entities (records) from the Photos table and stores in the variable photos.
        Additionally, finds the category details for each Photos record and converts the variable 'photos' to an array.
         */
        $this->set('photos',$photos); //sends the photos variable to the view (home.php) as photos.
    }
}