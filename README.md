
# MPL Long Poll

The MPL (MadByAd PHP Library) Long Poll is a library purposely created for providing an easy interface to implement a real time communication with HTTP Long Polling. Although HTTP Long Polling may be an outdated technique (because of WebSocket), it is easier to implement in PHP rather than Websocket, and can be used to create a seamless real time communication (though there may be slight delay in seconds)

- [MPL Long Poll](#mpl-long-poll)
  - [LongPoll Class](#longpoll-class)
    - [informPeer()](#informpeer)
    - [readAsPeer()](#readaspeer)
    - [setQueryTime()](#setquerytime)
    - [setJsonFlags()](#setjsonflags)
  - [Example](#example)
    - [Example 1](#example-1)
    - [Example 2](#example-2)

## LongPoll Class

The `LongPoll` class is used to provide an easy way to implement real time communication with HTTP Long Polling

### informPeer()

The `LongPoll::informPeer(string $id, array $data)` method is used for sending a message (data) to the given peer. This method takes 2 parameter, the first is the peer id and the second is the data which should be in an associative array

### readAsPeer()

The `LongPoll::readAsPeer(string $id, bool $endExecution = true)` method is used for reading message (data) as the given peer. This method takes 1 parameter and 1 optional parameter, the parameter is the peer id and the optional parameter determine whether to end the execution after reading the message (data) by default it is set to `TRUE`

### setQueryTime()

The `LongPoll::setQueryTime(int $second)` method is use to set the query time (in seconds) the lower the query time the more responsive it is but more resource intensive it will be, the higher the query time the less responsive it is but less resource intensive it will be

### setJsonFlags()

The `LongPoll::setJsonFlags(int $flags)` method is use to set the how the JSON message is formatted (only for debugging use). The list of avaible format is

* `JSON_HEX_QUOT`
* `JSON_HEX_TAG`
* `JSON_HEX_AMP`
* `JSON_HEX_APOS`
* `JSON_NUMERIC_CHECK`
* `JSON_PRETTY_PRINT`
* `JSON_UNESCAPED_SLASHES`
* `JSON_FORCE_OBJECT`
* `JSON_UNESCAPED_UNICODE`
* `JSON_THROW_ON_ERROR`

## Example

Here is two example of How Long Polling works

### Example 1

First we will create `read.php` and we will write

```php
<?php

use MadByAd\MPLLongPoll\LongPoll;

require __DIR__."/autoload.php";

LongPoll::readAsPeer("madbyad");
```

Now if we execute `read.php` with the `php read.php` you will notice that the script won't stop executing, thats because Long Polling is a technique were you only send 1 request and then the server will keep querying until it gets a message and after that it will return the message, or in this case we execute the script once and the script will keep querying until it gets a message and after that it will stop and return the message

Now go ahead and create `send.php` and write

```php
<?php

use MadByAd\MPLLongPoll\LongPoll;

require __DIR__."/autoload.php";

// this is only for debugging
// this is so we can read the json easily
LongPoll::setJsonFlags(JSON_PRETTY_PRINT);

LongPoll::informPeer("madbyad", [
    "message" => $argv[1],
]);
```

Now if we open a new terminal and execute `php send.php "Hello World"` you will notice that the first terminal will immediately stop or stop after a while which depends on the query time you have set to and output something like this

```
[
    {
        "message" => "Hello World"
    }
]
```

thats because when the script querries a message, it detected a message and thus it will output the message and stop the execution

this is essentially how real time communication with HTTP Long Polling works. The client only send 1 request to the server, then the server will receive the request and began querrying / checking for message every `n` second, and if a message does exist, it will immediately return the message to the client, and when the client receive the message it will send another request to check new messages

### Example 2

Here is another example, this time instead of closing after receiveng a message we will continue messaging

First we will create `read.php` and we will write

```php
<?php

use MadByAd\MPLLongPoll\LongPoll;

require __DIR__."/autoload.php";

function read() {
    LongPoll::readAsPeer("madbyad", false);
    read();
}

read();
```

In this example we set the second parameter to `FALSE` which means instead of stopping it will continue to execute

Now if we open a new terminal and execute `php send.php "Hello World"` after a while the first terminal should receive the message. Something like this

```
[
    {
        "message" => "Hello World"
    }
]
```

and instead of stopping it will continue. now if we open a new terminal and execute `php send.php "Hello World"` after a while the first terminal should receive the message

Now in the second terminal go ahead an execute `php send.php "How Are you?"` after a while the first terminal should receive the message

```
[
    {
        "message" => "Hello World"
    },
    {
        "message" => "How Are you?"
    }
]
```

Well done you have succesfully communicated with two terminal

To end process simply kill the terminal
