<?php

namespace bbo51dog\channeltalk;

use bbo51dog\channeltalk\repository\RepositoryProvider;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class ChannelTalkPlugin extends PluginBase{

    /** @var RepositoryProvider **/
    private $provider;
    
    /** @var TalkManager */
    private $manager;

    public function onEnable(){
         $this->provider = new RepositoryProvider($this->getDataFolder());
         $this->manager = new TalkManager($this->provider->createChannelRepository());
         $this->getServer()->getPluginManager()->registerEvents(new EventListener($this->manager), $this);
         $this->getServer()->getCommandMap()->register("channel", new ChannelCommand($this->manager));
    } 
    
    public function onDisable(){
        $this->provider->close();
    }
}