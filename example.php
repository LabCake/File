<?php

/**
 * Example file on how to use the File library
 */

include_once "src/File.php";

$file = new \LabCake\File("Hello World");
$file->setContent("This is some content");
$file->saveAs("test.txt");