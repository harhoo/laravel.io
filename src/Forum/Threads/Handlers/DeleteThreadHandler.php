<?php namespace Lio\Forum\Threads\Handlers; 

use Lio\Core\Handler;
use Lio\Forum\Forum;
use Lio\Forum\Threads\ThreadRepository;
use Mitch\EventDispatcher\Dispatcher;

class DeleteThreadHandler implements Handler
{
    /**
     * @var \Lio\Forum\Forum
     */
    private $forum;
    /**
     * @var \Lio\Forum\Threads\ThreadRepository
     */
    private $repository;
    /**
     * @var \Mitch\EventDispatcher\Dispatcher
     */
    private $dispatcher;

    public function __construct(Forum $forum, ThreadRepository $repository, Dispatcher $dispatcher)
    {
        $this->forum = $forum;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function handle($command)
    {
        $thread = $this->forum->deleteThread($command->thread);
        $this->repository->delete($thread);
        $this->dispatcher->dispatch($this->forum->releaseEvents());
        return $thread;
    }
}
