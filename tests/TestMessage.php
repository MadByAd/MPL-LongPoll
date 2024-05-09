<?php

use MadByAd\MPLLongPoll\LongPoll;
use PHPUnit\Framework\TestCase;

final class TestMessage extends TestCase
{

    public function testSendingMessage()
    {

        LongPoll::informPeer("madbyad", [
            "message" => "Hello World"
        ]);

        LongPoll::informPeer("madbyad", [
            "message" => "How are you?"
        ]);

        LongPoll::informPeer("madbyad", [
            "message" => "Are you okay?"
        ]);

        $this->assertTrue(true);

    }

}
