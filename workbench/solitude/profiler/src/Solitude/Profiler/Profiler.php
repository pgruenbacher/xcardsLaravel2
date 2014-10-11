<?php namespace Solitude\Profiler;

Use Illuminate\View\Environment;
use Illuminate\Config\Repository;

class Profiler{
	
	 /**
     * Added checkpoints.
     *
     * @var array
     */
    protected $checkpoints = array();
	/**
     * Illuminate view environment.
     *
     * @var Illuminate\View\Environment
     */
    protected $view;
	/**
     * Illuminate config repository.
     *
     * @var Illuminate\Config\Repository
     */
    protected $config;
	 /**
     * Create a new profiler instance.
     *
     * @param  Illuminate\View\Environment  $view
     * @return void
     */
    public function __construct(Environment $view, Repository $config)
    {
        $this->view = $view;
		$this->config=$config;
    }
	/**
	 * Enable the profiler.
	 *
	 * @return void
	 */
	public function enable()
	{
	    $this->config->set('profiler::enabled', true);
	}
	
	/**
	 * Disable the profiler.
	 *
	 * @return void
	 */
	public function disable()
	{
	    $this->config->set('profiler::enabled', false);
	}

    /**
     * Add a new checkpoint.
     *
     * @return void
     */
    public function addCheckpoint()
    {
        $checkpointTime = microtime(true);

        // Grab a debug backtrace array so we can use the line and file name being used to add
        // a checkpoint.
        $trace = debug_backtrace();

        // Build the variables to be used in our checkpoint message.
        $number = count($this->checkpoints) + 1;

        $line = $trace[0]['line'];

        $file = $trace[0]['file'];

        $executionTime = round($checkpointTime - $this->getStartTime(), 4);

        $this->checkpoints[] = compact('number', 'line', 'file', 'executionTime');
    }
	 /**
     * Generate and return a report.
     *
     * @return Illuminate\View\View
     */
    public function generateReport()
    {
        $checkpoints = $this->checkpoints;

        $totalExecutionTime = round(microtime(true) - LARAVEL_START, 4);

        return $this->view->make('profiler::report', compact('checkpoints', 'totalExecutionTime'));
    }
    /**
     * Get the checkpoints.
     *
     * @return array
     */
    public function getCheckpoints()
    {
        return $this->checkpoints;
    }

    /**
     * Get the start time.
     *
     * @return int
     */
    protected function getStartTime()
    {
        if (defined('LARAVEL_START'))
        {
            return LARAVEL_START;
        }

        return microtime(true);
    }
}
