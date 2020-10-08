<?php
/** in4s/bem */

declare(strict_types=1);

namespace in4s;

/**
 * Class BemTest - Tests for class Bem
 *
 * @version     v2.0.0 2019-09-15 08:06:20
 * @author      Eugeniy Makarkin
 * @package     in4s\Bem
 */
class BemTest
{
    /**
     * Run tests of the current class
     *
     * @version v2.1.0 2020-10-08 10:42:59
     * @return void
     */
    public static function run()
    {
        echo '<div class="utest__section">';
        echo '<h5 class="utest__module-name">Bem:</h5>';
        echo self::linkTest();
        echo self::hiddenTest();
        echo self::selectTest();
        echo self::tagTest();
        echo self::closeTagTest();
        echo '</div>';
    }

    /**
     * link method test
     *
     * @version v2.0.0 2019-09-15 08:08:35
     * @return string - html tag with the message of the test result
     */
    public static function linkTest()
    {
        global $Bem, $UTest;

        $UTest->methodName = 'link';


        // Arrange Test
        $UTest->nextHint = 'Without additional attributes';
        $expect = '<a href="#">hello</a>';
        // Act
        $act = $Bem->link('', '#', 'hello');
        // Assert Test
        $UTest->isEqual("link('', '#', 'hello');", $expect, $act);


        // Arrange Test
        $UTest->nextHint = 'With id and class attributes';
        $expect = '<a id="hi" class="there" href="/test/">hello</a>';
        // Act
        $act = $Bem->link('#hi.there', '/test/', 'hello');
        // Assert Test
        $UTest->isEqual("link('#hi.there', '/test/', 'hello');", $expect, $act);


        return $UTest->functionResults;
    }

    /**
     * hidden method test
     *
     * @version v2.0.0 2019-09-15 08:08:35
     * @return string - html tag with the message of the test result
     */
    public static function hiddenTest()
    {
        global $Bem, $UTest;

        $UTest->methodName = 'hidden';


        // Arrange Test
        $UTest->nextHint = 'Without additional attributes';
        $expect = '<input type="hidden" name="myname" value="myval">';
        // Act
        $act = $Bem->hidden('', 'myname', 'myval');
        // Assert Test
        $UTest->isEqual("hidden('', 'myname', 'myval');", $expect, $act);


        // Arrange Test
        $UTest->nextHint = 'With id and class attributes';
        $expect = '<input id="hi" class="there" type="hidden" name="myname" value="myval">';
        // Act
        $act = $Bem->hidden('#hi.there', 'myname', 'myval');
        // Assert Test
        $UTest->isEqual("hidden('#hi.there', 'myname', 'myval');", $expect, $act);


        return $UTest->functionResults;
    }

    /**
     * select method test
     *
     * @version v2.0.0 2019-09-15 08:08:35
     * @return string - html tag with the message of the test result
     */
    public static function selectTest()
    {
        global $Bem, $UTest;

        $UTest->methodName = 'select';

        // Arrange Tests
        $optionsArray = [
            ['id' => 1, 'name' => 'option1'],
            ['id' => 2, 'name' => 'option2'],
            ['id' => 3, 'name' => 'option3'],
        ];


        // Arrange Test
        $UTest->nextHint = 'Select without additional attributes';
        $expect = '<select name="myname">';
        $expect .= '<option value="null">--choose--</option>';
        $expect .= '<option value="1">option1</option>';
        $expect .= '<option value="2">option2</option>';
        $expect .= '<option value="3">option3</option>';
        $expect .= '</select>';
        // Act
        $act = $Bem->select('', 'myname', $optionsArray);
        // Assert Test
        $UTest->isEqual("select('', 'myname', array);", $expect, $act);


        // Arrange Test
        $UTest->nextHint = 'Select with attributes id and class with preselected value';
        $expect = '<select id="hi" class="there" name="myname">';
        $expect .= '<option value="null">--choose--</option>';
        $expect .= '<option value="1">option1</option>';
        $expect .= '<option value="2">option2</option>';
        $expect .= '<option value="3" selected>option3</option>';
        $expect .= '</select>';
        // Act
        $act = $Bem->select('#hi.there', 'myname', $optionsArray, 3);
        // Assert Test
        $UTest->isEqual("select('#hi.there', 'myname', array, 3);", $expect, $act);


        return $UTest->functionResults;
    }

