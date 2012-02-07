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

use LessElephant\CommandCaller,
LessElephant\StalenessChecker\StalenessCheckerInterface,
LessElephant\StalenessChecker\FinderStalenessChecker;

/**
 * CompassElephant
 *
 * @author Matteo Giachino <matteog@gmail.com>
 */

class LessProject
{
    /**
     * @var string the less source path
     */
    private $sourceFolder;

    /**
     * @var string the less base file
     */
    private $sourceFile;

    /**
     * @var string the css destination path
     */
    private $destination;

    /**
     * @var string a project name
     */
    private $name;

    /**
     * @var \LessElephant\LessBinary
     */
    private $lessBinary;

    /**
     * @var \CompassElephant\CommandCaller
     */
    private $commandCaller;

    /**
     * @var \CompassElephant\StalenessChecker\StalenessCheckerInterface
     */
    private $stalenessChecker;

    /**
     * Class constructor
     *
     * @param string                                    $sourceFolder     the base path where the less files resides
     * @param string                                    $sourceFile       the less file at the base of your project
     * @param string                                    $destination      the path to the css file of destination
     * @param null                                      $name             the project name
     * @param \LessElephant\LessBinary|null             $lessBinary       a LessBinary instance
     *
     * @internal param \CompassElephant\CompassBinary|null $compassBinary a CompassBinary instance
     * @internal param mixed $stalenessChecker a StalenessCheckerInterface instance
     * @internal param string $configFile the compass config file name
     * @internal param bool $autoInit whether to call init() on an empty folder project
     *
     * @internal param \CompassElephant\CommandCaller $commandCaller a CommandCaller instance
     */
    public function __construct($sourceFolder, $sourceFile, $destination, $name = null, LessBinary $lessBinary = null)
    {
        if (!is_file($destination)) {
            throw new \InvalidArgumentException(sprintf('The destination given (%s) is not a file', $destination));
        }
        if (!is_writable($destination)) {
            throw new \InvalidArgumentException(sprintf('LessElephant is not able to write in the given path %s', $destination));
        }

        $this->sourceFolder = $sourceFolder;
        $this->sourceFile = $sourceFile;

        if ($lessBinary == null) {
            $lessBinary = new LessBinary();
        }
        $this->lessBinary = $lessBinary;

        $this->commandCaller = new CommandCaller($sourceFolder, $sourceFile, $destination, $lessBinary);
        $this->stalenessChecker = new FinderStalenessChecker($sourceFolder, $destination);
    }

    /**
     * Check if the project is up-to-date or needs to be recompiled
     *
     * @return bool
     */
    public function isClean()
    {
        return $this->stalenessChecker->isClean();
    }

    /**
     * Compile the project
     */
    public function compile()
    {
        $this->commandCaller->compile();
    }

    /**
     * @param \CompassElephant\CommandCaller $commandCaller
     */
    public function setCommandCaller($commandCaller)
    {
        $this->commandCaller = $commandCaller;
    }

    /**
     * @return \CompassElephant\CommandCaller
     */
    public function getCommandCaller()
    {
        return $this->commandCaller;
    }

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param \LessElephant\LessBinary $lessBinary
     */
    public function setLessBinary($lessBinary)
    {
        $this->lessBinary = $lessBinary;
    }

    /**
     * @return \LessElephant\LessBinary
     */
    public function getLessBinary()
    {
        return $this->lessBinary;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $sourceFile
     */
    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;
    }

    /**
     * @return string
     */
    public function getSourceFile()
    {
        return $this->sourceFile;
    }

    /**
     * @param string $sourceFolder
     */
    public function setSourceFolder($sourceFolder)
    {
        $this->sourceFolder = $sourceFolder;
    }

    /**
     * @return string
     */
    public function getSourceFolder()
    {
        return $this->sourceFolder;
    }

    /**
     * @param \CompassElephant\StalenessChecker\StalenessCheckerInterface $stalenessChecker
     */
    public function setStalenessChecker($stalenessChecker)
    {
        $this->stalenessChecker = $stalenessChecker;
    }

    /**
     * @return \CompassElephant\StalenessChecker\StalenessCheckerInterface
     */
    public function getStalenessChecker()
    {
        return $this->stalenessChecker;
    }

}
