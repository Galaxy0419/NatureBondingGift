<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Photo;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Http\Response;
use Exception;
use Imagick;
use ImagickDraw;
use ImagickDrawException;
use ImagickException;
use ImagickPixel;
use Psr\Http\Message\UploadedFileInterface;

define('PHOTO_FILE_FORMATS', ['image/jpeg', 'image/png']);
/**
 * Photos Controller
 *
 * @property AuthorizationComponent Authorization
 * @property \App\Model\Table\PhotosTable $Photos
 * @method \App\Model\Entity\Photo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PhotosController extends AppController
{
    /**
     * Initialize method
     *
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Authorization->skipAuthorization();
    }

    /**
     * Index method
     *
     * @return Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = ['contain' => ['Categories']];
        $photos = $this->paginate($this->Photos);
        $this->set(compact('photos'));
    }

    /**
     * Save photo data and file
     *
     * @param UploadedFileInterface $attachment Attachment uploaded
     * @param Photo $photo Photo entity
     * @return bool
     * @throws ImagickException|ImagickDrawException
     */
    private function savePhoto(UploadedFileInterface $attachment, Photo $photo): bool
    {
        $tmpName = $attachment->getStream()->getMetadata('uri');
        $imagickImg = new Imagick($tmpName);
        $geo = $imagickImg->getImageGeometry();
        $photo->res_width = $geo['width'];
        $photo->res_height = $geo['height'];

        $result = $this->Photos->save($photo);
        if ($result === false) {
            return false;
        }

        $drawSettings = new ImagickDraw();
        $drawSettings->setFillColor(new ImagickPixel('white'));
        $drawSettings->setFillOpacity(0.25);
        $drawSettings->setFontSize(($geo['width'] + $geo['height']) >> 4);
        $drawSettings->setGravity(Imagick::GRAVITY_CENTER);
        $imagickImg->annotateImage($drawSettings, 0, 0,
            rad2deg(atan($geo['height'] / $geo['width'])), 'Nature\'s Bonding Gift');
        $imagickImg->writeImage(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->id);

        $attachment->moveTo(RESOURCES . ORIGINAL_PHOTO_PATH . DS . $photo->id);

        return true;
    }

    /**
     * Add method
     *
     * @return Response|null Redirects on successful add, renders view otherwise.
     * @throws ImagickException
     * @throws ImagickDrawException
     */
    public function add()
    {
        $photo = $this->Photos->newEmptyEntity();

        if ($this->request->is('post')) {
            $attachment = $this->request->getUploadedFile('file');
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());

            if (!$attachment->getError()) {
                if (in_array($attachment->getClientMediaType(), PHOTO_FILE_FORMATS)) {
                    if ($this->savePhoto($attachment, $photo)) {
                        $this->Flash->success(__('The photo has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('File could not be saved. Please review the data you have entered and try again.'));
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
     * @return Response|null Redirects on successful edit, renders view otherwise.
     * @throws RecordNotFoundException When record not found.
     * @throws ImagickException|ImagickDrawException
     */
    public function edit($id = null)
    {
        $photo = $this->Photos->get($id, ['contain' => []]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $photo = $this->Photos->patchEntity($photo, $this->request->getData());
            $attachment = $this->request->getUploadedFile('file');
            $err = $attachment->getError();

            if ($err == UPLOAD_ERR_OK) {
                if (in_array($attachment->getClientMediaType(), PHOTO_FILE_FORMATS)) {
                    if ($this->savePhoto($attachment, $photo)) {
                        $this->Flash->success(__('The photo has been edited.'));
                        return $this->redirect(['action' => 'index']);
                    } else {
                        $this->Flash->error(__('File could not be saved. Please review the data you have entered and try again.'));
                    }
                } else {
                    $this->Flash->error(__('The photo format is not supported. (Supported formats: *.jpeg, *.jpg, *.png)'));
                }
            } else if ($err == UPLOAD_ERR_NO_FILE) {
                if ($this->Photos->save($photo)) {
                    $this->Flash->success(__('The photo has been edited.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $this->Flash->error(__('File could not be saved. Please review the data you have entered and try again.'));
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
     * @return Response|null|void Redirects to index.
     * @throws RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $photo = $this->Photos->get($id);

        if ($this->Photos->delete($photo)
                && unlink(RESOURCES . ORIGINAL_PHOTO_PATH . DS . $photo->id)
                && unlink(WWW_ROOT . 'img' . DS . WATERMARK_PHOTO_PATH . DS . $photo->id)) {
            $this->Flash->success(__('The photo has been deleted.'));
        } else {
            $this->Flash->error(__('The photo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Check if the request is authenticated to get the original photo
     *
     * @param string $fileName
     * @return Response
     */
    public function getOriginalPhoto(string $fileName): Response {
        $this->autoRender = false;
        $this->response = $this->response->withFile(RESOURCES . ORIGINAL_PHOTO_PATH . DS . $fileName);
        $this->response = $this->response->withType('image/png');
        $this->response = $this->response->withoutHeader('Content-Disposition');
        return $this->response;
    }
}
