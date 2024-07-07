# EmbedGaming Slot Machine API - Simple Version
Slot machine backend designed for the unity project below. It is designed to be simple as possible so you can customize logic on your own. Multiple other project will follow with more advenced feature. This git will be the base of every  other project.

[Check the presentation video](https://www.youtube.com/watch?v=60-rC2RyDgs )

[Unity Asset Store](https://assetstore.unity.com/packages/slug/289250)

There's currently no probability calculation and win calculation on this api. The math part is reserved for other projects as probabilities are generally unique by project. I don't want it to be specific, at least the less the better.


# REST API

The REST API to the example app is described below.

## Get balance

### Description

This route returns the balance of the $_SESSION user. 

If it's a new user, it initializes its balance at 100. The initial balance amount is stored in config/defaultSettings.php ($initialBalance)

### Request

`POST /reloadBalance.php`

    curl -i -H 'Accept: application/json' -d 'name=Foo&status=new' http://localhost/reloadBalance.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"id":1,"name":"Foo","status":"new"}

## Save settings

### Description

DESC

### Request

`POST /saveSettings.php`

    curl -i -H 'Accept: application/json' -d 'name=Foo&status=new' http://localhost/saveSettings.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"id":1,"name":"Foo","status":"new"}

## Spin

### Description

DESC

### Request

`POST /doSpin.php`

    curl -i -H 'Accept: application/json' -d 'name=Foo&status=new' http://localhost/doSpin.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"id":1,"name":"Foo","status":"new"}

## Collect

### Description

DESC

### Request

`POST /doCollect.php`

    curl -i -H 'Accept: application/json' -d 'name=Foo&status=new' http://localhost/doCollect.php

### Response

    HTTP/1.1 201 Created
    Date: Thu, 24 Feb 2011 12:36:30 GMT
    Status: 201 Created
    Connection: close
    Content-Type: application/json
    Location: /thing/1
    Content-Length: 36

    {"id":1,"name":"Foo","status":"new"}