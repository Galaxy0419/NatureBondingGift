<?php

namespace App\Controller;

/**
 * @property \App\Model\Table\PhotosTable $Photos
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class LandingController extends AppController
{
    public function home()
    {
        /* Use bones.php in layout folder as the base layout. */
        $this->viewBuilder()->setLayout('bones');
        /* Load Photos model to retrieve photo data from the database. */
        $this->loadModel('Photos');

        /**
         * Retrieve all entities (records) from the Photos table and stores in the variable photos.
         * Additionally, finds the category details for each Photos record and converts the variable 'photos' to an array.
         */
        $photos = $this->Photos->find('all', ['contain' => ['Categories']])->toArray();
        $this->set('photos', $photos);
    }

    public function about()
    {
        $this->viewBuilder()->setLayout('bones'); //uses bones.php in layout folder as the base layout.
    }
}
