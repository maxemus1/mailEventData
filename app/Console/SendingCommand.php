<?php

namespace App\Console;

use Symfony\Component\Console\Output\OutputInterface;
use App\Services\SendingService;
use App\Model\Queue;
use App\Services\DelayedQueue\CheckMailingService;
use App\Model\DelayedQueue;

class SendingCommand
{
    /**
     * @var SendingService
     */
    private SendingService $sending;
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

    const STATUS = '1';
    const SUCCESS = 'success';

    /**
     * SendingCommand constructor.
     * @param SendingService $sendingService
     * @param Queue $queue
     * @param CheckMailingService $checkMailingService
     * @param DelayedQueue $delayedQueueServices
     */
    public function __construct(SendingService $sendingService, Queue $queue, CheckMailingService $checkMailingService, DelayedQueue $delayedQueueServices)
    {
        $this->sending = $sendingService;
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
            $queueData = $this->queue->getOneEntry();

            if (empty($queueData)) {

                print_r(self::SUCCESS);
                return self::SUCCESS;
            } else {
                if ($this->checkStatusDispatchServices->check($queueData['service'], self::STATUS)) {
                    $this->delayed->toDelayedQueue($queueData);
                    $this->queue->delete($queueData['id']);
                } else {
                    $queueData = $this->queue->getOneEntry();
                    $this->sending->sending($queueData);
                    $this->queue->delete($queueData['id']);
                }
            }
            //   sleep(15);
        }

        print_r(self::SUCCESS);
        return self::SUCCESS;
    }
}
