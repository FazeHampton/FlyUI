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
use pocketmine\entity\EntityDamageEvent;
class FlyUI extends PluginBase implements Listener{
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("FlyUI Plugin Enabled By FazeHampton");
    }
    public function onDisable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("FlyUI Plugin Disabled By FazeHampton");
    }
    public function checkDepends(): void{
        $this->formapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if(is_null($this->formapi)){
            $this->getLogger()->error("FlyUI Requires FormAPI To Work");
            $this->getPluginLoader()->disablePlugin($this);
        }
    }
    public function onEntityDamage(EntityDamageEvent $event) {
        if($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();
            if($damager instanceof Player && $this->isPlayer($damager)) {
                $damager->sendMessage("You Cannot Damage A Player In FlyUI");
                $event->setCancelled(true);
            }
        }
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "flyui"){
            if(!($sender instanceof Player))A{
                $sender->sendMessage("", false);
                return true;
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        $sender->sendMessage("FlyUI Enabled");
                        $addTitle->("FlyUI Enabled");
                        $sendTip->("FlyUI Enabled");
                        $sendPopup->("FlyUI Enabled");
                        $sender->setAllowFlight(false);
                        break;
                    case 1:
                        $sender->sendMessage("FlyUI Disabled");
                        $addTitle->("FlyUI Disabled");
                        $sendTip->("FlyUI Disabled");
                        $sendPopup->("FlyUI Disabled");
                        $sender->setAllowFlight(true);
                        break;
                    case 2:
                        $sender->sendMessage("FlyUI Error");
                        $addTitle->("FlyUI Error");
                        $sendTip->("FlyUI Error");
                        $sendPopup->("FlyUI Error");
                        $sender->setAllowFlight(true);
                        break;
                }
            });
            $form->setTitle("FlyUI Settings");
            $form->setContent("Below Allows You To Fly");
            $form->addButton("Fly Enable");
            $form->setContent("Below Allows You To Disable Fly");
            $form->addButton("Fly Disable");
            $form->setContent("Below Exits The FlyUI");
            $form->addButton("Exit");
            $form->sendToPlayer($sender);
        }
        return true;
    }
}
