<?php

namespace App\Controller;

use App\Model\Table\CategoriesTable;
use App\Model\Table\PhotosTable;
use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

/**
 * @property AuthenticationComponent Authentication
 * @property AuthorizationComponent Authorization
 * @property CategoriesTable $Categories
 * @property PhotosTable $Photos
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class LandingController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->setConfig(['requireIdentity' => false]);
        $this->Authorization->skipAuthorization();
        $this->viewBuilder()->setLayout('bones');
    }

    /**
     * Home method
     *
     * @param int|null $categoryId Category id.
     * @return void Renders view
     * @throws RecordNotFoundException When record not found.
     */
    public function home($categoryId = null)
    {
        $this->loadModel('Categories');
        $categories = $this->Categories->find();
        $this->set(compact('categories'));

        $this->loadModel('Photos');
        $photos = $this->paginate($this->Photos->find('all', ['contain' => ['Categories']])
            ->where($categoryId === null ? [] : ['category_id' => $categoryId]), ['limit' => 32, 'maxLimit' => 32]);
        $this->set(compact('photos'));

        $this->viewBuilder()->setOption('serialize', ['photos']);
    }

    /**
     * About method
     *
     * @return void Renders view
     */
    public function about()
    {
    }

    /**
     * Add to shopping cart method
     *
     * @param int $photoId Photo id.
     * @return Response Response json
     */
    public function addToCart($photoId)
    {
        $this->autoRender = false;
        $cart = $this->request->getSession()->read('cart');

        if (is_array($cart)) {
            if (in_array(intval($photoId), $cart)) {
                return $this->response->withStringBody(json_encode(['ok' => false]));
            } else {
                array_push($cart, intval($photoId));
                $this->request->getSession()->write('cart', $cart);
            }
        } else {
            $this->request->getSession()->delete('cart');
            $this->request->getSession()->write('cart', [intval($photoId)]);
        }

        return $this->response->withStringBody(json_encode(['ok' => true]));
    }

    /**
     * Sum total method
     *
     * @return float total price of the photos
     */
    public function getTotal($photos): float
    {
        $sum = 0.0;
        foreach ($photos as $photo) {
            $sum += is_null($photo->discount_price) ? $photo->price : $photo->discount_price;
        }
        return $sum;
    }

    /**
     * Shopping cart method
     *
     * @return void Renders view
     */
    public function cart()
    {
        $cart = $this->request->getSession()->read('cart');

        $this->loadModel('Photos');
        $photos = is_null($cart) || count($cart) == 0 ? [] : $this->Photos->find()->where(['id IN' => $cart]);
        $this->set(compact('photos'));

        $total = is_null($cart) || count($cart) == 0 ? 0.0 : $this->getTotal($photos);
        $this->set(compact('total'));
    }

    /**
     * Remove a photo from shopping cart method
     *
     * @param int $photoId Photo id.
     * @return Response|null|void Renders view
     */
    public function removeFromCart($photoId)
    {
        $this->autoRender = false;
        $cart = $this->request->getSession()->read('cart');
        $this->request->getSession()->write('cart', array_diff($cart, [$photoId]));
    }

    /**
     * Clear shopping cart method
     *
     * @return void Renders view
     */
    public function clearCart()
    {
        $this->autoRender = false;
        $this->request->getSession()->delete('cart');
    }

    /**
     * Check if transaction is really approved
     *
     * @param $orderId
     * @return Response
     */
    public function onTransactionApproved($orderId): Response
    {
        $this->autoRender = false;

        $request = new OrdersCaptureRequest($orderId);
        $paypalResponse = (new PayPalHttpClient(new SandboxEnvironment(
            "AZoCJH2z26LaucwGZhdZ0Cj9Jr_kYqGpZ98HAEH-C7vCur-VRwUlOlVmzotA7S9dlxZvZ3ADNs_O6S--",
            "ED9L0YtE25y3XIbJh3C5qMDHQ4aE7ourr29ag-ahXUB3AEcE-GwV8Es-89D-7TPLASwNZInRkcx3MvRU")))->execute($request);

        /* Convert Paypal HTTP response to cakephp native response */
        $this->response = $this->response->withStatus($paypalResponse->statusCode);
        unset($paypalResponse->headers['']);
        foreach ($paypalResponse->headers as $key => $value) {
            $this->response = $this->response->withHeader($key, $value);
        }
        $this->response = $this->response->withStringBody(json_encode($paypalResponse->result));

        $this->request->getSession()->delete('cart');

        return $this->response;
    }
}
