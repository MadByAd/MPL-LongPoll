<?php

/**
 *
 * This file is a part of the MadByAd\MPLLongPoll
 *
 * @author    MadByAd <adityaaw84@gmail.com>
 * @license   MIT License
 * @copyright Copyright (c) MadByAd 2024
 *
 */

namespace MadByAd\MPLLongPoll;

use MadByAd\MPLLongPoll\Messages\MessageReader;
use UnderflowException;

/**
 *
 * The Long Poll class is used to provide an easy way to implement real time
 * communication with HTTP Long Polling
 *
 * @author    MadByAd <adityaaw84@gmail.com>
 * @license   MIT License
 * @copyright Copyright (c) MadByAd 2024
 *
 */

class LongPoll
{

    use MessageReader;

    /**
     * Store the folder path where all the messages are stored
     *
     * @var string
     */

    protected static string $folder = __DIR__."/Messages";

    /**
     * Store the query time (in second)
     *
     * @var int
     */

    protected static int $queryTime = 3;

    /**
     * Store the json flags
     *
     * @var int
     */

    protected static int $jsonFlags = 0;

    /**
     * Set the query time to the given amount of second
     *
     * @param int $second The query time
     *
     * @return void
     */

    public static function setQueryTime(int $second)
    {
        self::$queryTime = $second;
    }

    /**
     * Set the json flags
     *
     * @param int $flags The json flags consisting of `JSON_HEX_QUOT`,
     *                   `JSON_HEX_TAG`, `JSON_HEX_AMP`, `JSON_HEX_APOS`,
     *                   `JSON_NUMERIC_CHECK`, `JSON_PRETTY_PRINT`,
     *                   `JSON_UNESCAPED_SLASHES`, `JSON_FORCE_OBJECT`,
     *                   `JSON_UNESCAPED_UNICODE`. `JSON_THROW_ON_ERROR`
     *
     * @return void
     */

    public static function setJsonFlags(int $flags)
    {
        self::$jsonFlags = $flags;
    }

    /**
     * Inform the given peer about a new message (data)
     *
     * @param string $id   The peer id
     * @param array  $data The new message (data)
     *
     * @return void
     */

    public static function informPeer(string $id, array $data)
    {

        $path = self::$folder."/{$id}";

        $messages = self::readMessage($path);
        $messages[] = $data;

        self::writeMessage($path, $messages, self::$jsonFlags);

    }

    /**
     * Read the message as the given peer
     *
     * @param string $id           The peer id
     * @param bool   $endExecution Determine whether end the execution after
     *                             getting a message default value is `TRUE`
     *
     * @return void
     */

    public static function readAsPeer(string $id, bool $endExecution = true)
    {

        ini_set('max_execution_time', '0');

        $data = self::queryMessage(self::$folder."/{$id}", self::$queryTime);

        echo $data;

        if($endExecution) {
            exit;
        }

    }

}
