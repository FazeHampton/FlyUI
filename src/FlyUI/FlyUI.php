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
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
class FlyUI extends PluginBase implements Listener{
    public function onEnable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("FlyUI Plugin Enabled");
    }
    public function onDisable(): void{
        $this->getServer()->getPluginManager()->registerEvents(($this), $this);
        $this->getLogger()->info("FlyUI Plugin Disabled");
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
                $damager->sendTip("Disable FlyUI Before Trying To PvP");
                $event->setCancelled(true);
            }
        }
    }
    public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args):bool{
        if($cmd->getName() == "flyui"){
            if(!($sender instanceof Player)){
                $sender->sendMessage("FlyUI Commands", false);
                return true;
            }
            $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
            $form = $api->createSimpleForm(function (Player $sender, $data){
                $result = $data;
                if ($result == null) {
                }
                switch ($result) {
                    case 0:
                        $addTitle->("FlyUI Commands");
                        $this->addPlayer($sender);
                        $sender->setAllowFlight(true);
                        break;
                    case 1:
                        $addTitle->("Fly Disabled");
                        $this->removePlayer($sender);
                        $sender->setAllowFlight(false);
                        break;
                    case 2:
                        $addTitle->("Fly Enabled");
                        $this->addPlayer($sender);
                        $sender->setAllowFlight(true);
                        break;
                }
            });
            $form->setTitle("FlyUI Commands");
            $form->setContent("FlyUI Commands");
            $form->addButton("FlyUI Enable");
            $form->addButton("FlyUI Disable");
            $form->addButton("Exit FlyUI");
            $form->sendToPlayer($sender);
        }
        return true;
    }
}
