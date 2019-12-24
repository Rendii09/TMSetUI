<?php

namespace Rendii09\TMSetUI;

use pocketmine\Server;
use pocketmine\Player;

use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as C;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\command\ConsoleCommandSender;

use jojoe77777\FormAPI;
use jojoe77777\FormAPI\SimpleForm;

class Main extends PluginBase implements Listener{

    public function onEnable(){
        $this->getLogger()->info(C::GREEN . "Enable! TMSetUI telah di aktifkan");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED . "Disable! TMSetUI telah di nonaktifkan");
    }
        
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args) : bool {
        switch($cmd->getName()){                    
            case "tmui":
                if($sender instanceof Player){
                    if($sender->hasPermission("tmui.cmd")){
                        $this->TMSetUI($sender);
                        return true;
                    }else{
                        $sender->sendMessage("§cAnda tidak memiliki izin untuk menggunakan peeintah ini!");
                        return true;
                    }

                }else{
                    $sender->sendMessage("§cGunakan perintah ini di dalam game!");
                    return true;
                }     
        }
    }
  
        public function TMSetUI($sender){
        $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        $form = $api->createSimpleForm(function (Player $sender, int $data = null) {
            $result = $data;
            if($result === null){
                return true;
            }             
            switch($result){
                case 0:
                    $sender->getLevel()->setTime(0);
                    $sender->sendMessage(§b[TMSet] §aBerhasil mengubah cuaca ke pagi!);
                    $sender->addTitle("§l§eDay!", "§fDiaktifkan");
                break;
                case 1:
                    $sender->getLevel()->setTime(15000);
                    $sender->sendMessage(§b[TMSet] §aBerhasil mengubah cuaca ke malam!);
                    $sender->addTitle("§l§eNight!", "§fDiaktifkan");
                break;
                case 2:
                    $this->openMenu($sender);
                break;

                }
            });
            $form->setTitle("§l§eTimeSet§bUI);
            $form->setContent(§bPilih untuk mengubah Cuaca:);
            $form->addButton("§aDay);
            $form->addButton("§aNight);
            $form->addButton(§cKembali);
            $form->sendToPlayer($sender);
            return $form;
    }
}
