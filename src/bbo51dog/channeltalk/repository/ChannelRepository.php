<?php

namespace bbo51dog\channeltalk\repository;

use bbo51dog\channeltalk\channel\Channel;

interface ChannelRepository extends Repository{

    public function getChannel(string $name): Channel;
    
    public function getAllChannels(): array;
    
    public function registerChannel(Channel $channel): void;
    
    public function updateChannel(Channel $channel): void;
    
    public function deleteChannel(Channel $channel): void;
    
    public function exists(string $name): bool;
}
