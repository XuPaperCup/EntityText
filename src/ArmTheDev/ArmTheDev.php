<?php

namespace ArmTheDev;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\network\mcpe\protocol\{AddEntityPacket, AddItemEntityPacket, RemoveEntityPacket};
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\level\particle\FloatingTextParticle;
;
class ArmTheDev extends PluginBase implements Listener {
	
	public $json;
	public $data;
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$dir = $this->getDataFolder();
		@mkdir($dir);
		if(!file_exists($dir.'config.json')){
			file_put_contents($dir.'config.json', '{"text":"YOU TEXT HERE", "x":-40,"y":74,"z":-747}');
		}
		$this->json = file_get_contents($dir.'config.json');
		$this->data = json_decode($this->json, true);
    }
    
	public function crystal(PlayerJoinEvent $event){
		$player = $event->getPlayer();
		$pk = new AddEntityPacket();
		$pk->type = 61; //check EntityIds from pmmp fils
		$pk->entityRuntimeId = Entity::$entityCount++;
		$pk->metadata = array();
		$pk->yaw = 0;
		$pk->pitch = 0;
		$pk->position = new \pocketmine\math\Vector3($this->data['x'] + 0.5 , $this->data['y'], $this->data['z'] + 0.5);
		$player->dataPacket($pk);
		$player->getLevel()->addParticle(new FloatingTextParticle(new Vector3($this->data['x'] + 0.5 , $this->data['y'] + 2, $this->data['z'] + 0.5), '', $this->data['text'])); //Entity spawn on the middle and not at the coner of the block
	}
}