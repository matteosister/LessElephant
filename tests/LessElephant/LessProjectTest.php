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

use LessElephant\TestCase;

/**
 * LessElephantTest
 *
 * @author Matteo Giachino <matteog@gmail.com>
 */

class LessProjectTest extends TestCase
{
    public function setUp()
    {
        $this->initProject();
    }

    public function testBinary()
    {
        $this->assertTrue($this->lessProject->isClean());
        var_dump($this->sourceFolder);
        $this->writeStyle($this->sourceFolder.DIRECTORY_SEPARATOR.$this->sourceFile, '
@color: #4D926F;

#header {
  color: @color;
}
h2 {
  color: @color;
}');

        $this->assertFalse($this->lessProject->isClean());
        $this->lessProject->compile();
        $this->assertTrue($this->lessProject->isClean());

        $this->assertEquals('#header {
  color: #4d926f;
}
h2 {
  color: #4d926f;
}
', file_get_contents($this->destination));
    }

    public function testDependencies()
    {
        $this->writeStyle($this->depFile, '@color: #FFF;');
        $this->writeStyle($this->sourceFolder.DIRECTORY_SEPARATOR.$this->sourceFile, '@import "vars"; a { color: @color; }');
        $this->lessProject->compile();
        $this->assertTrue($this->lessProject->isClean());
        $this->writeStyle($this->depFile, '@color: #000');
        $this->assertFalse($this->lessProject->isClean());
    }
}
