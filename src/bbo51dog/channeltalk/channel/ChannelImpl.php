<?php

namespace bbo51dog\channeltalk\channel;

use pocketmine\Player;
use pocketmine\Server;

class ChannelImpl implements Channel{

    /** @var string */
    protected $name;

    /** @var string[] */
    protected $member = [];
    
    public function __construct(string $name, array $members = []){
        foreach($members as $member){
            $this->member[] = strtolower($member);
        }
        $this->name = strtolower($name);
    }

    /** 
     * Send message to channel
     * 
     * @param Player $sender
     * @param string $message
     */
    public function send(Player $sender, string $message): void{
        foreach($this->member as $member){
            $player = Server::getInstance()->getPlayer($member);
            if(!$player instanceof Player){
                continue;
            }
            $player->sendMessage($sender->getDisplayName." ".$message);
        }
    }

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