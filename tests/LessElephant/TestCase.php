<?php

/**
 * This file is part of the GitElephant package.
 *
 * (c) Matteo Giachino <matteog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Just for fun...
 */

namespace LessElephant;

use LessElephant\StalenessChecker\FinderStalenessChecker;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $sourceFolder;
    protected $sourceFile;
    protected $depFile;
    protected $destination;
    protected $binary;
    /**
     * @var \LessElephant\CommandCaller
     */
    protected $commandCaller;
    /**
     * @var \LessElephant\LessProject
     */
    protected $lessProject;


    public function initProject()
    {
        exec('npm install less');
        $tempDir = realpath(sys_get_temp_dir()).'less_elephant_'.md5(uniqid(rand(),1));
        $tempName = tempnam($tempDir, 'less_elephant');
        unlink($tempName);
        mkdir($tempName);
        $sourceFolder = $tempName.DIRECTORY_SEPARATOR.'less';
        $destFolder = $tempName.DIRECTORY_SEPARATOR.'css';
        mkdir($sourceFolder);
        mkdir($destFolder);
        $this->sourceFolder = $sourceFolder;
        $sourceFile = 'main.less';
        $this->depFile = $this->sourceFolder.DIRECTORY_SEPARATOR.'vars.less';
        $this->sourceFile = $sourceFile;
        $destination = $destFolder.DIRECTORY_SEPARATOR.'main.css';
        touch($destination);
        $this->destination = $destination;
        $binary = new LessBinary(__DIR__.'/../../node_modules/.bin/lessc');
        $this->lessProject = new LessProject($this->sourceFolder, $this->sourceFile, $this->destination, 'testProject', $binary);
    }

    protected function writeStyle($file, $style)
    {
        sleep(1.1);
        $handle = fopen($file, 'w');
        fwrite($handle, PHP_EOL.$style.PHP_EOL);
        fclose($handle);
    }
}
