<?php

namespace bboyyu51\channeltalk;

use pocketmine\utils\Config;
use bboyyu51\channeltalk\channel\ChannelBase;
use bboyyu51\channeltalk\channel\Channel;
use bboyyu51\channeltalk\channel\GlobalChannel;

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
                $this->channel[] = new Channel($channel["member"]);
            }
        }else{
            $this->global = new GlobalChannel([]);
        }
        $this->db = $db;
        self::$instance = $this;
    }
}