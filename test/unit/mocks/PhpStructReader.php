<?php

namespace bultonFr\PhpToXml\test\unit\mocks;

class PhpStructReader extends \bultonFr\PhpToXml\PhpStructReader
{
    public function __get($name)
    {
        return $this->{$name};
    }
    
    public function callReadArrayElement($elementName, &$elementValue)
    {
        return $this->readArrayElement($elementName, $elementValue);
    }
    
    public function callReadObjectElement($elementName, &$elementValue)
    {
        return $this->readObjectElement($elementName, $elementValue);
    }
    
    public function callReadSimpleElement($elementName, &$elementValue)
    {
        return $this->readSimpleElement($elementName, $elementValue);
    }
}
