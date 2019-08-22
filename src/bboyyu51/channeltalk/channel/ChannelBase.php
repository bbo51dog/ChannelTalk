<?php

namespace bboyyu51\channeltalk\channel;

use pocketmine\Player;

abstract class ChannelBase{

    /** @var string */
    protected $name;

    /** @var string[] */
    protected $member = [];

    /** 
     * Send message to channel
     * 
     * @param Player $sender
     * @param string $message
     */
    abstract public function send(Player $sender, string $message): void;

    public function getName(): string{
        return $this->name;
    }
    
    public function getMember(): array{
        return $this->member;
    }
    
    public function addMember(string $name): void{
        $name = strtolower($name);
        if(!in_array($name, $member)){
            $this->member[] = $name;
        }
    }
    
    public function removeMember(string $name): void{
        $member = array_diff($this->member, [$name]);
        $this->member = array_values($member);
    }
}