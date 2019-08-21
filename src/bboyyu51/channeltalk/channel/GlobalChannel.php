<?php

namespace bboyyu51\channeltalk\channel;

class GlobalChannel extends ChannelBase{

    protected $id = 0;
    protected $name = "Global"

    public function __construct(array $member){
        $this->member = $member;
    }
}