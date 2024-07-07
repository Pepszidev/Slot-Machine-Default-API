# EmbedGaming Slot Machine API - Simple Version

Slot machine backend designed for the unity project below. It is designed to be simple as possible so you can customize logic on your own. Multiple other project will follow with more advenced feature. This git will be the base of every  other project.

[DEMO](https://projects.embedgaming.com/simple/)

[Unity Asset Store](https://assetstore.unity.com/packages/slug/289250)

# How it works ?

User can spin the slot machine and retrieve its datas. I currently using php sessions ($_SESSION) to store data and simulate any storage. No database has been implemented to store data on long term as this is pretty specific to each projects.

The main game logic is handled in doSpin.php route.

Steps : 

- Generate the winning panel : It randomly places symbols (symbol number defined in config/defaultSettings.php) into reel arrays. The number of symbol on each reel is set at 30. The displayed winning panel and the one I use to calculate win combinations is contained in the last 3 indexs of the reel array.
- Check each winning lines (config/winningLines.php) to detect symbol's positions to animate. It stores the line id (from config/winningLines.php) and the symbol id to be able to calculate winning amounts.
- Calculate the win amount using config/winningSymbols.php and the previous action
- Return the data

It does not updat the user's balance. This action is called through doCollect.php to be able to update the user's balance later in the process (for no spoil)

### Example

The following example is a response for a slot machine containing 3 reels. It generates 12 symbols on each reel. Symbol 1 is 10 and Symbol 2 is Jack. The winning is calculated in the last 3 symbol of each reel : 

    "reels": [
        [
            "reel" => [1,2,1,2,1,2,1,2,1,2,1,2]
        ],
        [
            "reel" => [1,2,1,2,1,2,1,2,1,2,1,2]
        ],
        [
            "reel" => [1,2,1,2,1,2,1,2,1,2,1,2]
        ]
    ],
    

Winning screen : 

"reel" => [1,2,1,2,1,2,1,2,1,**2,1,2**]

"reel" => [1,2,1,2,1,2,1,2,1,**2,1,2**]

"reel" => [1,2,1,2,1,2,1,2,1,**2,1,2**]

So this will show : 

    2 2 2
    1 1 1
    2 2 2

## Get balance (reloadBalance.php)

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

## Save settings (saveSettings.php)

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

## DoSpin (doSpin.php)

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
                //Line Id 2 (see config/winningLines.php) is connecting
                "reelWinSymbols" => [
                    [{x: 0, y 0: lineId: 2, symbol: 2}],
                ],
                "reelWinSymbols" => [
                    [{x: 1, y 0: lineId: 2, symbol: 2}],
                ],
                "reelWinSymbols" => [
                    [{x: 2, y 0: lineId: 2, symbol: 2}],
                ]
            ]
           
        ]
    }

    The winning symbols are calculated on the last items of the reel. If the slot machine is a 3x3, lines will be checked on the last 3 items of each 3 reels.


## DoCollect (doCollect.php)

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