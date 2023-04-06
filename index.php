<?php
require_once 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\AbstractContainer;

function extractTextFromElement($element) {
    $text = '';
    
    if (method_exists($element, 'getText')) {
        $text .= $element->getText();
    } elseif ($element instanceof AbstractContainer) {
        $elements = $element->getElements();
        foreach ($elements as $childElement) {
            $text .= extractTextFromElement($childElement);
        }
    }
    
    return $text;
}

function readDocx($filePath) {
    $phpWord = IOFactory::load($filePath);
    
    $text = '';
    foreach ($phpWord->getSections() as $section) {
        $elements = $section->getElements();
        foreach ($elements as $element) {
            $text .= extractTextFromElement($element);
        }
    }
    
    return $text;
}

$docxFilePath = 'C:\Users\User\Downloads\4444.docx';
$text = readDocx($docxFilePath);

echo "Содержимое файла .docx:<br>";
echo nl2br($text);

?>