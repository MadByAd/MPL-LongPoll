<?php

use MadByAd\MPLLongPoll\LongPoll;
use PHPUnit\Framework\TestCase;

final class TestRead extends TestCase
{

    public function testReadingMessage()
    {

        ob_start();
        LongPoll::readAsPeer("madbyad", false);
        $message = json_decode(ob_get_clean(), true);
        $message1 = $message[0]["message"];
        $message2 = $message[1]["message"];
        $message3 = $message[2]["message"];

        $this->assertSame("Hello World", $message1);
        $this->assertSame("How are you?", $message2);
        $this->assertSame("Are you okay?", $message3);

    }

}
