<?php
defined('SC_PANEL') or die;

/**
 * @param string $name
 * @param string $title
 * @param string $placeholder
 * @param bool $required
 * @param array $data
 */
function innoFormFieldRow($name, $title, $placeholder, $required, $data, $type = 'text', $mask = '') {
    include __DIR__.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'forms'.DIRECTORY_SEPARATOR.'field.php';
}