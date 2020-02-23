<?php

namespace bbo51dog\channeltalk\channel;

class GlobalChannel extends ChannelBase{

    protected $name = "Global"

    public function __construct(array $members = []){
        foreach($members as $member){
            $this->member[] = strtolower($member);
        }
    }
}