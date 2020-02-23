<?php

namespace bbo51dog\channeltalk;

use pocketmine\Player;
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
        $manager = TalkManager::getInstance();
        $name = $sender->getName();
        $global = $manager->getGlobal();
        if(!$sender instanceof Player){
            $sender->sendMessage("サーバー内で使用してください");
            return;
        }
        switch($args[0]){
            case "join":
                if(empty($args[1])){
                    $sender->sendMessage("Usage: /channel join [channel name]");
                    break;
                }
                if(!empty($manager->getChannelByPlayer($name))){
                    $sender->sendMessage("既にチャンネルに参加しています");
                    break;
                }
                $channel = $manager->getChannel($args[1]);
                if(empty($channel)){
                    $sender->sendMessage("チャンネルが見つかりません");
                    break;
                }
                $channel->addMember($name);
                $sender->sendMessage("チャンネルに参加しました");
                break;

            case "exit":
                $channel = $manager->getChannelByPlayer($name);
                if(empty($channel)){
                    $sender->sendMessage("チャンネルに参加していません");
                    break;
                }
                $channel->removeMember($name);
                $global->addMember($name);
                $sender->sendMessage("チャンネルから退出しました");
                break;

            case "info":
                $channel = $manager->getChannelByPlayer();
                if(empty($channel)){
                    $info = "参加中のチャンネル Global";
                }else{
                    $info = "参加中のチャンネル ".$channel->getName();
                    if(in_array(strtolower($name, $global->getMember()))){
                        $info .= "\nGlobalチャンネル ON";
                    }else{
                        $info.= "\nGlobalチャンネル OFF";
                    }
                }
                $sender->sendMessage($info);
                break;

            case "list":
                $list = "Channel list\nGlobal";
                foreach($manager->getChannels() as $channel){
                    $list .= "\n".$channel->getName();
                }
                $sender->sendMessage($list);
                break;

            case "global":
                $usage = "Usage: /channel global < on | off >";
                if(empty($args[1])){
                    $sender->sendMessage($usage);
                    break;
                }
                switch($args[1]){
                    case "on":
                        $global->addMember($name);
                        $sender->sendMessage("グローバルチャットを有効にしました");
                        break 2;

                    case "off":
                        $global->removeMember($name);
                        $sender->sendMessage("グローバルチャットを無効にしました");
                        break 2;

                    default:
                        $sender->sendMessage($usage);
                        break 2;

            case "make":
                if(empty($args[1])){
                    $sender->sendMessage("Usage: /channel make <name>");
                    break;
                }
                if($manager->makeChannel($atgs[1])){
                    $sender->sendMessage("チャンネルを作成しました");
                }else{
                    $sender->sendMessage("既にチャンネルが存在します");
                }
                break;

            case "remove":
                    $sender->sendMessage("Usage: /channel remove <name>");
                    break;
                }
                if($manager->removeChannel($atgs[1])){
                    $sender->sendMessage("チャンネルを削除しました");
                }else{
                    $sender->sendMessage("チャンネルが存在しません");
                }
                break;

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