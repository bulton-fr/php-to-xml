<?php

namespace bultonFr\PhpToXml\test\unit\mocks;

/**
 * Extends class PhpStructReader for unit test.
 */
class PhpStructReader extends \bultonFr\PhpToXml\PhpStructReader
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
    
    /**
     * Call the protected method readArrayElement
     * @see \bultonFr\PhpToXml\PhpStructReader::readArrayElement
     * 
     * @param string $elementName The name of the element 
     * @param mixed $elementValue Datas for this element
     * 
     * @return void
     */
    public function callReadArrayElement($elementName, &$elementValue)
    {
        return $this->readArrayElement($elementName, $elementValue);
    }
    
    /**
     * Call the protected method readObjectElement
     * @see \bultonFr\PhpToXml\PhpStructReader::readObjectElement
     * 
     * @param string $elementName The name of the element 
     * @param mixed $elementValue Datas for this element
     * 
     * @return void
     */
    public function callReadObjectElement($elementName, &$elementValue)
    {
        return $this->readObjectElement($elementName, $elementValue);
    }
    
    /**
     * Call the protected method readSimpleElement
     * @see \bultonFr\PhpToXml\PhpStructReader::readSimpleElement
     * 
     * @param string $elementName The name of the element 
     * @param mixed $elementValue Datas for this element
     * 
     * @return void
     */
    public function callReadSimpleElement($elementName, &$elementValue)
    {
        return $this->readSimpleElement($elementName, $elementValue);
    }
}
