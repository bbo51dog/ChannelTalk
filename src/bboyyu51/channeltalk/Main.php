<?php

namespace bboyyu51\channeltalk;

use pocketmine\plugin\PluginBase;

class Main extends PlugunBase{
    public function onEnable(){
        new TalkManager();
    }
    
    /**
     * Get TalkManager instance
     * 
     * @return TalkManager
     */
    public function getManager(): TalkManager{
        return TalkManager::getInatance();
    }
}