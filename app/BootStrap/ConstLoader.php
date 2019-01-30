<?php

namespace App\Bootstrap;

use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;
use Illuminate\Contracts\Foundation\Application;

class ConstLoader
{
    protected $constPath;

    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->constPath = $app->basePath();

        $items = [];
        $app->instance('constant', $config = new Repository($items));

        foreach ($this->getConfigurationFiles($app) as $key => $path) {
            $config->set($key, require $path);
        }
    }

    protected function getConfigurationFiles(Application $app)
    {
        $files = [];

        foreach (Finder::create()->files()->name('*.php')->in($this->constPath . DIRECTORY_SEPARATOR . 'constant') as $file) {
            $nesting = $this->getConfigurationNesting($file);

            $files[$nesting.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    private function getConfigurationNesting($file)
    {
        $directory = dirname($file->getRealPath());

        if ($tree = trim(str_replace($this->constPath . DIRECTORY_SEPARATOR . 'constant', '', $directory), DIRECTORY_SEPARATOR)) {
            $tree = str_replace(DIRECTORY_SEPARATOR, '.', $tree).'.';
        }

        return $tree;
    }

}
