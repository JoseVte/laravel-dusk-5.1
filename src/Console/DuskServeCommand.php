<?php

namespace Laravel\Dusk\Console;

use RuntimeException;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\ProcessBuilder;

class DuskServeCommand extends DuskCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dusk:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application and run Dusk tests';

    /**
     * @var Process
     */
    protected $serve;

    /**
     * Execute the console command.
     *
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     * @throws \Laravel\Dusk\Exception\InvalidPathException
     * @throws \Laravel\Dusk\Exception\InvalidFileException
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \InvalidArgumentException
     *
     * @return mixed
     */
    public function handle()
    {
        // Snippets copied from DuskCommand::handle()
        $this->purgeScreenshots();

        $this->purgeConsoleLogs();

        return $this->withDuskEnvironment(function () {
            // Start the Web Server AFTER Dusk handled the environment, but before running PHPUnit
            $serve = $this->serve();

            // Run PHP Unit
            return $this->runPhpunit();
        });
    }

    /**
     * Snippet copied from DuskCommand::handle() to actually run PHP Unit
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     *
     * @return int
     */
    protected function runPhpunit()
    {
        $options = array_slice($_SERVER['argv'], 2);

        $process = (new ProcessBuilder())
            ->setTimeout(null)
            ->setPrefix($this->binary())
            ->setArguments($this->phpunitArguments($options))
            ->getProcess();

        try {
            $process->setTty(true);
        } catch (RuntimeException $e) {
            $this->output->writeln('Warning: ' . $e->getMessage());
        }

        return $process->run(function ($type, $line) {
            $this->output->write($line);
        });
    }

    /**
     * Build a process to run php artisan serve
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Process\Exception\RuntimeException
     * @throws \Symfony\Component\Process\Exception\LogicException
     * @throws \Symfony\Component\Process\Exception\InvalidArgumentException
     *
     * @return Process
     */
    protected function serve()
    {
        // Compatibility with Windows and Linux environment
        $arguments = [PHP_BINARY, 'artisan', 'serve'];

        // Build the process
        $serve = (new ProcessBuilder($arguments))
            ->setTimeout(null)
            ->setOption('port', config('dusk.port-serve', 8000))
            ->getProcess();

        return tap($serve, function (Process $serve) {
            $serve->start(function ($type, $line) {
                $this->output->writeln($line);
            });
        });
    }
}
