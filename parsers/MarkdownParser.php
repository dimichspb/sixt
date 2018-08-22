<?php
namespace app\parsers;

class MarkdownParser extends \Parsedown implements ParserInterface
{
    public function parse($origin)
    {
        return $this->text($origin);
    }
}