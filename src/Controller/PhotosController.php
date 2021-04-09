<?php
declare(strict_types=1);

namespace App\Controller;

use Imagick;
use ImagickDraw;
use ImagickException;
use ImagickPixel;
use Psr\Http\Message\UploadedFileInterface;

use App\Model\Entity\Photo;

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
        $this->paginate = ['contain' => ['Categories']];
        $photos = $this->paginate($this->Photos);
        $this->set(compact('photos'));
    }

    /**
     * Save photo entity method
     *
     * @param Photo $photo Photo entity
     * @return null
     */
    private function savePhoto(Photo $photo)
    {
        if ($this->Photos->save($photo)) {
            $this->Flash->success(__('The photo has been saved.'));
            return $this->redirect(['action' => 'index']);
        } else {
            $this->Flash->error(__('The file name already exists. Please rename the file first.'));
        }
    }

    /**
     * Detect resolution and watermark photo
     *
     * @param UploadedFileInterface $attachment Attachment uploaded
     * @param Photo $photo Photo entity
     * @return null
     * @throws ImagickException
     */
    private function detectResolutionAndWatermark(UploadedFileInterface $attachment, Photo $photo)
    {
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
        $imagickImg->writeImage(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->file_name);

        $attachment->moveTo(WWW_ROOT . 'img' . DS . ORIGINAL_PHOTO_PATH . DS . $photo->file_name);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     * @throws ImagickException
     */
    public function add()
    {
        $photo = $this->Photos->newEmptyEntity();

        if ($this->request->is('post')) {
            $attachment = $this->request->getUploadedFile('file');
            $requestData = $this->request->getData();
            unset($requestData['file']);
            $requestData['file_name'] = $attachment->getClientFilename();
            $photo = $this->Photos->patchEntity($photo, $requestData);

            if (!$attachment->getError()) {
                if (in_array($attachment->getClientMediaType(), PHOTO_FILE_FORMATS)) {
                    $this->detectResolutionAndWatermark($attachment, $photo);
                    $this->savePhoto($photo);
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
     * @throws ImagickException
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $attachment = $this->request->getUploadedFile('file');
            $err = $attachment->getError();

            $requestData = $this->request->getData();
            unset($requestData['file']);

            if ($err == UPLOAD_ERR_OK) {
                if (in_array($attachment->getClientMediaType(), PHOTO_FILE_FORMATS)) {
                    $oldFileName = $photo->file_name;
                    $requestData['file_name'] = $attachment->getClientFilename();
                    $photo = $this->Photos->patchEntity($photo, $requestData);
                    $this->detectResolutionAndWatermark($attachment, $photo);

                    unlink(WWW_ROOT . 'img' . DS . ORIGINAL_PHOTO_PATH . DS . $oldFileName);
                    unlink(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $oldFileName);

                    $this->savePhoto($photo);
                } else {
                    $this->Flash->error(__('The photo format is not supported. (Supported formats: *.jpeg, *.jpg, *.png)'));
                }
            } else if ($err == UPLOAD_ERR_NO_FILE) {
                $requestData['file_name'] = $photo->file_name;
                $photo = $this->Photos->patchEntity($photo, $requestData);
                $this->savePhoto($photo);
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

        if ($this->Photos->delete($photo)
                && unlink(WWW_ROOT . 'img' . DS . ORIGINAL_PHOTO_PATH . DS . $photo->file_name)
                && unlink(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->file_name)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
