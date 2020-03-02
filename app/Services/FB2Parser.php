<?php

namespace App\Services;

class FB2Parser
{
    protected $book;
    public $text = '';

    public function __construct($book)
    {
        $this->doc = new \DOMDocument;
        $this->book = $book;
    }

    public function getText()
    {
        $reader = new \XMLReader;
        $reader->open($this->book);

        $str = '';

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT) {
                if ($reader->name== 'body') {
                    $xml_object = simplexml_import_dom($this->doc->importNode($reader->expand(), true));
                    $str .= $this->extractAndFormatText($xml_object);
                }
            }
        }

        return $this->text;
    }

    private function extractAndFormatText($body)
    {
        foreach ($body as $key => $val) {
            switch ($key) {
                case 'title':
                    foreach ($body->$key as $title) {
                        foreach ($title as $name => $name_val) {
                            $this->text .= PHP_EOL .(string)$name_val . PHP_EOL;
                        }
                    }
                    break;
                case 'epigraph':
                    $this->extractAndFormatText($val);
                    break;
                case 'section':
                    $this->extractAndFormatText($val);
                    break;
                case 'poem':
                    $this->extractAndFormatText($val);
                    break;
                case 'cite':
                    $this->extractAndFormatText($val);
                    break;
                case 'subtitle':
                    $this->extractAndFormatText($val);
                    break;
                case 'stanza':
                    $this->extractAndFormatText($val);
                    break;
                case 'p':
                    $this->text .= PHP_EOL . (string)$val . PHP_EOL;
                    break;
                case 'v':
                    $this->text .= PHP_EOL. (string)$val .PHP_EOL;
                    break;
            }
        }
    }
}
