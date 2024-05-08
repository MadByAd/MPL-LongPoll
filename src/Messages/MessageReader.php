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

namespace MadByAd\MPLLongPoll\Messages;

/**
 *
 * The MessageReader class is used for reading message
 *
 * @author    MadByAd <adityaaw84@gmail.com>
 *
 */

trait MessageReader
{

    /**
     * Query a message
     *
     * @param string $path      The path
     * @param int    $queryTime The query time
     *
     * @return string The contents of the message
     */

    protected static function queryMessage(string $path, int $queryTime)
    {

        while(!file_exists($path)) {
            sleep($queryTime);
        }

        $content = file_get_contents($path);
        unlink($path);

        return $content;

    }

    /**
     * Read a message
     *
     * @param string $path The path
     *
     * @return array The message data
     */

    protected static function readMessage(string $path)
    {
        if(!file_exists($path)) {
            return [];
        }
        return json_decode(file_get_contents($path));
    }

    /**
     * Write a message (data)
     *
     * @param string $path The path
     * @param array  $data The data
     *
     * @return void
     */

    protected static function writeMessage(string $path, array $data, int $jsonFlags)
    {
        $file = fopen($path, "w");
        fwrite($file, json_encode($data, $jsonFlags));
        fclose($file);
    }

}
