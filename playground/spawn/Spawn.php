<?php
/*
 *   Quickex: Game API Library for PocketMine-MP
 *   Copyright (C) 2016  Chris Prime
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
namespace quickex\playground\spawn;

use pocketmine\math\Vector3;
use pocketmine\entity\Entity;

use quickex\playground\Playground;

class Spawn extends Vector3 {

	/** @var int */
	public $yaw = 0;
	public $pitch = 0;

	/** @var Playground */
	public $playground;

	/**
	 * Get closest entity to this spawn point
	 * @param float $radius
	 * @return Entity
	 */
	public function closestEntity(float $radius) {
		$e = null;
		$closest = null;
		foreach($this->playground->getEntities() as $entity) {
			if(!$entity->isAlive()) continue;
			if(($c = $entity->distance($this)) < $closest) {
				$closest = $c;
				$e = $entity;
			}
		}
		return $e;
	}

	/**
	 * Check whetever it's safe to spawn here
	 * @param int $radius if no one of $danger is in this radius, it's safe
	 */
	public function isSafe(int $radius, $danger = []) : bool {
		if(!is_array($safe)) $safe = [$safe];
		if(!is_array($danger)) $danger = [$danger];
		foreach()
	}

}