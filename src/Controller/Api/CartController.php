<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;
use App\Service\CartService;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Response;

class CartController extends AppController
{
    protected CartService $cartService;

    public function initialize(): void
    {
        parent::initialize();
        $this->cartService = new CartService($this->getRequest()->getSession());

        $this->request->allowMethod(['post']);
        $this->viewBuilder()->setClassName('Json');
    }

    public function add(): Response
    {
        $data = $this->request->getData();

        if (empty($data['id']) || empty($data['name']) || !isset($data['unitPrice'])) {
            throw new BadRequestException('Neplatné parametre');
        }

        $id        = (string) $data['id'];
        $name      = $data['name'];
        $unitPrice = (float) $data['unitPrice'];
        $taxRate   = isset($data['taxRate']) ? (float) $data['taxRate'] : 20.0;
        $quantity  = isset($data['quantity']) ? (float) $data['quantity'] : 1.0;

        $this->cartService->add($id, $name, $unitPrice, $quantity, $taxRate);

        return $this->response
                ->withType('application/json')
                ->withStringBody((string)json_encode($this->calculateSummary($name . ' pridaný do košíka')));
    }

    /**
     * @return array<string, mixed>
     */
    private function calculateSummary(string $message): array
    {
        $items = $this->cartService->all();
        return [
            'response' => [
                'message' => $message,
            ],
            'total'           => $this->cartService->cart->getTotal()->asFloat(),
            'count'           => $this->cartService->cart->countItems(),
            'totalWithoutTax' => $this->cartService->cart->getSubtotal()->asFloat(),
            'items'           => array_map(function ($item) {
                return [
                    'id'       => $item->getCartId(),
                    'name'     => $item->getCartName(),
                    'price'    => $item->getUnitPrice(),
                    'quantity' => $item->getCartQuantity(),
                    'taxRate'  => $item->getTaxRate(),
                ];
            }, $items),
        ];
    }
}
