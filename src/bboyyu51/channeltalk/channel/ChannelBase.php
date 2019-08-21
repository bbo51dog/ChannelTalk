<?php

namespace bboyyu51\channeltalk\channel;

use pocketmine\Player;

abstract class ChannelBase{

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    protected $member;

    /** 
     * Send message to channel
     * 
     * @param Player $sender
     * @param string $message
     */
    public function send(Player $sender, string $message): void{
        
    }
}