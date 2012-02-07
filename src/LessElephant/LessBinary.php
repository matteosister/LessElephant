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

/**
 * CompassBinary
 *
 * @author Matteo Giachino <matteog@gmail.com>
 */

class LessBinary
{
    /**
     * @var null|string the path to the compass executable
     */
    private $path;

    /**
     * class constructor
     *
     * @param null|string $path the path to the compass executable
     */
    public function __construct($path = null)
    {
        $this->path = $path;
        if ($path == null) {
            $this->tryToFindLessExecutable();
        }
    }

    /**
     * Try to find the compass executable
     *
     * WARNING: LINUX/UNIX ONLY
     */
    private function tryToFindLessExecutable()
    {
        $this->path = trim(exec('which lessc'), PHP_EOL);
    }

    /**
     * path getter
     *
     * @return null|string
     */
    public function getPath()
    {
        return $this->path;
    }
}
