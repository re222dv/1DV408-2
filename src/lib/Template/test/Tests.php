<?php

namespace Template\test;

use Template\View;

require(realpath(dirname(__FILE__)).'/../../../../vendor/autoload.php');
require_once(realpath(dirname(__FILE__)).'/../View.php');

global $renderedPage;
$renderedPage = <<<PAGE
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
    </head>
    <body>
        Hello, World!

    </body>
</html>

PAGE;

class Tests extends \PHPUnit_Framework_TestCase {

    public function test_render() {
        global $renderedPage;
        $page = new Layout(new Content());
        $this->assertEquals($renderedPage, $page->render());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Template file '' don't exists
     */
    public function test_throw_when_template_not_set() {
        $page = new NoTemplate();
        $page->render();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Template file 'not-found.html' don't exists
     */
    public function test_throw_when_template_not_found() {
        $page = new NotFoundTemplate();
        $page->render();
    }
}

class Layout extends View {
    public function __construct(Content $content) {
        $this->template = 'layout.html';
        $this->setVariable('title', 'Test');
        $this->setView('content', $content);
    }
}


class Content extends View {
    public function __construct() {
        $this->template = 'content.html';
        $this->setVariable('message', 'Hello, World!');
    }
}

class NoTemplate extends View {}
class NotFoundTemplate extends View {
    public function __construct() {
        $this->template = 'not-found.html';
    }
}
