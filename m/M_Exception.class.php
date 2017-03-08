<?php

class M_Exception
{
    const ERR_LOG = "../errors.log";

    public function test($condition, $eMessage)
    {
        try {
            if (!$condition)
                throw new Exception($eMessage);
            return true;
        } catch (Exception $eMessage) {
            file_put_contents(self::ERR_LOG, time() . " " . $eMessage->getMessage() . PHP_EOL, FILE_APPEND | LOCK_EX);
        }
        return false;
    }

    public function clearLog()
    {
        file_put_contents(self::ERR_LOG, '');
    }
}