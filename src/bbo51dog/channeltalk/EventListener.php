<?php

namespace bbo51dog\channeltalk;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use bbo51dog\channeltalk\channel\Channel;

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
            $this->manager->getGlobal()->send($player, $message);
        }
    }
    
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $channel = $this->manager->getChannelByPlayer($player->getName());
        if($channel instanceof Channel){
            return;
        }
        $this->manager->getGlobal()->addMember($player->getName());
    }
}