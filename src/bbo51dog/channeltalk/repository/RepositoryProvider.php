<?php

namespace bbo51dog\channeltalk\repository;

use SQLite3;
use bbo51dog\channeltalk\repository\sqlite\SQQLiteChannelRepository;

class RepositoryProvider{

    /** @var SQLite3 */
    private $db;

    public function __construct(string $dataFolder){
        $this->db = new SQLite3($dataFolder.'ChannelTalk.db');
    }
    
    public function close(): void{
        $this->db->close();
    }

    public function createChannelRepository(): ChannelRepository{
        return new ChannelRepository($this->db);
    }
}