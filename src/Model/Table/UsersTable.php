<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsersTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('users');
        $this->setPrimaryKey('id');
        $this->setDisplayField('username');

        // Automaticky zapisovať created/modified
        $this->addBehavior('Timestamp');
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isDirty('password')) {
            $hasher = new DefaultPasswordHasher();
            $entity->password = $hasher->hash($entity->password);
        }
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('login')
            ->maxLength('login', 255)
            ->requirePresence('login', 'create')
            ->notEmptyString('login', 'Zadajte používateľské meno');

        $validator
            ->scalar('password')
            ->minLength('password', 6, 'Heslo musí mať aspoň 6 znakov')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'Zadajte heslo');

        // voliteľne: potvrdenie hesla
        $validator
            ->add('password_confirm', 'compare', [
                'rule' => ['compareWith', 'password'],
                'message' => 'Heslá sa nezhodujú'
        ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // Unikátny email
        $rules->add($rules->isUnique(['login'], 'Používateľské meno je už obsadené'));

        return $rules;
    }

}
