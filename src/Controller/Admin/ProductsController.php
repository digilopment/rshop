<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AuthController;
use App\Service\UploadImageService;
use Cake\ORM\Table;
use Laminas\Diactoros\UploadedFile;

class ProductsController extends AuthController
{
    private UploadImageService $UploadImage;

    protected Table $Categories;

    protected Table $Products;

    public function initialize(): void
    {
        parent::initialize();

        $this->Products    = $this->fetchTable('Products');
        $this->Categories  = $this->fetchTable('Categories');
        $this->UploadImage = new UploadImageService();
    }

    public function index(): void
    {
        $products = $this->Products->find()->contain(['Categories']);
        $this->set(compact('products'));
    }

    public function add(): void
    {
        $product = $this->Products->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $uploadedFilename = $this->UploadImage->upload($data, 'image', 'products', 500);
                if ($uploadedFilename) {
                    $data['image'] = $uploadedFilename;
                } else {
                    unset($data['image']);
                }
            }

            $product = $this->Products->patchEntity($product, $data, [
                'associated' => ['Categories'],
            ]);

            if ($this->Products->save($product)) {
                $this->Flash->success('Produkt bol uložený.');
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('Nepodarilo sa uložiť produkt.');
            }
        }

        $categories = $this->Categories
            ->find('list', ['keyField' => 'id', 'valueField' => 'name'])
            ->toArray();

        $this->set(compact('product', 'categories'));
    }

    public function edit(int $id): void
    {
        $product = $this->Products->get($id, ['contain' => ['Categories']]);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
                $uploadedFilename = $this->UploadImage->upload($data, 'image', 'products', 500);

                if ($uploadedFilename) {
                    $data['image'] = $uploadedFilename;
                } else {
                    unset($data['image']);
                }
            }

            $product = $this->Products->patchEntity($product, $data, [
                'associated' => ['Categories'],
            ]);

            if ($this->Products->save($product)) {
                $this->Flash->success('Produkt bol aktualizovaný.');
                $this->redirect($this->getRequest()->getRequestTarget());
            } else {
                $this->Flash->error('Nepodarilo sa aktualizovať produkt.');
            }
        }

        $categories = $this->Categories->find('list')->toArray();
        $this->set(compact('product', 'categories'));
    }

    public function delete(int $id): void
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success('Produkt bol zmazaný.');
        } else {
            $this->Flash->error('Nepodarilo sa zmazať produkt.');
        }
        $this->redirect(['action' => 'index']);
    }
}
