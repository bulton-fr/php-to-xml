<?php

namespace bultonFr\PhpToXml\test\unit\mocks;

/**
 * Extends class PhpToXml for unit test.
 */
class PhpToXml extends \bultonFr\PhpToXml\PhpToXml
{
    /**
     * Magic getter to all attribute
     * Is for unit test, so I not check if attribute exist.
     * 
     * @param string $name Attribute's name
     * 
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name};
    }
}
