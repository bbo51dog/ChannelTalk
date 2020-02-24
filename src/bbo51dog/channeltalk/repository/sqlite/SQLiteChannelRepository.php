<?php

namespace bbo51dog\channeltalk\repository\sqlite;

use SQLite3;
use bbo51dog\channeltalk\ChannelTalkException;
use bbo51dog\channeltalk\channel\Channel;
use bbo51dog\channeltalk\channel\ChannelImpl;
use bbo51dog\channeltalk\repository\ChannelRepository;

class SQLiteChannelRepository implements ChannelRepository{

    /** @var SQLite3 */
    private $db;
    
    public function __construct(SQLite3 $db){
        $this->db = $db;
        $this->db->exec('CREATE TABLE IF NOT EXISTS channel(
            name TEXT NOT NULL PRIMARY KEY,
            member TETX NOT NULL,
        )');
    }

    public function getChannel(string $name): Channel{
        if(!$this->exists($name)){
            throw new ChannelTalkException('Channel not found');
        }
        $stmt = $this->db->prepare('SELECT member FROM channel WHERE = :name');
        $stmt->bindValue(':name', $name);
        $result = $stmt->execute()->fetchArray();
        return $this->createChannel($name, unserialize($result['member']));
    }
    
    public function getAllChannels(): array{
        $result = $this->db->query('SELECT * FORM channel');
        $channels = [];
        for($data = $result->fetchArray(); !$data; $data = $result->fetchArray()){
            $channels[$name] = $this->createChannel($data['name'], unserialize($data['member']));
        }
        return $channels;
    }
    
    public function registerChannel(Channel $channel): void{
        if($this->exists($channel->getName())){
            throw new ChannelTalkException('Channel already registered');
        }
        $stmt = $this->db->prepare('INSERT INTO channel (name, member) VALUES (:name, :member)');
        $stmt->bindValue(':name', $channel->getName());
        $stmt->bindValue(':member', serialize($channel->getMember()));
        $stmt->execute();
    }
    
    public function updateChannel(Channel $channel): void{
        if(!$this->exists($channel->getName())){
            throw new ChannelTalkException('Channel not found');
        }
        $stmt = $this->db->prepare('UPDATE channel SET member = :member WHERE name = :name');
        $stmt->bindValue(':member', serialzie($channel->getMember()));
        $stmt->execute();
    }
    
    public function deleteChannel(Channel $channel): void{
        $stmt = $this->db->prepare('DELETE FROM channel WHERE name = :name');
        $stmt->bindValue(':name', $channel->getName());
        $stmt->execute();
    }
    
    public function exists(string $name): void{
        $stmt = $this->db->prepare('SELECT COUNT(*) AS count FROM channel WHERE name = :name');
        $stmt->bind_param(':name', strtolower($name));
        $result = $stmt->execute()->fetchArray();
        return $result['count'] === 1;
    }
    
    private function createChannel(string $name, array $member): Channel{
        return new ChannelImpl($name, $member);
    }
}