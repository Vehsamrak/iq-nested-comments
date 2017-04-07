<?php

namespace Petr\Comments\Core;

use Ramsey\Uuid\Uuid;

/**
 * @author Vehsamrak
 */
class IdGenerator
{

    public function generateRandomId(): string
    {
        return Uuid::uuid4()->toString();
    }
}
