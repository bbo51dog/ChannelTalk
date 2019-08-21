<?php

namespace bboyyu51\channeltalk;

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
    
    public function __construct(){
        self::$instance = $this;
    }
}