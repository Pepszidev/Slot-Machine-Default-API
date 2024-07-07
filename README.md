# EmbedGaming Slot Machine API - Simple Version
Slot machine backend designed for the unity project below. It is designed to be simple as possible so you can customize logic on your own. Multiple other project will follow with more advenced feature. This git will be the base of every  other project.

[Check the presentation video](https://www.youtube.com/watch?v=60-rC2RyDgs )

[Unity Asset Store](https://assetstore.unity.com/packages/slug/289250)

There's currently no probability calculation and win calculation on this api. The math part is reserved for other projects as probabilities are generally unique by project. I don't want it to be specific, at least the less the better.

This API works with $_SESSION to simulate stored data from a database.

# REST API

The REST API to the example app is described below.

## Get balance

### Description

Returns the balance of the $_SESSION user. 

If it's a new user, it initializes its balance at 100. The initial balance amount is stored in config/defaultSettings.php ($initialBalance)

### Request

`POST /reloadBalance.php`

    curl -i -H 'Accept: application/json' -d '' http://localhost/reloadBalance.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"Balance":100}

## Save settings

### Description

Returns the settings of the current user. Settings are stored in the $_SESSION.

If it's a new user (the session does not exist), it initializes the session with the default settings and returns it.

The user can POST his own settings to save it. If the BetAmount is equal zero, that means the user just launched his game and he just wants his session settings and not update it.

### Request

`POST /saveSettings.php`

    curl -i -H 'Accept: application/json' -d 'SoundEnabled=true&FastPlay=false&TurboPlay=false&Intro=false&Volume=1&BetAmount=1' http://localhost/saveSettings.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    { 
        "SoundEnabled" : true,
        "FastPlay" => false,
        "TurboPlay" => false,
        "Intro" => false,
        "Volume" => 1,
        "BetAmount" => 1,
    }

## DoSpin

### Description

Spin the slot machine. This route generates the game. It handles all the logic such as number of symbols, number of reels, etc.

### Request

`POST /doSpin.php`

    curl -i -H 'Accept: application/json' -d 'betAmount=1' http://localhost/doSpin.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {
        "win":true,
        "winAmount":10,
        "betAmount":1,
        "reels": [], //Contains each reel with its symbols
        "winSymbols": [] //Contains each reel with symbol's positions
    }

    Example:

    {
        "win":true,
        "winAmount":10,
        "betAmount":1,
        //Contains 3 reels
        "reels": [
            [
                "reel" => [1,2,1,2,1,2,1,2,1,2,1,2] //1 is symbol1 (10), 2 is symbol2 (Jacks)
            ],
            [
                "reel" => [1,2,1,2,1,2,1,2,1,2,1,2]
            ],
            [
                "reel" => [1,2,1,2,1,2,1,2,1,2,1,2]
            ]
        ],
        "winSymbols": [
            [
                //Line Id 3 (see config/winningLines.php) is connecting
                "reelWinSymbols" => [
                    [{x: 0, y 0: lineId: 3, symbol: 1}],
                    [{x: 1, y 0: lineId: 3, symbol: 1}],
                    [{x: 2, y 0: lineId: 3, symbol: 1}],
                ]
            ]
           
        ]
    }

    The winning symbols are calculated on the last items of the reel. If the slot machine is a 3x3, lines will be checked on the last 3 items of each 3 reels.


## DoCollect

### Description

Collect the current session's game previously started with the doSpin route. It updates the user's balance accordingly.

### Request

`POST /doCollect.php`

    curl -i -H 'Accept: application/json' -d '' http://localhost/doCollect.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {
        "win":true,
        "winAmonut":10    
    }