    /**
     * tag method test
     *
     * @version v2.0.0 2019-09-15 08:08:35
     * @return string - html tag with the message of the test result
     */
    public static function tagTest()
    {
        global $Bem, $UTest;

        $UTest->methodName = 'tag';


        $UTest->isEqual("tag();", '<div></div>', $Bem->tag());
        $UTest->isEqual("tag('.hi');", '<div class="hi"></div>', $Bem->tag('.hi'));
        $UTest->isEqual("tag('#hi');", '<div id="hi"></div>', $Bem->tag('#hi'));
        $UTest->isEqual("tag('h1');", '<h1></h1>', $Bem->tag('h1'));
        $UTest->isEqual("tag('h1.h1');", '<h1 class="h1"></h1>', $Bem->tag('h1.h1'));
        $UTest->isEqual("tag('h1.hi_ok');", '<h1 class="hi hi_ok"></h1>', $Bem->tag('h1.hi_ok'));
        $UTest->isEqual("tag('h1.hi__ok');", '<h1 class="hi__ok"></h1>', $Bem->tag('h1.hi__ok'));
        $UTest->isEqual("tag('h1.hi__elem');", '<h1 class="hi__elem"></h1>', $Bem->tag('h1.hi__elem'));
        $UTest->isEqual("tag('h1.hi__elem_ok');", '<h1 class="hi__elem hi__elem_ok"></h1>', $Bem->tag('h1.hi__elem_ok'));
        $UTest->isEqual("tag('h1.hi.there');", '<h1 class="hi there"></h1>', $Bem->tag('h1.hi.there'));
        $UTest->isEqual("tag('h1.hi.there.hi');", '<h1 class="hi there"></h1>', $Bem->tag('h1.hi.there.hi'));
        $UTest->isEqual("tag('h1.hi.there#there');", '<h1 id="there" class="hi there"></h1>', $Bem->tag('h1.hi.there#there'));
        $UTest->isEqual("tag('h1.hi#there.there#second_id', 'text');", '<h1 id="there" class="hi there">text</h1>', $Bem->tag('h1.hi#there.there#second_id', 'text'));
        $UTest->isEqual("tag('h1.hi[data-j4=\"hello\"]');", '<h1 class="hi" data-j4="hello"></h1>', $Bem->tag('h1.hi[data-j4="hello"]'));
        $UTest->isEqual("tag('h1.hi[data-j4=hello]');", '<h1 class="hi" data-j4="hello"></h1>', $Bem->tag('h1.hi[data-j4=hello]'));
        $UTest->isEqual("tag('h1.hi[data-j4=\"hello\"][title='hi']');", '<h1 class="hi" data-j4="hello" title="hi"></h1>', $Bem->tag('h1.hi[data-j4="hello"][title=\'hi\']'));
        $UTest->isEqual("tag('li');", '<li></li>', $Bem->tag('li'));
        $UTest->isEqual("tag('li', NULL);", '<li>', $Bem->tag('li', null));
        $UTest->isEqual("tag('li.li', NULL);", '<li class="li">', $Bem->tag('li.li', null));
        $UTest->isEqual("tag('li', 'point');", '<li>point</li>', $Bem->tag('li', 'point'));


        // Arrange Test
        $UTest->nextHint = 'Tag attribute with no value';
        $expect = '<input type="text" name="name" disabled>';
        // Act
        $act = $Bem->tag('input[type=text][name=name][disabled]', null);
        // Assert Test
        $UTest->isEqual("tag('input[type=text][name=name][disabled]', NULL);", $expect, $act);


        // Arrange Test
        $UTest->nextHint = 'The presence of symbols # and . in attributes should not create unnecessary attributes';
        $expect = '<li test="#...hi#there#.#"></li>';
        // Act
        $act = $Bem->tag('li[test=#...hi#there#.#]');
        // Assert Test
        $UTest->isEqual("tag('li[test=#...hi#there#.#]');", $expect, $act);


        return $UTest->functionResults;
    }

    /**
     * closeTag method test
     *
     * @version v2.0.0 2019-09-15 08:08:35
     * @return string - html tag with the message of the test result
     */
    public static function closeTagTest()
    {
        global $Bem, $UTest;

        $UTest->methodName = 'closeTag';


        // Arrange Test
        $UTest->nextHint = 'Without attributes = < /div>';
        $expect = '</div>';
        // Act
        $act = $Bem->closeTag();
        // Assert Test
        $UTest->isEqual("closeTag();", $expect, $act);


        // Arrange Test
        $UTest->nextHint = 'Closing span';
        $expect = '</span>';
        // Act
        $act = $Bem->closeTag('span');
        // Assert Test
        $UTest->isEqual("closeTag('span');", $expect, $act);


        return $UTest->functionResults;
    }
}
