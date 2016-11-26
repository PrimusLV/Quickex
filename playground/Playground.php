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

use pocketmine\level\Position;
use quickex\Tickable;

abstract class Playground implements Tickable {

	/**
	 * Display name
	 * @var string
	 */
	protected $name;

	public function __construct(string $name) {
		$this->name = $name;
	}

	/**
	 * Check if Position is inside a play ground.
	 *
	 */
	public abstract function isInPlayground(Position $pos) : bool;


	public abstract function isReady() : bool;
	
	/**
	 * If your map requires a restoration, then do it in here.
	 */
	public function reset() {}

	/**
	 * Insert logic here
	 */
	public function tick() {

	}

}