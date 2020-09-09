<?php
/** in4s/bem */

declare(strict_types=1);

namespace in4s;

/**
 * Generation of HTML tags, with classes according to BEM
 *
 * @version     v3.0.1 2020-09-09 15:48:15
 * @author      Eugeniy Makarkin
 * @package     in4s\Bem
 */
class Bem
{

    /**
     * Generate html tag <a>
     *
     * @version v2.0.1 2020-09-09 15:36:57
     *
     * @param string $selector - Selector
     * @param string $href     - Link
     * @param string $content  - Tag content
     *
     * @return string - Tag
     */
    public function link(string $selector, string $href, string $content): string
    {
        return $this->tag('a' . $selector . '[href="' . $href . '"]', $content);
    }

    /**
     * Generate html tag
     *
     * @version v2.0.1 2020-09-09 15:36:57
     *
     * @param string      $selector - Selector
     * @param string|null $content  - Tag content
     *
     * @return string - Tag
     */
    public function tag(string $selector = '', $content = ''): string
    {
        $selectors = explode("[", $selector);
        $selector0 = $selectors[0];

        $element = preg_replace("/^([a-z0-9-_]*)(.*)$/", "$1", $selector);
        $element = $element == '' ? 'div' : $element;

        $atributes = [];

        // Preparing id attribute, if exist
        preg_match_all("/(#([a-zA-Z0-9-_]*))/", $selector0, $ids);
        if (count($ids[2])) {
            array_push($atributes, 'id="' . $ids[2][0] . '"');
        }

        // Preparing class attribute, if exist
        preg_match_all("/(\.([a-zA-Z0-9-_]*))/", $selector0, $classes0);
        if (count($classes0[2])) {
            $classes1 = $classes0[2];
            $classes = [];

            foreach ($classes1 as $class1) {

                // Add main class of modifier
                $noModificator = preg_replace("/^(.*[^_])_([^_]*)$/", "$1", $class1);
                if ($noModificator != $class1) {
                    $classes[] = $noModificator;
                }

                $classes[] = $class1;
            }

            // Exclude not unique classes
            $classes = array_unique($classes);

            // Prepare the value of the class attribute
            $class = implode(" ", $classes);
            array_push($atributes, 'class="' . $class . '"');
        }

        // Preparing the rest of the attributes
        preg_match_all("/(\[([^]]*)\])/", $selector, $atributes0);
        if (count($atributes0[2])) {
            $atributes1 = $atributes0[2];

            foreach ($atributes1 as $attrValue) {
                $attr = preg_replace("/^([^=]*)=(.*)$/", "$1", $attrValue);
                $value = preg_replace("/^([^=]*)=(.*)$/", "$2", $attrValue);
                $value = preg_replace("/^[\"\'](.*)[\"\']$/", "$1", $value);
                $atribute = preg_match("/=/", $attrValue) ? $attr . '="' . $value . '"' : $attr;
                array_push($atributes, $atribute);
            }
        }

        // Add all prepared attributes
        $atributes = count($atributes) ? ' ' . implode(" ", $atributes) : '';

        // Return results
        if (is_null($content)) {
            return '<' . $element . $atributes . '>';
        } else {
            return '<' . $element . $atributes . '>' . $content . '</' . $element . '>';
        }
    }

    /**
     * Generate html tag <input type="hidden" ...>
     *
     * @version v2.0.1 2020-09-09 15:36:57
     *
     * @param string $selector - Selector
     * @param string $name     - Name (The value of the Name attribute)
     * @param string $value    - Value (The content of the Value attribute)
     *
     * @return string - Tag
     */
    public function hidden(string $selector, string $name, string $value = ''): string
    {
        return $this->tag('input' . $selector . '[type=hidden][name=' . $name . '][value=' . $value . ']', null);
    }

    /**
     * Generate html tag <select>
     *
     * @version v2.0.1 2020-09-09 15:36:57
     *
     * @param string      $selector - Selector
     * @param string      $name     - Name (The value of the Name attribute)
     * @param array       $options  - Array of parameters for options tags
     * @param string|null $selected - Id of the selected element
     *
     * @return string - Tag
     */
    public function select(string $selector, string $name, array $options, $selected = null): string
    {
        $optionsHtml = $this->tag('option[value=null]', '--choose--');
        foreach ($options as $option) {
            $optionsHtml .= $this->tag('option[value=' . $option['id'] . ']' . ($option['id'] == $selected ? '[selected]' : ''), $option['name']);
        }
        return $this->tag('select' . $selector . '[name="' . $name . '"]', $optionsHtml);
    }

    /**
     * Generate the closing html tag
     *
     * @version v2.0.1 2020-09-09 15:36:57
     *
     * @param string $tagName - Tag name
     *
     * @return string - Closing tag
     */
    public function closeTag(string $tagName = 'div'): string
    {
        return '</' . $tagName . '>';
    }
}
