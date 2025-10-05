<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\User;
use ArrayObject;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use RuntimeException;

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
     * @param EventInterface<User> $event
     * @param User $entity
     * @param ArrayObject<string, mixed> $options
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options): void
    {

        /** @var User $entity */
        if ($entity->isDirty('password')) {
            if (!class_exists(DefaultPasswordHasher::class)) {
                throw new RuntimeException('DefaultPasswordHasher class not found. Run `composer require cakephp/authentication`.');
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
            ->minLength('password', 8, 'Heslo musí mať aspoň 8 znakov')
            ->requirePresence('password', 'create')
            ->notEmptyString('password', 'Zadajte heslo')
            ->add('password', 'complexity', [
                'rule' => function ($value, $context) {
                    return (bool) preg_match('/^(?=.*[A-Z])(?=.*\d).+$/', (string) $value);
                },
                'message' => 'Heslo musí obsahovať aspoň jedno veľké písmeno a jedno číslo',
        ]);

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
