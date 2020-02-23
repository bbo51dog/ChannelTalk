<?php

namespace bbo51dog\channeltalk;

use pocketmine\utils\Config;
use bbo51dog\channeltalk\channel\ChannelBase;
use bbo51dog\channeltalk\channel\Channel;
use bbo51dog\channeltalk\channel\GlobalChannel;

class TalkManager{
    
    /** @var self */
    private static $instance;
    
    /** 
     * Get TalkManager instance
     *
     * @return self
     */
    public static function getInstance(): self{
        return self::$instance;
    }
    
    /** @var Channel[] */
    private $channel = [];
    
    /** @var GlobalChannel */
    private $global;
    
    /** @var Config */
    private $db;
    
    public function __construct(Config $db){
        if($db->exist("channel")){
            foreach($db->get("channel") as $channel){
                if($channel["name"] === "Global"){
                    $this->global = new GlobalChannel($channel["member"]);
                    continue;
                }
                $this->channel[] = new Channel($channel["name"], $channel["member"]);
            }
        }else{
            $this->global = new GlobalChannel();
        }
        $this->db = $db;
        self::$instance = $this;
    }
    
    public function save(): void{
        foreach($this->channel as $channel){
            $data["channel"][] = [
                "name" => $channel->getName(),
                "member" => $channel->getMember(),
            ];
        }
        $data["channel"][] = [
            "name" => $this->global->getName(),
            "member" => $this->global->getMember(),
        ];
        $this->db->setAll($data);
        $this->db->save();
    }
    
    public function getChannel(string $name): ?Channel{
        foreach($this->channel as $channel){
            if($channel->getName() === $name){
                return $channel;
            }
        }
        return null;
    }

    public function getChannels(): array{
        return $this->channel;
    }
    
    public function getChannelByPlayer(string $name): ?Channel{
        foreach($this->channel as $channel){
            if(in_array(strtolower($name), $channel->getMember())){
                return $channel;
            }
        }
        return null;
    }

    public function getGlobal(): GlobalChannel{
        return $this->global;
    }

    public function makeChannel(string $namme): bool{
        if($this->getChannel($name) !== null){
            return false;
        }
        $this->channel[] = new Channel($name);
        return true;
    }
    
    public function removeChannel(string $name): bool{
        foreach($this->channel as $key => $channel){
            if($channel->getName() === $name){
                $this->channel = array_splice($this->channel, $key, 1);
                return true;
            }
        }
        return false;
    }
}