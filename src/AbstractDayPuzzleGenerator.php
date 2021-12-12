<?php

namespace AdventOfCode;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

abstract class AbstractDayPuzzleGenerator implements PuzzleGeneratorInterface
{
    abstract protected function getNamespace(): string;

    abstract protected function getBaseDir(): string;

    public function generateDay(int $day, bool $force = false)
    {
        $dayDir = 'Day' . $day;
        $dayFullDir = $this->getBaseDir() . DIRECTORY_SEPARATOR . $dayDir;

        // delete existing directory with content in it
        if ($force && file_exists($dayFullDir) && is_dir($dayFullDir)) {
            self::deleteDir($dayFullDir);
        }

        if (file_exists($dayFullDir) && is_dir($dayFullDir)) {
            throw new \Exception(sprintf('Directory for Day %s already exists', $day));
        }

        if (!mkdir($dayFullDir, 0777, true) && !is_dir($dayFullDir)) {
            throw new \Exception(sprintf('Could not create a directory for Day %s', $day));
        }

        self::copyTemplatesToDirectory($day, $dayFullDir);
    }

    public function populateInputFile(int $day, string $content): void
    {
        $dayDir = 'Day' . $day;
        $inputFile = $this->getBaseDir() . DIRECTORY_SEPARATOR . $dayDir . DIRECTORY_SEPARATOR . 'input.txt';

        if (!file_exists($inputFile)) {
            throw new \Exception(sprintf('Input file for Day %s does not exist', $day));
        }

        file_put_contents($inputFile, $content);
    }

    private function deleteDir(string $dir): void
    {
        $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }

    private function copyTemplatesToDirectory(int $day, string $dir)
    {
        $namespace = $this->getNamespace() . '\\Day' . $day;
        $templateDirectory = $this->getBaseDir() . DIRECTORY_SEPARATOR . 'Template';
        $files = new \DirectoryIterator($templateDirectory);
        /** @var \SplFileInfo $file */
        foreach ($files as $file) {
            if ($file->isDot()) {
                continue;
            }

            $content = file_get_contents($file->getRealPath());
            if ($file->getExtension() === 'php') {
                $content = str_replace('{{{namespace}}}', $namespace, $content);
            }
            file_put_contents($dir . DIRECTORY_SEPARATOR . $file->getFilename(), $content);
        }
    }
}