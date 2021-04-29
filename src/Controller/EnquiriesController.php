<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Mailer;

/**
 * Enquiries Controller
 *
 * @property \App\Model\Table\EnquiriesTable $Enquiries
 * @method \App\Model\Entity\Enquiry[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EnquiriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $enquiries = $this->paginate($this->Enquiries);

        $this->set(compact('enquiries'));
    }

    /**
     * View method
     *
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $enquiry = $this->Enquiries->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('enquiry'));
    }

    /**
     * Reply method
     *
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function reply($id = null)
    {
        $enquiry = $this->Enquiries->get($id, ['contain' => []]);

        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer
                ->setFrom('noreply@' . (strpos($this->request->host(), ':') == false ?
                    $this->request->host() : strstr($this->request->host(), ':', true)))
                ->setTo($enquiry->email)
                ->setSubject('Enquiry Reply: ' . $enquiry->subject)
                ->deliver(
                    'Hi, ' . $enquiry->name . "\n\n" .
                    $this->request->getData('reply') . "\n\n" .
                    "If you have further questions, please open another enquiry.  Replies of this email will not be received by staff.\n\n" .
                    "Kind Regards,\n" .
                    "Nature's Bonding Gift"
                );

            /* Set status to replied */
            $enquiry['status'] = 'Replied';
            if ($this->Enquiries->save($enquiry)) {
                $this->Flash->success(__('The enquiry has been replied.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('Warning: Failed to update enquiry status!'));
            }
        }

        $this->set(compact('enquiry'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $enquiry = $this->Enquiries->newEmptyEntity();
        if ($this->request->is('post')) {
            $enquiry = $this->Enquiries->patchEntity($enquiry, $this->request->getData());
            if ($this->Enquiries->save($enquiry)) {
                $this->Flash->success(__('The enquiry has been saved.'));

                return $this->redirect(['controller' => 'Landing', 'action' => 'home']);
            }
            $this->Flash->error(__('The enquiry could not be saved. Please, try again.'));
        }
        $this->set(compact('enquiry'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Enquiry id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $enquiry = $this->Enquiries->get($id);
        if ($this->Enquiries->delete($enquiry)) {
            $this->Flash->success(__('The enquiry has been deleted.'));
        } else {
            $this->Flash->error(__('The enquiry could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
