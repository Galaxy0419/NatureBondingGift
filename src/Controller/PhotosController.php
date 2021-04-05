<?php
declare(strict_types=1);

namespace App\Controller;

use Imagick;
use ImagickDraw;
use ImagickPixel;

define('PHOTO_FILE_FORMATS', ['image/jpeg', 'image/png']);
/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PhotosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Categories'],
        ];
        $photos = $this->paginate($this->Photos);

        $this->set(compact('photos'));
    }

    /**
     * View method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $photo = $this->Photos->get($id, [
            'contain' => ['Categories'],
        ]);

        $this->set(compact('photo'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws \ImagickException
     */
    public function add()
    {
        $photo = $this->Photos->newEmptyEntity();

        if ($this->request->is('post')) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            $attachment = $this->request->getData('file_name');

            if (!$attachment->getError()) {
                if (in_array($attachment->getClientMediaType(), PHOTO_FILE_FORMATS)) {
                    $clientFileName = $attachment->getClientFilename();
                    $photo->file_name = $clientFileName;

                    $tmpName = $attachment->getStream()->getMetadata('uri');
                    $imagickImg = new Imagick($tmpName);
                    $geo = $imagickImg->getImageGeometry();
                    $photo->res_width = $geo['width'];
                    $photo->res_height = $geo['height'];

                    $drawSettings = new ImagickDraw();
                    $drawSettings->setFillColor(new ImagickPixel('white'));
                    $drawSettings->setFillOpacity(0.25);
                    $drawSettings->setFontSize(($geo['width'] + $geo['height']) >> 4);
                    $drawSettings->setGravity(Imagick::GRAVITY_CENTER);
                    $imagickImg->annotateImage($drawSettings, 0, 0,
                        rad2deg(atan($geo['height'] / $geo['width'])), 'Nature\'s Bonding Gift');
                    $imagickImg->writeImage(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $clientFileName);

                    $attachment->moveTo(WWW_ROOT . 'img' . DS . ORIGINAL_PHOTO_PATH . DS . $clientFileName);

                    if ($this->Photos->save($photo)) {
                        $this->Flash->success(__('The photo has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('The file name already exists. Please rename the file first.'));
                    }
                } else {
                    $this->Flash->error(__('The photo format is not supported. (Supported formats: *.jpeg, *.jpg, *.png)'));
                }
            } else {
                $this->Flash->error(__('The photo could not be uploaded. Please try again.'));
            }
        }

        $categories = $this->Photos->Categories->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'categories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     * @throws \ImagickException
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            $attachment = $this->request->getData('file_name');

            if (!$attachment->getError()) {
                if (in_array($attachment->getClientMediaType(), PHOTO_FILE_FORMATS)) {
                    $clientFileName = $attachment->getClientFilename();
                    $photo->file_name = $clientFileName;

                    $tmpName = $attachment->getStream()->getMetadata('uri');
                    $imagickImg = new Imagick($tmpName);
                    $geo = $imagickImg->getImageGeometry();
                    $photo->res_width = $geo['width'];
                    $photo->res_height = $geo['height'];

                    $drawSettings = new ImagickDraw();
                    $drawSettings->setFillColor(new ImagickPixel('white'));
                    $drawSettings->setFillOpacity(0.25);
                    $drawSettings->setFontSize(($geo['width'] + $geo['height']) >> 4);
                    $drawSettings->setGravity(Imagick::GRAVITY_CENTER);
                    $imagickImg->annotateImage($drawSettings, 0, 0,
                        rad2deg(atan($geo['height'] / $geo['width'])), 'Nature\'s Bonding Gift');
                    $imagickImg->writeImage(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $clientFileName);

                    $attachment->moveTo(WWW_ROOT . 'img' . DS . ORIGINAL_PHOTO_PATH . DS . $clientFileName);

                    if ($this->Photos->save($photo)) {
                        $this->Flash->success(__('The photo has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('The file name already exists. Please rename the file first.'));
                    }
                } else {
                    $this->Flash->error(__('The photo format is not supported. (Supported formats: *.jpeg, *.jpg, *.png)'));
                }
            } else {
                $this->Flash->error(__('The photo could not be uploaded. Please try again.'));
            }
        }

        $categories = $this->Photos->Categories->find('list', ['limit' => 200]);
        $this->set(compact('photo', 'categories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);
        if ($this->Photos->delete($photo)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
