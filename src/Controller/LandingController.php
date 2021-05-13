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
     * @param int|null $categoryId Category id.
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
     * Add to shopping cart method
     *
     * @param int $photoId Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function addToCart($photoId)
    {
        $cart = $this->request->getSession()->read('cart');

        if (is_array($cart)) {
            if (in_array(intval($photoId), $cart)) {
                $this->Flash->error('The photo is already in the cart!');
            } else {
                array_push($cart, intval($photoId));
                $this->request->getSession()->write('cart', $cart);
                $this->Flash->success('The photo has been added to the shopping cart!');
            }
        } else {
            $this->request->getSession()->delete('cart');
            $this->request->getSession()->write('cart', [intval($photoId)]);
            $this->Flash->success('The photo has been added to the shopping cart!');
        }

        $this->redirect(['action' => 'home']);
    }

    /**
     * Shopping cart method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function cart()
    {
        $this->viewBuilder()->setLayout('bones');

        $cart = $this->request->getSession()->read('cart');
        $this->loadModel('Photos');
        $photos = is_null($cart) || count($cart) == 0 ? [] : $this->Photos->find()->where(['id IN' => $cart]);
        $this->set(compact('photos'));
    }

    /**
     * Remove a photo from shopping cart method
     *
     * @param int $photoId Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function removePhotoFromCart($photoId)
    {
        $cart = $this->request->getSession()->read('cart');
        $this->request->getSession()->write('cart', array_diff($cart, [$photoId]));
        $this->redirect(['action' => 'cart']);
    }

    /**
     * Clear shopping cart method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function clearCart()
    {
        $this->request->getSession()->delete('cart');
        $this->redirect(['action' => 'cart']);
    }
}
