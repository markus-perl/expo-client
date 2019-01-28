Expo.io PHP  Client
======================

1. Summary
----------

Simple client to send push notification through Expo.io and PHP.


2. Usage
--------

    $expoClient = new ExpoClient();
    
    $tokens = [];
    
    // Register recipients
    $tokens[] = new ExpoPushToken('ExponentPushToken[-smZaYGrQZ48VKRALD-GYt]');
    $tokens[] = new ExpoPushToken('ExponentPushToken[-smZaYGrQZ78VKRALF-GZ2]');
    
    // Setup notification
    $notification = new ExpoNotification();
    $notification->setTitle('Aweseome news for you');
    $notification->setBody('Click here to read the full news');
    $notification->setImage('https://gender-api.com/img/email/logo.png');
    
    //Submit the notification
    foreach ($expoClient->notify($tokens, $notification) as $token) {
    
        if ($token->getStatus() == $token::STATUS_ERROR) {
            if ($token->getError() == 'DeviceNotRegistered') {
                //Remove Token from local DB
            }
        }
    
        if ($token->getStatus() == $token::STATUS_OK) {
            //Put your logic, which should be executed on success here
        }
        
        //Optional, print status
        echo $token . PHP_EOL;
    }