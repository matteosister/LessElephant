<?php

/**
 * This file is part of the CompassElephant package.
 *
 * (c) Matteo Giachino <matteog@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Just for fun...
 */

namespace LessElephant;

use Symfony\Component\Process\Process;
use LessElephant\LessBinary;

/**
 * Caller
 *
 * @author Matteo Giachino <matteog@gmail.com>
 */

class CommandCaller
{
    /**
     * @var \LessElephant\LessBinary
     */
    private $binary;

    /**
     * @var string
     */
    private $sourceFolder;

    /**
     * @var string
     */
    private $sourceFile;

    /**
     * @var string
     */
    private $destination;

    /**
     * @var array
     */
    private $output;

    /**
     * Class constructor
     *
     * @param string     $sourceFolder the source folder path
     * @param string     $sourceFile   the path of the less base file
     * @param string     $destination  the path of the css destination
     * @param LessBinary $binary       a LessBinary instance
     */
    public function __construct($sourceFolder, $sourceFile, $destination, LessBinary $binary = null)
    {
        $this->sourceFolder = $sourceFolder;
        $this->sourceFile = $sourceFile;
        $this->destination = $destination;
        if ($binary == null) {
            $binary = new LessBinary();
        }
        $this->binary = $binary;
    }

    /**
     * build a compile command
     *
     * @return CommandCaller
     */
    public function compile()
    {
        $cmd = sprintf('%s %s %s', $this->binary->getPath(), $this->sourceFile, $this->destination);
        $this->execute($cmd);
        return $this;
    }

    /**
     * Execute a command
     *
     * @param string $cmd the command
     */
    private function execute($cmd)
    {
        $process = new Process(escapeshellcmd($cmd), $this->sourceFolder);
        $process->run();
        $this->output = trim($process->getOutput(), PHP_EOL);
    }

    /**
     * gets the command output
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->output;
    }
}
