<?php

namespace App\Controller;

/**
 * @property \App\Model\Table\CategoriesTable $Categories
 * @property \App\Model\Table\PhotosTable $Photos
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class LandingController extends AppController
{
    /**
     * Home method
     *
     * @param int|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function home($categoryId = null)
    {
        /* Use bones.php in layout folder as the base layout. */
        $this->viewBuilder()->setLayout('bones');

        /* Load and retrieve all records from the Categories and Photos tables and pass them to the view. */
        $this->loadModel('Categories');
        $categories = $this->Categories->find();
        $this->set(compact('categories'));

        $this->loadModel('Photos');
        $photos = $this->Photos->find('all', ['contain' => ['Categories']])
            ->where(is_null($categoryId) ? [] : ['category_id' => $categoryId]);
        $this->set(compact('photos'));
    }

    /**
     * About method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function about()
    {
        $this->viewBuilder()->setLayout('bones');
    }

    /**
     * Shopping cart method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function cart()
    {
        $this->viewBuilder()->setLayout('bones');
    }
}
