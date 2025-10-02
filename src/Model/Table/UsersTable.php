<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
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
        $this->addBehavior('Timestamp');
    }

    /**
     * Before save callback
     *
     * @param EventInterface<\App\Model\Entity\User> $event
     * @param \App\Model\Entity\User $entity
     * @param ArrayObject<string, mixed> $options
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {

        /** @var User $entity */
        if ($entity->isDirty('password')) {
            if (!class_exists(DefaultPasswordHasher::class)) {
                throw new \RuntimeException('DefaultPasswordHasher class not found. Run `composer require cakephp/authentication`.');
            }

            if (isset($entity->password)) {
                $hasher           = new DefaultPasswordHasher();
                $entity->password = $hasher->hash((string) $entity->password);
            }
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

        $validator
            ->add('password_confirm', 'compare', [
                'rule'    => ['compareWith', 'password'],
                'message' => 'Heslá sa nezhodujú',
        ]);

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['login'], 'Používateľské meno je už obsadené'));

        return $rules;
    }

}
