<?php

namespace bbo51dog\channeltalk;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use bbo51dog\channeltalk\channel\Channel;

use pocketmine\utils\MainLogger;

class EventListener implements Listener{

    /** @var TalkManager */
    private $manager;

    public function __construct(TalkManager $manager){
        $this->manager = $manager;
    }

    public function onChat(PlayerChatEvent $event){
        $event->setCancelled();
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $channel = $this->manager->getChannelByPlayer($player->getName());
        if($channel instanceof Channel){
            $channel->send($player, $message);
        }else{
            $global = $this->manager->getGlobal();
            $global->send($player, $message);
            $global->addMember($player->getName());
            $this->manager->saveChannel($global);
        }
    }
    
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $channel = $this->manager->getChannelByPlayer($player->getName());
        if($channel instanceof Channel){
            return;
        }
        $global = $this->manager->getGlobal();
        $global->addMember($player->getName());
        $this->manager->saveChannel($global);
    }
}