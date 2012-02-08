<?php

/**
 * This file is part of the LessElephant package.
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
 * LessProject
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
     * @var \LessElephant\CommandCaller
     */
    private $commandCaller;

    /**
     * @var \LessElephant\StalenessChecker\StalenessCheckerInterface
     */
    private $stalenessChecker;

    /**
     * Class constructor
     *
     * @param string                        $sourceFolder the base path where the less files resides
     * @param string                        $sourceFile   the less file at the base of your project
     * @param string                        $destination  the path to the css file of destination
     * @param null                          $name         the project name
     * @param \LessElephant\LessBinary|null $lessBinary   a LessBinary instance
     *
     * @internal param \LessElephant\LessBinary|null $lessBinary a LessBinary instance
     * @internal param mixed $stalenessChecker a StalenessCheckerInterface instance
     * @internal param \LessElephant\CommandCaller $commandCaller a CommandCaller instance
     */
    public function __construct($sourceFolder, $sourceFile, $destination, $name = null, LessBinary $lessBinary = null)
    {
        if (!is_file($destination)) {
            try {
                touch($destination);
            } catch (\Exception $e) {
                throw new \InvalidArgumentException(sprintf('LessElephant is unable to create the given destination css. Error: %s', $e->getMessage()));
            }
        }
        if (!is_writable($destination)) {
            throw new \InvalidArgumentException(sprintf('LessElephant is not able to write in the given path %s', $destination));
        }

        $this->sourceFolder = $sourceFolder;
        $this->sourceFile = $sourceFile;
        $this->destination = $destination;

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
     * commandCaller setter
     *
     * @param \LessElephant\CommandCaller $commandCaller CommandCaller instance
     */
    public function setCommandCaller($commandCaller)
    {
        $this->commandCaller = $commandCaller;
    }

    /**
     * commandCaller getter
     *
     * @return \LessElephant\CommandCaller
     */
    public function getCommandCaller()
    {
        return $this->commandCaller;
    }

    /**
     * destination setter
     *
     * @param string $destination the destination css path
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * destinaton getter
     *
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * LessBinary setter
     *
     * @param \LessElephant\LessBinary $lessBinary LessBinary instance
     */
    public function setLessBinary($lessBinary)
    {
        $this->lessBinary = $lessBinary;
    }

    /**
     * LessBinary getter
     *
     * @return \LessElephant\LessBinary
     */
    public function getLessBinary()
    {
        return $this->lessBinary;
    }

    /**
     * name setter
     *
     * @param string $name the project name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * name getter
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * sourceFile setter
     *
     * @param string $sourceFile source less file
     */
    public function setSourceFile($sourceFile)
    {
        $this->sourceFile = $sourceFile;
    }

    /**
     * sourceFile getter
     *
     * @return string
     */
    public function getSourceFile()
    {
        return $this->sourceFile;
    }

    /**
     * sourceFolder setter
     *
     * @param string $sourceFolder the source folder where your less files resides
     */
    public function setSourceFolder($sourceFolder)
    {
        $this->sourceFolder = $sourceFolder;
    }

    /**
     * sourceFolder getter
     *
     * @return string
     */
    public function getSourceFolder()
    {
        return $this->sourceFolder;
    }

    /**
     * stalenessChecker setter
     *
     * @param \LessElephant\StalenessChecker\StalenessCheckerInterface $stalenessChecker StalenessCheckerInterface instance
     */
    public function setStalenessChecker($stalenessChecker)
    {
        $this->stalenessChecker = $stalenessChecker;
    }

    /**
     * stalenessChecker getter
     *
     * @return \LessElephant\StalenessChecker\StalenessCheckerInterface
     */
    public function getStalenessChecker()
    {
        return $this->stalenessChecker;
    }

}
