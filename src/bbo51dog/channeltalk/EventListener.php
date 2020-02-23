<?php

namespace bbo51dog\channeltalk;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerJoinEvent;
use bbo51dog\channeltalk\channel\Channel;

class EventListener implements Listener{

    public function onChat(PlayerChatEvent $event){
        $event->setCancelled();
        $player = $event->getPlayer();
        $message = $event->getMessage();
        $channel = TalkManager::getInstance()->getChannelByPlayer($player->getName());
        if($channel instanceof Channel){
            $channel->send($player, $message);
        }else{
            TalkManager::getInstance()->getGlobal()->send($player, $message);
        }
    }
    
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $channel = TalkManager::getInstance()->getChannelByPlayer($player->getName());
        if($channel instanceof Channel){
            return;
        }
        TalkManager::getInstance()->getGlobal()->addMember($player->getName());
    }
}