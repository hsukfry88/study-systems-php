<?php

class XMLCourse {
    
    private $doc = null;
    private $version = '1.0';
    private $encoding = 'utf-8';
    private $rootName = 'courses';
    private $root = null;
    private $element = null;
    private $tagName = '';
    private $attribute = array(
        'id' => null,
        'name' => null,
        'major' => null,
        'buildTime' => null,
        'submitTime' => null,
        'teacher' => null,
        'school' => null,
    );
    
    public function __construct($rootName = 'exhibitions',$version = '1.0',$encoding = 'utf-8'){
        $this->rootName = $rootName;
        $this->version = $version;
        $this->encoding = $encoding;
        $this->doc = new DOMDocument($this->version, $this->encoding);
        $this->root();
    }
    
    public function addItem($data = array(),$tagName = 'item') {
        if (!is_array($data) || empty($data))   return;
        $this->parseParam($data);
        $this->tagName = $tagName;
        $this->createElement();
        $this->createAttribute();
        $this->root->appendChild($this->element);
    }
    
    public function add($data = array(),$tagName = 'item') {
        if (!is_array($data) || empty($data))   return;
        foreach ($data as $value) {
            if (is_array($value) && !empty($value))
                $this->addItem($value,$tagName);
        }
    }
    
    public function saveXML() {
        return $this->saveXML();
    }
    
    public function save($path) {
        $this->doc->save($path);
    }
    
    public function saveHTML() {
        header("Content-Type:text/xml");
        echo $this->doc->saveHTML();
    }
    
    private function root() {
        $this->root = $this->doc->createElement($this->rootName);
        $this->root = $this->doc->appendChild($this->root);
    }
    
    private function parseParam($param) {
        foreach ($this->attribute as $key => $value) {
            if (array_key_exists($key, $param)) {
                $this->attribute[$key] = str_replace('&', '|', $param[$key]);
            }
        }
    }
    
    private function createElement(){
        $this->element = $this->doc->createElement($this->tagName);
    }
    
    private function createAttribute(){
        foreach ($this->attribute as $key => $value) {
            $this->element->setAttribute($key, $value);
        }
    }
}

?>