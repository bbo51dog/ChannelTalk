<?php

namespace bboyyu51\channeltalk\channel;

use pocketmine\Player;

abstract class ChannelBase{

    /** @var int */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $member;

    /** 
     * Send message to channel
     * 
     * @param Player $sender
     * @param string $message
     */
    abstract public function send(Player $sender, string $message): void;
}