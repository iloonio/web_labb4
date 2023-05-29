<?php
class TextPost {
    private $alias;
    private $content;
    private $timestamp;

    public function __construct($alias, $content) {
        $this->alias = $alias;
        $this->content = $content;
        $this->timestamp = time(); // Store the current timestamp
    }

    public function getAlias() {
        return $this->alias;
    }

    public function getContent() {
        return $this->content;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }
}
