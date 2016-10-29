# php-to-xml
Convert php basic structure to xml document

[![Build Status](https://travis-ci.org/bulton-fr/php-to-xml.svg?branch=master)](https://travis-ci.org/bulton-fr/php-to-xml) [![Coverage Status](https://coveralls.io/repos/github/bulton-fr/php-to-xml/badge.svg?branch=master)](https://coveralls.io/github/bulton-fr/php-to-xml?branch=master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bulton-fr/php-to-xml/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bulton-fr/php-to-xml/?branch=master)

This library is to convert a basic php structure to xml document. Xml attributes is not implemented.
The main goal is to convert a php structure to json or xml.

## Install
With composer:
`curl -sS https://getcomposer.org/installer | php`

Add in your composer.json
```json
{
    "require": {
        "bulton-fr/php-to-xml": "@stable"
    }
}
```

## Example

PHP:
```php
$phpStructure = (object) [
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

echo json_encode($phpStructure);

$phpToXml = new \bultonFr\PhpToXml\PhpToXml;
echo $phpToXml->convert($phpStructure);
```
JSON:
```json
{
    "elements":{
        "elemA":[
            {
                "elemB":"Toto",
                "elemC":"Foo",
                "elemD":{
                    "elemE":[
                        "Foo",
                        "Bar"
                    ]
                }
            },
            {
                "elemB":"Titi",
                "elemC":"Fii",
                "elemD":{
                    "elemE":[
                        "Fii",
                        "Ber"
                    ]
                }
            }
        ]
    }
}
```

XML:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<elements>
    <elemA>
        <elemB>Toto</elemB>
        <elemC>Foo</elemC>
        <elemD>
            <elemE>Foo</elemE>
            <elemE>Bar</elemE>
        </elemD>
    </elemA>
    <elemA>
        <elemB>Titi</elemB>
        <elemC>Fii</elemC>
        <elemD>
            <elemE>Fii</elemE>
            <elemE>Ber</elemE>
        </elemD>
    </elemA>
</elements>
```
