<?php

namespace App\Services\ProcessingEmail;

use App\Services\ProcessingEmail\CheckEmailServices\CheckBlackList;
use App\Services\ProcessingEmail\CheckEmailServices\CheckBlackMask;

class CheckServices
{
    /**
     * @var CheckBlackList
     */
    private CheckBlackList $checkBlackList;
    /**
     * @var CheckBlackMask
     */
    private CheckBlackMask $checkBlackMask;

    /**
     * CheckServices constructor.
     * @param CheckBlackList $checkBlackList
     * @param CheckBlackMask $checkBlackMask
     */
    public function __construct(CheckBlackList $checkBlackList, CheckBlackMask $checkBlackMask)
    {
        $this->checkBlackList = $checkBlackList;
        $this->checkBlackMask = $checkBlackMask;
    }

    /**
     * @param string $email
     * @return string
     */
    public function check(string $email)
    {
        if ($this->checkBlackList->check($email) != "ok") {
            return "Error email data is black list!";
        }

        if ($this->checkBlackMask->check($email) != "ok") {
            return "Error email mask black list!";
        }

        return "ok";
    }
}
