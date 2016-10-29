<?php

namespace bultonFr\PhpToXml;

use \XmlWriter;

class PhpStructReader
{
    /**
     * @var \XmlWriter $xmlWriter Instance of XmlWriter used
     *  to create the xml document
     */
    protected $xmlWriter;
    
    /**
     * Constructor
     * 
     * Read php date and call XmlWriter method to write elements
     * 
     * @param XmlWriter $xmlWriter Instance of XmlWriter
     * @param mixed $data Data to read
     */
    public function __construct(XmlWriter $xmlWriter, &$data)
    {
        $this->xmlWriter = $xmlWriter;
        $this->readStructure($data);
    }
    
    /**
     * Read a php structure and call method to write xml element
     * 
     * @param mixed $data Datas to read
     * 
     * @return void
     */
    protected function readStructure(&$data)
    {
        //Considering not possible.
        //Simple element only in complex structure.
        if (!is_array($data) && !is_object($data)) {
            return;
        }
        
        foreach ($data as $elementName => &$elementValue) {
            if (is_array($elementValue)) {
                $this->readArrayElement($elementName, $elementValue);
                continue;
            }
            
            if (is_object($elementValue)) {
                $this->readObjectElement($elementName, $elementValue);
                continue;
            }
            
            $this->readSimpleElement($elementName, $elementValue);
        }
        
        //Only remove the reference on $elementValue.
        unset($elementValue);
    }
    
    /**
     * Write a xml element for an array structure
     * Loop on all datas and call a new instance of this class to read datas
     * if data is an array or an object.
     * The new instance is to by-pass recursive error.
     * If is not an array or object, call readSimpleElement.
     * 
     * @param string $elementName The name of the element 
     * @param mixed $elementValue Datas for this element
     * 
     * @return void
     */
    protected function readArrayElement($elementName, &$elementValue)
    {
        foreach ($elementValue as $elementItem) {
            if (!is_array($elementItem) && !is_object($elementItem)) {
                $this->readSimpleElement($elementName, $elementItem);
                continue;
            }
                
            $this->xmlWriter->startElement($elementName);
            new PhpStructReader($this->xmlWriter, $elementItem);
            $this->xmlWriter->endElement();
        }
    }
    
    /**
     * Write a xml element for an object structure
     * Call a new instance of this class to read datas in array
     * The new instance is to by-pass recursive error.
     * 
     * @param string $elementName The name of the element 
     * @param mixed $elementValue Datas for this element
     * 
     * @return void
     */
    protected function readObjectElement($elementName, &$elementValue)
    {
        $this->xmlWriter->startElement($elementName);
        new PhpStructReader($this->xmlWriter, $elementValue);
        $this->xmlWriter->endElement();
    }
    
    /**
     * Write a simple xml element
     * 
     * @param string $elementName The name of the element 
     * @param mixed $elementValue Datas for this element
     * 
     * @return void
     */
    protected function readSimpleElement($elementName, &$elementValue)
    {
        $this->xmlWriter->writeElement($elementName, $elementValue);
    }
}
