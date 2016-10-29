<?php

namespace bultonFr\PhpToXml;

use \XmlWriter;

class PhpToXml
{
    /**
     * @var \XmlWriter $xmlWriter Instance of XmlWriter used
     *  to create the xml document
     */
    protected $xmlWriter;
    
    /**
     * Constructor
     * 
     * Initialize XmlWriter instance
     */
    public function __construct()
    {
        $this->xmlWriter = new XmlWriter;
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent(true);
    }
    
    /**
     * Convert a php data to xml format
     * 
     * @param mixed $datas Data to convert
     * @param string $encoding (Default "UTF-8") Encoding to use for xml
     * 
     * @return string Xml document
     */
    public function convert($datas, $encoding='UTF-8')
    {
        $this->xmlWriter->startDocument('1.0', $encoding);        
        new PhpStructReader($this->xmlWriter, $datas);
        $this->xmlWriter->endDocument();
        
        return $this->xmlWriter->outputMemory(false);
    }
}
