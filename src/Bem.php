<?php
/** j4s/bem */

declare(strict_types=1);

namespace j4s;

/**
 * Class Bem - класс для создания html тегов, формируемых в соответствии с БЭМ методологией
 *
 * @package     j4s\Bem
 * @author      Eugeniy Makarkin <solascriptura@mail.ru>
 * @version     v2.0.3 2018-11-20 11:49:03
 * @copyright   Copyright (c) 2018, by J4. Proprietary License. It is NOT Open Source!
 */
class Bem
{

    /**
     * Возвращает html тег <a>, с заданными аттрибутами, заданной ссылкой и заданным содержимым
     * @version v1.0.2 2018-11-20 11:48:48
     * @param string $selector - Селектор
     * @param string $href - Ссылка
     * @param string $content - Содержимое тега
     * @return string - Возвращаемый тег
     */
    public function link(string $selector, string $href, string $content) : string
    {
        return $this->tag('a' . $selector . '[href="' . $href . '"]', $content);
    }

    /**
     * Возвращает html тег <input type="hidden" ...>, с заданными аттрибутами, заданным именем и заданным значением
     * @version v1.0.2 2018-11-20 11:48:54
     * @param string $selector - Селектор
     * @param string $name - Имя (значение аттрибута name)
     * @param string $value - Значение (Содержимое аттрибута value)
     * @return string - Возвращаемый тег
     */
    public function hidden(string $selector, string $name, string $value = '') : string
    {
        return $this->tag('input' . $selector . '[type=hidden][name=' . $name . '][value=' . $value . ']', null);
    }

    /**
     * Возвращает html тег <select>, с заданными аттрибутами, заданным именем, заданными options, с выбраным option, соответствующим заданному значению
     * @version v1.0.2 2018-11-20 11:48:29
     * @param string $selector - Селектор
     * @param string $name - Имя (значение аттрибута name)
     * @param array $options - Массив параметров для тегов options
     * @param string|null $selected - id выбранного элемента
     * @return string - Возвращаемый тег
     */
    public function select(string $selector, string $name, array $options, $selected = null) : string
    {
        $optionsHtml = $this->tag('option[value=null]', '--выберите--');
        foreach ($options as $option) {
            $optionsHtml .= $this->tag('option[value=' . $option['id'] . ']' . ($option['id'] == $selected ? '[selected]' : ''), $option['name']);
        }
        return $this->tag('select' . $selector . '[name="' . $name . '"]', $optionsHtml);
    }

    /**
     * Возвращает html тег, с заданными аттрибутами и заданным содержимым
     * @version v1.0.2 2018-11-20 11:48:18
     * @param string $selector - Селектор
     * @param string|null $content -  Содержимое тега
     * @return string - Возвращаемый тег
     */
    public function tag(string $selector = '', $content = '') : string
    {
        $selectors = explode("[", $selector);
        $selector0 = $selectors[0];

        $element    = preg_replace("/^([a-z0-9-_]*)(.*)$/", "$1", $selector);
        $element    = $element == '' ? 'div' : $element;

        $atributes = array();

        // Подготавливаем аттрибут id, если имеется
        preg_match_all("/(#([a-zA-Z0-9-_]*))/", $selector0, $ids);
        if (count($ids[2])) {
            array_push($atributes, 'id="' . $ids[2][0] . '"');
        }

        // Подготавливаем аттрибут class, если имеется
        preg_match_all("/(\.([a-zA-Z0-9-_]*))/", $selector0, $classes0);
        if (count($classes0[2])) {
            $classes1 = $classes0[2];
            $classes = array();

            foreach ($classes1 as $class1) {

                // Добавляем главный класс для модификатора
                $noModificator = preg_replace("/^(.*[^_])_([^_]*)$/", "$1", $class1);
                if ($noModificator != $class1) {
                    $classes[] = $noModificator;
                }

                $classes[] = $class1;
            }

            // Исключаем повторяющиеся классы
            $classes = array_unique($classes);

            // Формируем значение аттрибута class
            $class = implode(" ", $classes);
            array_push($atributes, 'class="' . $class . '"');
        }

        // Подготавливаем остальные аттрибуты
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

        // Добавляем все подготовленные аттрибуты
        $atributes = count($atributes) ? ' ' . implode(" ", $atributes) : '';

        // Возвращаем результат
        if (is_null($content)) {
            return '<' . $element . $atributes . '>';
        } else {
            return '<' . $element . $atributes . '>' . $content . '</' . $element . '>';
        }
    }

    /**
     * Возвращает закрывающий html тег
     * @version v1.0.2 2018-11-20 11:47:57
     * @param string $tagName - Имя тега
     * @return string - Возвращаемый код закрывающего тега
     */
    public function closeTag(string $tagName = 'div') : string
    {
        return '</' . $tagName . '>';
    }
}
