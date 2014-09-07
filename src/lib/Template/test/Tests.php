<?php

namespace Template\test;

use Template\View;
use Template\ViewSettings;

require(realpath(dirname(__FILE__)).'/../../../../vendor/autoload.php');
require_once(realpath(dirname(__FILE__)).'/../View.php');
require_once(realpath(dirname(__FILE__)).'/../ViewSettings.php');

global $renderedPage;
$renderedPage = <<<PAGE
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
    </head>
    <body>\n        \n
    Hello, World!


    </body>
</html>

PAGE;

global $renderedPageXSS;
$renderedPageXSS = <<<PAGE
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
    </head>
    <body>
        \n    Hello, &lt;script type=&quot;application/javascript&quot;&gt;alert('hej')&lt;/script&gt;!



    </body>
</html>

PAGE;

class Tests extends \PHPUnit_Framework_TestCase {

    public function __construct() {
        $this->viewSettings = new ViewSettings();
    }

    public function testRender() {
        global $renderedPage;
        $page = new Layout($this->viewSettings, new Content($this->viewSettings));
        $this->assertEquals($renderedPage, $page->render());
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Template file '' don't exists
     */
    public function testThrowWhenTemplateNotSet() {
        $page = new NoTemplate($this->viewSettings);
        $page->render();
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Template file 'not-found.html' don't exists
     */
    public function testThrowWhenTemplateNotFound() {
        $page = new NotFoundTemplate($this->viewSettings);
        $page->render();
    }

    public function testVariableInsertionIsXssProof() {
        global $renderedPageXSS;
        $content = new Content($this->viewSettings);
        $content->setVariable('name',
                              '<script type="application/javascript">alert(\'hej\')</script>');
        $content->setVariable('hasName', true);
        $page = new Layout($this->viewSettings, $content);

        $this->assertEquals(serialize($renderedPageXSS), serialize($page->render()));
    }
}

class Layout extends View {
    public function __construct(ViewSettings $settings, Content $content) {
        parent::__construct($settings);

        $this->template = 'layout.html';
        $this->setVariable('title', 'Test');
        $this->setView('content', $content);
    }
}


class Content extends View {
    public function __construct(ViewSettings $settings) {
        parent::__construct($settings);

        $this->template = 'content.html';
        $this->setVariable('hasName', false);
    }
}

class NoTemplate extends View {}
class NotFoundTemplate extends View {
    public function __construct(ViewSettings $settings) {
        parent::__construct($settings);

        $this->template = 'not-found.html';
    }
}
