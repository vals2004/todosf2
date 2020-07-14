<?php

namespace App\DBAL\Types;

use Fresh\DoctrineEnumBundle\DBAL\Types\AbstractEnumType;

final class ToDoStateType extends AbstractEnumType
{
    public const CREATED = 'NW';
    public const FINISHED = 'FS';
    public const CANCELED = 'CL';
    public const DELETED = 'DL';

    protected static $choices = [
        self::CREATED => 'New',
        self::FINISHED => 'FINISHED',
        self::CANCELED => 'Canceled',
        self::DELETED => 'Deleted',
    ];
}