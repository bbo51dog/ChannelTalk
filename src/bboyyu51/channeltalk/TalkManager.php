<?php

namespace bboyyu51\channeltalk;

use pocketmine\utils\Config;
use bboyyu51\channeltalk\channel\ChannelBase;

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
    
    /** @var ChannelBase[] */
    private $channel;
    
    /** @var Config */
    private $db;
    
    public function __construct(Config $db){
        if($db->exist("channel")){
            foreach($db->get("channel") as $channel){
                
            }
        }else{
            
        }
        $this->db = $db;
        self::$instance = $this;
    }
}