<?php

namespace bboyyu51\channeltalk\channel;

class Channel extends ChannelBase{

    public function __construct(string $name, array $members = []){
        foreach($members as $member){
            $this->member[] = strtolower($member);
        }
        $this->name = $name;
    }
}