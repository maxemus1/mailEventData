<?php

namespace App\Console;

use App\Model\DelayedQueue;
use App\Model\Queue;
use Symfony\Component\Console\Output\OutputInterface;
use App\Services\DelayedQueue\CheckMailingService;

class ToQueueCommand
{
    /**
     * @var Queue
     */
    private Queue $queue;
    /**
     * @var CheckMailingService
     */
    private CheckMailingService $checkStatusDispatchServices;
    /**
     * @var DelayedQueue
     */
    private DelayedQueue $delayed;

    const SUCCESS = 'Success';
    const STATUS = '0';

    /**
     * ToQueueCommand constructor.
     * @param Queue $queue
     * @param CheckMailingService $checkMailingService
     * @param DelayedQueue $delayedQueueServices
     */
    public function __construct(Queue $queue, CheckMailingService $checkMailingService, DelayedQueue $delayedQueueServices)
    {
        $this->queue = $queue;
        $this->checkStatusDispatchServices = $checkMailingService;
        $this->delayed = $delayedQueueServices;
    }

    /**
     * @param OutputInterface $output
     * @return string
     */
    public function __invoke(OutputInterface $output)
    {
        for ($i = 0; $i <= 99; $i++) {
            $queueData = $this->delayed->getOneEntry();
            if (empty($queueData)) {

                print_r(self::SUCCESS);
                return self::SUCCESS;
            } else {

                if ($this->checkStatusDispatchServices->check($queueData['service'], self::STATUS)) {
                    $this->queue->store($queueData);
                    $this->delayed->delete($queueData['id']);
                }
            }
            //   sleep(15);
        }

        print_r(self::SUCCESS);
        return self::SUCCESS;
    }
}
