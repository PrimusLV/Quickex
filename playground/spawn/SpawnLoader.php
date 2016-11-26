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
use pocketmine\level\Position;
use pocketmine\level\Location;

use quickex\playground\Playground;
use quickex\entity\Participant;
use quickex\Quickex;

class SpawnLoader {


	/**
	 * @param array $teams
	 * @param array $data
	 * @return array|null
	 * @throws \Exception
	 */
	public static function loadTeamSpawns(array $teams, array $data) {

	}

	/**
	 * @param array $data
	 * @return Vector3|Position|Location|null
	 * @throws \Exception
	 */
	public static function loadSpawn(array $data) {
		if(!self::isSpawnData($data)) return null;
		extract($data);
		if(isset($level)) {
			$level = Quickex::getServer()->getLevelByName($data["level"]);
			if(!$level) throw new \Exception("unknown level '{$data['level']}'");
		}
		switch(self::getSpawnType($data)) {
			case Location::class:
				return new Location($x, $y, $z, (double) $yaw, (double) $pitch, $level);
			case Position::class:
				return new Position($x, $y, $z, $level);
			case Vector3::class:
				return new Vector3($x, $y, $z);
			case false:
				return null;
		}
	}

	/**
	 * Checks if array contains all three coordinates
	 */
	public static function isSpawnData(array $data) : bool {
		return isset($data["x"]) && isset($data["y"]) && isset($data["z"]);
	}

	/**
	 * Returns a class name corresponding to array $data
	 * @param $data
	 * @return string|bool
	 */
	public static function getSpawnType(array $data) {
		if(self::isSpawnData($data)) {
			switch(true) {
				case (isset($data["x"]) && isset($data["y"]) && isset($data["z"]) && isset($data["yaw"]) && isset($data["pitch"]) && isset($data["level"])):
					return Location::class;
				case (isset($data["x"]) && isset($data["y"]) && isset($data["z"]) && isset($data["level"])):
					return Position::class;
				case (isset($data["x"]) && isset($data["y"]) && isset($data["z"])):
					return Vector3::class;
			}
		}
		return false;
	}

}