<?php

namespace bultonFr\PhpToXml\test\unit\mocks;

class PhpToXml extends \bultonFr\PhpToXml\PhpToXml
{
    public function __get($name)
    {
        return $this->{$name};
    }
}
