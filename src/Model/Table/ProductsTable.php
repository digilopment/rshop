<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('products');
        $this->setPrimaryKey('id');
        $this->setDisplayField('name');

        // Automaticky zapisovať created/modified
        $this->addBehavior('Timestamp');

        // Asociácia s kategóriami (Many-to-Many)
        $this->belongsToMany('Categories', [
            'foreignKey'       => 'product_id',
            'targetForeignKey' => 'category_id',
            'joinTable'        => 'products_categories',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name', 'Zadajte názov produktu');

        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price', 'Zadajte cenu produktu');

        $validator
            ->decimal('vat')
            ->requirePresence('vat', 'create')
            ->notEmptyString('vat', 'Zadajte DPH');

        return $validator;
    }

}
