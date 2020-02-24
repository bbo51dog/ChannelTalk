<?php

namespace bbo51dog\channeltalk\channel;

use pocketmine\Player;

interface Channel{

    public function __construct(string $name, array $members = []);
    
    /** 
     * Send message to channel
     * 
     * @param Player $sender
     * @param string $message
     */
    public function send(Player $sender, string $message): void;

    public function getName(): string;
    
    public function getMember(): array;
    
    public function addMember(string $name): void;
    
    public function removeMember(string $name): void;
}