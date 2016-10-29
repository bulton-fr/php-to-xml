<?php

namespace bultonFr\PhpToXml\test\unit;

use \atoum;

require_once(__DIR__.'/../../../vendor/autoload.php');

class PhpStructReader extends atoum
{
    /**
     * @var $class : Instance de la class
     */
    protected $class;
    
    /**
     * @var \xmlWriter $xmlWriter Instance of xmlWriter used by phpStructReader
     */
    protected $xmlWriter;
    
    /**
     * Instanciation de la class avant chaque méthode de test
     */
    public function beforeTestMethod($testMethod)
    {
        $datasToRead = null;
        
        $this->xmlWriter = new \XmlWriter;
        $this->class     = new \bultonFr\PhpToXml\test\unit\mocks\PhpStructReader(
            $this->xmlWriter,
            $datasToRead
        );
        
        $this->xmlWriter->openMemory();
        $this->xmlWriter->setIndent(true);
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
    }
    
    /**
     * Test the constructor
     * 
     * @return void
     */
    public function testConstruct()
    {
        $this->assert('PHPStructReader::__construct')
            ->if($datasToRead = null)
            ->and($this->class = new \bultonFr\PhpToXml\test\unit\mocks\PhpStructReader($this->xmlWriter, $datasToRead))
            ->then
            ->object($this->class->xmlWriter)
                ->isIdenticalTo($this->xmlWriter);
    }
    
    /**
     * Test method readSimpleElement
     * 
     * @return void
     */
    public function testReadSimpleElement()
    {
        $this->assert('PHPStructReader::readSimpleElement')
            ->if($elementValue = 'unit')
            ->and($this->class->callReadSimpleElement('test', $elementValue))
            ->and($this->xmlWriter->endDocument())
            ->then
            ->string($this->xmlWriter->outputMemory(false))
                ->isEqualTo(
                    '<?xml version="1.0" encoding="UTF-8"?>'."\n"
                    .'<test>unit</test>'."\n"
                );
    }
    
    /**
     * Test method readArrayElement
     * 
     * @return void
     */
    public function testReadArrayElement()
    {
        $this->assert('PHPStructReader::readArrayElement with simple value')
            ->if($elementValue = ['Foo', 'Bar'])
            ->and($this->class->callReadArrayElement('test', $elementValue))
            ->and($this->xmlWriter->endDocument())
            ->then
            ->string($this->xmlWriter->outputMemory(true))
                ->isEqualTo(
                    '<?xml version="1.0" encoding="UTF-8"?>'."\n"
                    .'<test>Foo</test>'."\n"
                    .'<test>Bar</test>'."\n"
                );
        
        $this->assert('PHPStructReader::readArrayElement with complexe value')
            ->if($elementValue = [
                (object) [
                    'foo' => 'bar',
                    'bar' => 'baz'
                ],
                (object) [
                    'fii' => 'ber',
                    'ber' => 'bez'
                ],
            ])
            ->and($this->xmlWriter->startDocument('1.0', 'UTF-8'))
            ->and($this->class->callReadArrayElement('tests', $elementValue))
            ->and($this->xmlWriter->endDocument())
            ->then
            ->string($this->xmlWriter->outputMemory(true))
                ->isEqualTo(
                    '<?xml version="1.0" encoding="UTF-8"?>'."\n"
                    .'<tests>'."\n"
                    .' <foo>bar</foo>'."\n"
                    .' <bar>baz</bar>'."\n"
                    .'</tests>'."\n"
                    .'<tests>'."\n"
                    .' <fii>ber</fii>'."\n"
                    .' <ber>bez</ber>'."\n"
                    .'</tests>'."\n"
                );
    }
    
    /**
     * Test method readObjectElement
     * 
     * @return void
     */
    public function testReadObjectElement()
    {
        $this->assert('PHPStructReader::readObjectElement with complexe element')
            ->if($elementValue = (object) [
                'test' => ['Foo', 'Bar']
            ])
            ->and($this->class->callReadObjectElement('tests', $elementValue))
            ->and($this->xmlWriter->endDocument())
            ->then
            ->string($this->xmlWriter->outputMemory(true))
                ->isEqualTo(
                    '<?xml version="1.0" encoding="UTF-8"?>'."\n"
                    .'<tests>'."\n"
                    .' <test>Foo</test>'."\n"
                    .' <test>Bar</test>'."\n"
                    .'</tests>'."\n"
                );
    }
    
    /**
     * Test method readStructure
     * 
     * @return void
     */
    public function testReadStructure()
    {
        $datas = (object) [
            'elements' => (object) [
                'elemA' => [
                    0 => (object) [
                        'elemB' => 'Toto',
                        'elemC' => 'Foo',
                        'elemD' => (object) [
                            'elemE' => [
                                'Foo',
                                'Bar'
                            ]
                        ]
                    ],
                    1 => (object) [
                        'elemB' => 'Titi',
                        'elemC' => 'Fii',
                        'elemD' => (object) [
                            'elemE' => [
                                'Fii',
                                'Ber'
                            ]
                        ]
                    ]
                ]
            ]
        ];
        
        $this->assert('PHPStructReader::readStructure')
            ->and($this->class = new \bultonFr\PhpToXml\test\unit\mocks\PhpStructReader($this->xmlWriter, $datas))
            ->and($this->xmlWriter->endDocument())
            ->then
            ->string($this->xmlWriter->outputMemory(false))
                ->isEqualTo(
                    '<?xml version="1.0" encoding="UTF-8"?>'."\n"
                    .'<elements>'."\n"
                    .' <elemA>'."\n"
                    .'  <elemB>Toto</elemB>'."\n"
                    .'  <elemC>Foo</elemC>'."\n"
                    .'  <elemD>'."\n"
                    .'   <elemE>Foo</elemE>'."\n"
                    .'   <elemE>Bar</elemE>'."\n"
                    .'  </elemD>'."\n"
                    .' </elemA>'."\n"
                    .' <elemA>'."\n"
                    .'  <elemB>Titi</elemB>'."\n"
                    .'  <elemC>Fii</elemC>'."\n"
                    .'  <elemD>'."\n"
                    .'   <elemE>Fii</elemE>'."\n"
                    .'   <elemE>Ber</elemE>'."\n"
                    .'  </elemD>'."\n"
                    .' </elemA>'."\n"
                    .'</elements>'."\n"
                );
    }
}
