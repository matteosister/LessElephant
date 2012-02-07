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

namespace LessElephant\StalenessChecker;

use LessElephant\StalenessChecker\StalenessCheckerInterface;
use Symfony\Component\Finder\Finder;

/**
 * FinderStalenessChecker
 *
 * a staleness checker using symfony finder component
 *
 * @author Matteo Giachino <matteog@gmail.com>
 */

class FinderStalenessChecker implements StalenessCheckerInterface
{
    private $sourceFolder;
    private $destination;

    /**
     * class constructor
     *
     * @param string $sourceFolder the path to the less project
     * @param string $destination  the css destination file name
     */
    public function __construct($sourceFolder, $destination)
    {
        $this->sourceFolder = $sourceFolder;
        $this->destination  = $destination;
    }

    /**
     * return true if the project do not need to be recompiled
     *
     * @return boolean
     */
    public function isClean()
    {
        if ($this->getSourceMaxAge() > $this->getDestinationAge()) {
            return false;
        }
        return true;
    }

    /**
     * Get the max_age of stylesheets files
     *
     * @return int
     */
    private function getDestinationAge()
    {
        return filemtime($this->destination);
    }

    /**
     * get the max_age of sass/scss files
     *
     * @return int
     */
    private function getSourceMaxAge()
    {
        return $this->getFilesMaxAge($this->sourceFolder, array('*.less'));
    }

    /**
     * Get max_age with a Finder instance
     *
     * @param string $path    the path for the Finder instance
     * @param string $names   the file names
     * @param int    $default the default time if no files are found
     *
     * @return int
     */
    private function getFilesMaxAge($path, $names = array(), $default = 0)
    {
        $finder = new Finder();
        $finder->files()->in(realpath($path))->ignoreDotFiles(true);
        foreach ($names as $name) {
            $finder->name($name);
        }
        $ages = array();
        foreach ($finder as $file) {
            $ages[] = filemtime($file);
        }
        return max(array_merge($ages, array($default)));
    }
}
