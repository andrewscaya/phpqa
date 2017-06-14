<?php

namespace Edge\QA;

class IgnoredPaths
{
    private $ignoreDirs;
    private $ignoreFiles;
    private $ignoreBoth;

    public function __construct($ignoredDirs, $ignoredFiles)
    {
        $this->ignoreDirs = $this->csvToArray($ignoredDirs);
        $this->ignoreFiles = $this->csvToArray($ignoredFiles);
        $this->ignoreBoth = array_merge($this->ignoreDirs, $this->ignoreFiles);
    }

    private function csvToArray($csv)
    {
        return array_filter(explode(',', $csv), 'trim');
    }

    public function phpcs()
    {
        return $this->ignore(' --ignore=*/', '/*,*/', '/*', ',');
    }

    // pdepend and phpmd use the same filter for their files
    // https://github.com/pdepend/pdepend/blob/master/src/main/php/PDepend/Input/ExcludePathFilter.php
    // rule1: you need /* after any directory to get all the insides, how annoying
    // rule2: SLASHES MATTER - so on windows you CANNOT use forward slashes!
    // this is a quick and dirty fix, I could probably buckle down and make it nice
    // and I don't care about files so no files are done here, I know, bad me, WORK WORK WORK DANGIT
    public function pdepend($list_only = false)
    {
        // first we force slashes
        $ignores = $this->ignoreDirs;
        foreach($ignores as $key => $path) {
            $ignores[$key] = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
        }
        
        // then we pop \* versions for all the things
        foreach($ignores as $path) {
            $ignores[] = $path . DIRECTORY_SEPARATOR . '*';
        }
        
        if($list_only) {
            return $ignores;
        }
        
        return $this->implode($ignores, ' --ignore', ',', '');
    }

    public function phpmd()
    {
        //build our list identically to what we did for pdepends madness
        $list = $this->pdepend(true);
        
        // return with --exclude instead of --ignore - SILLY THINGS
        return $this->implode($ignores, ' --exclude', ',', '');
    }

    public function phpmetrics()
    {
        return $this->ignore(' --excluded-dirs="', '|', '"');
    }

    public function phpmetrics2()
    {
        return $this->ignore(' --exclude="', ',', '"');
    }

    public function bergmann()
    {
        return $this->ignore(' --exclude=', ' --exclude=', '');
    }

    public function parallelLint()
    {
        return $this->ignore(' --exclude ', ' --exclude ', '');
    }

    public function phpstan()
    {
        return $this->ignoreBoth;
    }

    private function ignore($before, $dirSeparator, $after, $fileSeparator = null)
    {
        if ($fileSeparator) {
            if ($this->ignoreDirs) {
                $files = $this->implode($this->ignoreFiles, $fileSeparator, $fileSeparator);
                return $this->implode($this->ignoreDirs, $before, $dirSeparator, "{$after}{$files}");
            } else {
                $ignoredFiles = $this->implode($this->ignoreFiles, $before, $fileSeparator);
                return str_replace('*/', '', $ignoredFiles); // phpcs hack
            }
        } else {
            return $this->implode($this->ignoreBoth, $before, $dirSeparator, $after);
        }
    }

    private function implode(array $input, $before, $separator, $after = '')
    {
        return $input && $separator ? ($before . implode($separator, $input) . $after) : '';
    }
}
