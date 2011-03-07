<?php

namespace Uwe\CMFBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CMFBundle extends Bundle
{
    public function getNamespace()
    {
        return __NAMESPACE__;
    }

    public function getPath()
    {
        return strtr(__DIR__, '\\', '/');
    }
}
