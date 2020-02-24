<?php

namespace bbo51dog\channeltalk;

use bbo51dog\channeltalk\channel\ChannelBase;
use bbo51dog\channeltalk\channel\Channel;
use bbo51dog\channeltalk\channel\ChannelImpl;
use bbo51dog\channeltalk\channel\GlobalChannel;
use bbo51dog\channeltalk\repository\ChannelRepository;

class TalkManager{
    
    /** @var self */
    private static $instance;
    
    /** @var Channel[] */
    private $channel = [];
    
    /** @var GlobalChannel */
    private $global;
    
    /** @var ChannelRepository */
    private $repo;
    
    public function __construct(ChannelRepository $repo){
        $this->repo = $repo;
        if(!$this->repo->exists('global')){
            $this->registerChannel('global');
        }
    }
    
    public function getChannel(string $name): Channel{
        return $this->repo->getChannel($name);
    }
    
    public function saveChannel(Channel $channel): void{
        $this->repo->updateChannel($channel);
    }

    public function getAllChannels(): array{
        return $this->repo->getAllChannels();
    }
    
    public function getChannelByPlayer(string $name): ?Channel{
        foreach($this->getAllChannels() as $channel){
            if(in_array(strtolower($name), $channel->getMember())){
                return $channel;
            }
        }
        return null;
    }
    
    public function exists(string $name): bool{
        return $this->repo->exists($name);
    }

    public function getGlobal(): Channel{
        return $this->repo->getChannel('global');
    }

    public function registerChannel(string $name): void{
        if($this->exists($name)){
            throw new ChannelTalkException('Channel already registered');
        }
        $this->repo->registerChannel(new ChannelImpl($name, []));
    }
    
    public function deleteChannel(string $name): void{
        if(strtolower($name) === 'global'){
            throw new ChannelTalkException('Global channel cannot be deleted');
        }
        if(!$this->exists($name)){
            throw new ChannelTalkException('Channel not found');
        }
        $channel = $this->repo->getChannel($name);
        $this->repo->deleteChannel($channel);
    }
}