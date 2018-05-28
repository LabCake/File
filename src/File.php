<?php

/**
 * A simple class for creating temporary files in PHP
 * @author LabCake
 * @copyright 2018 LabCake
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace LabCake;
class File
{
    /**
     * @var string
     */
    protected $_fileName;
    protected $fp;

    public function __construct($content = null)
    {
        $directory = self::getTempDir();
        $prefix = 'php_tmpfile_';

        $this->_fileName = tempnam($directory, $prefix);

        if ($content == null)
            $content = "php_tmpfile";

        $this->fp = fopen($this->_fileName, "w+");
        fwrite($this->fp, $content);
    }

    public function getFp()
    {
        return $this->fp;
    }

    /**
     * @return string
     */
    public static function getTempDir()
    {
        if (function_exists('sys_get_temp_dir')) {
            return sys_get_temp_dir();
        } elseif (($tmp = getenv('TMP')) || ($tmp = getenv('TEMP')) || ($tmp = getenv('TMPDIR'))) {
            return realpath($tmp);
        } else {
            return '/tmp';
        }
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        fwrite($this->fp, $content);
    }

    /**
     * @param $name
     * @return bool
     */
    public function saveAs($name)
    {
        return copy($this->_fileName, $name);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->_fileName;
    }

    /**
     * Delete tmp file on shutdown
     */
    public function __destruct()
    {
        fclose($this->fp);
        unlink($this->_fileName);
    }
}