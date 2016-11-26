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
namespace quickex\playground;

use quickex\Quickex;

use pocketmine\level\Level;
use pocketmine\level\Position;

class LevelPlayground extends Playground {

	public function __construct(Level $level) {
		$this->level = $level;

		Quickex::getPlaygroundController()->addPlayground($this);
	}

	/**
	 * @var Level
	 */
	protected $level;

	public function isInPlayground(Position $pos) : bool {
		if($pos->level === $this->level) return true;
		return false;
	}

	public function isReady() : bool {
		return true;
	}
	
	/**
	 * Returns a Level object if exists
	 */
	public function getLevel() {
		$level = $this->level;
		if($level) return $level;
		if($this->area) {
			return $this->area->getLevel();
		}
		return $level;
	}

}