<?php

namespace Laravel\Dusk;

/**
 * This is the dotenv class.
 *
 * It's responsible for loading a `.env` file in the given directory and
 * setting the environment vars.
 */
class Dotenv
{
    /**
     * The file path.
     *
     * @var string
     */
    protected $filePath;

    /**
     * The loader instance.
     *
     * @var \Laravel\Dusk\Loader
     */
    protected $loader;

    /**
     * Create a new dotenv instance.
     *
     * @param string $path
     * @param string $file
     */
    public function __construct($path, $file = '.env')
    {
        $this->filePath = $this->getFilePath($path, $file);
        $this->loader = new Loader($this->filePath, true);
    }

    /**
     * Load environment file in given directory.
     *
     * @throws \Laravel\Dusk\Exception\InvalidFileException
     * @throws \Laravel\Dusk\Exception\InvalidPathException
     *
     * @return array
     */
    public function load()
    {
        return $this->loadData();
    }

    /**
     * Load environment file in given directory.
     *
     * @throws \Laravel\Dusk\Exception\InvalidFileException
     * @throws \Laravel\Dusk\Exception\InvalidPathException
     *
     * @return array
     */
    public function overload()
    {
        return $this->loadData(true);
    }

    /**
     * Returns the full path to the file.
     *
     * @param string $path
     * @param string $file
     *
     * @return string
     */
    protected function getFilePath($path, $file)
    {
        if (! is_string($file)) {
            $file = '.env';
        }

        return rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;
    }

    /**
     * Actually load the data.
     *
     * @param bool $overload
     *
     * @throws \Laravel\Dusk\Exception\InvalidFileException
     * @throws \Laravel\Dusk\Exception\InvalidPathException
     *
     * @return array
     */
    protected function loadData($overload = false)
    {
        $this->loader = new Loader($this->filePath, ! $overload);

        return $this->loader->load();
    }

    /**
     * Required ensures that the specified variables exist, and returns a new validator object.
     *
     * @param string|string[] $variable
     *
     * @throws \Laravel\Dusk\Exception\ValidationException
     * @throws \Laravel\Dusk\Exception\InvalidCallbackException
     *
     * @return \Laravel\Dusk\Validator
     */
    public function required($variable)
    {
        return new Validator((array) $variable, $this->loader);
    }
}
