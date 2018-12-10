<?php
namespace FlyUI;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use jojoe77777\FormAPI;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\event\server\ServerCommandEvent;
class FlyUI extends PluginBase implements Listener{
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("Plugin Enabled By FazeHampton");
    }
    public function onDisable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("Plugin Disabled By FazeHampton");
    }
    public function checkDepends(): void{
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->error("FlyUI Requires FormAPI To Work");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "flyui"){
            if(!($sender instanceof Player)){
                $sender->sendMessage("FlyUI By FazeHampton", false);
                return true;
            }
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        $sender->sendMessage("FlyUI By MikeyHampton");
                        break;
                    case 1:
                        $sender->sendMessage("Fly Enabled By FazeHampton");
                        $this->getServer()->getCommandMap()->dispatch($player, "fly");
                        break;
                    case 2:
                        $sender->sendMessage("Fly Disabled By FazeHampton");
                        $this->getServer()->getCommandMap()->dispatch($player, "fly");
                        break;
                }
            });
            $form->setTitle("FlyUI By FazeHampton");
            $form->setContent("FlyUI By FazeHampton");
            $form->addButton("Fly Enable");
            $form->addButton("Fly Disable");
            $form->addButton("Exit");
            $form->sendToPlayer($sender);
        }
        return true;
    }
}
