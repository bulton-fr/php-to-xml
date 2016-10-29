<?php

namespace bultonFr\PhpToXml\test\unit;

use \atoum;

require_once(__DIR__.'/../../../vendor/autoload.php');

class PhpToXml extends atoum
{
    /**
     * @var $class : Instance de la class
     */
    protected $class;
    
    /**
     * Instanciation de la class avant chaque méthode de test
     */
    public function beforeTestMethod($testMethod)
    {
        $this->class = new \bultonFr\PhpToXml\test\unit\mocks\PhpToXml;
    }
    
    /**
     * Test the constructor
     * 
     * @return void
     */
    public function testConstruct()
    {
        $this->assert('PhpToXml::__construct')
            ->if($this->class = new \bultonFr\PhpToXml\test\unit\mocks\PhpToXml)
            ->then
            ->object($this->class->xmlWriter)
                ->isInstanceOf('\XmlWriter');
    }
    
    /**
     * Test the method convert with utf-8 encoding
     * 
     * @return void
     */
    public function testConvertUtf8()
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
            ->string($this->class->convert($datas))
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
    
    /**
     * Test the method convert with iso-8859-1 encoding
     * 
     * @return void
     */
    public function testConvertIso88591()
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
            ->string($this->class->convert($datas, 'ISO-8859-1'))
                ->isEqualTo(
                    '<?xml version="1.0" encoding="ISO-8859-1"?>'."\n"
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
