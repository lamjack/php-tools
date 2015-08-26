<?php
/**
 * Author: jack<linjue@wilead.com>
 * Date: 15/8/26
 */

/**
 * Class HooksLoader
 * @package Git
 */
class HooksLoader
{
    /**
     * @var string
     */
    private $hook;

    /**
     * @var string
     */
    private $location;

    /**
     * @var \FilesystemIterator
     */
    private $fetched;

    /**
     * @var \RegexIterator
     */
    private $filtered;

    /**
     * @var \SplPriorityQueue
     */
    private $sorted;

    /**
     * HooksLoader constructor.
     *
     * @param string $hook
     * @param string $location
     */
    public function __construct($hook, $location)
    {
        $this->hook = pathinfo($hook, PATHINFO_FILENAME);
        $this->location = $location;

        $this->prepare();
        $this->load();
    }

    /**
     *
     */
    public function prepare()
    {
        $this->fetched = $this->fetch();
        $this->fetched->rewind();

        $this->filtered = $this->filter($this->fetched);
        $this->filtered->rewind();

        $this->sorted = $this->sort($this->filtered);
        $this->sorted->rewind();
    }

    /**
     *
     */
    public function load()
    {
        foreach ($this->sorted as $v)
            include_once $this->sorted->current();
    }

    /**
     * @return \FilesystemIterator
     */
    protected function fetch()
    {
        return new \FilesystemIterator(
            $this->location,
            \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS
        );
    }

    /**
     * @param \Iterator $files
     *
     * @return \RegexIterator
     */
    protected function filter(\Iterator $files)
    {
        return new \RegexIterator(
            $files,
            '/(' . $this->hook . ')[\w-]*?\.php/i'
        );
    }

    /**
     * @param \Iterator $files
     *
     * @return \SplPriorityQueue
     */
    protected function sort(\Iterator $files)
    {
        $sorted = new \SplPriorityQueue();
        foreach ($files as $file) {
            preg_match(
                '/\d+/',
                $files->current(),
                $priority
            );
            if (empty($priority))
                continue;

            $sorted->insert($files->current(), $priority[0]);
        }
        return $sorted;
    }
}