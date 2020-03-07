<?php

namespace App\Components\CustomFields\Types;

use App\Components\CustomFields\AbstractType;
use App\Models\User;
use App\Models\UserGroup;
use App\Components\CustomFields\DomainTypeContract;
use App\Components\CustomFields\ObjectTypeContract;

class SingleUserFromGroup extends AbstractType implements DomainTypeContract, ObjectTypeContract
{

    /**
     * @var string
     */
    protected $groupName;

    /**
     * @var User
     */
    protected $user;

    /**
     * SingleUserFromGroup constructor.
     * @param string $groupName
     */
    protected function __construct(string $groupName)
    {
        $this->groupName = $groupName;
    }

    /**
     * @param array $params
     * @return AbstractType
     */
    public static function buildFromSchemaParams(array $params): AbstractType
    {
        return new static($params['group']);
    }

    /**
     * @param $databaseValue
     * @return void
     */
    public function loadFromDatabase($databaseValue): void
    {
        $this->user = User::find($databaseValue);
    }

    /**
     * @return mixed
     */
    public function valueOutput()
    {
        return $this->user;
    }

    /**
     * @param $databaseValue
     * @return bool
     */
    public function validate($databaseValue): bool
    {
        return User::find($databaseValue)->groups->reduce(function (bool $carry, UserGroup $current): bool {
            return $carry || $current->slug === $this->groupName;
        }, false);
    }

    public function availableItems(): array
    {
        /** @var UserGroup $group */
        $group = UserGroup::where('slug', $this->groupName)->first();
        $output = [];
        foreach ($group->users as $user) {
            $output[$user->id] = $user->email;
        }
        return $output;
    }

    /**
     * Returns the attribute name of the object that identifies it
     * @return mixed
     */
    public static function getKey()
    {
        return 'email';
    }

    /**
     * Returns the value of the key attribute
     * @return mixed
     */
    public function getKeyValue()
    {
        return $this->user->email;
    }
}
