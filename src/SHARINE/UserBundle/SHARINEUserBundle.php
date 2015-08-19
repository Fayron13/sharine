<?php

namespace SHARINE\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SHARINEUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
