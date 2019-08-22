<?php

namespace  bboyyu51\channeltalk;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class MoneyCommand extends Command{
    
    private const USAGE = "Usage: /channel < join | exit | info | list | global >";
    private const USAGE_OP = "Usage: /channel < join | exit | info | list | global | make | remove >";
    
    public function __construct(){
        parent::__construct("channel", "Channel Talk Commands", "/channel");
        $this->setPermission("command.channel");
    }
    
    public function execute(CommandSender $sender, string $commandLabel, array $args){
        switch($args[0]){
            case "join":

            case "exit":

            case "info":

            case "list":

            case "global":

            case "make":

            case "remove":

            default:
                if($sender->isOp()){
                    $sender->sendMessage(self::USAGE_OP);
                }else{
                    $sender->sendMessage(self::USAGE);
                }
                break;
        }
    }
}