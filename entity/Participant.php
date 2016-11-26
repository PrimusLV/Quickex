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
namespace quickex\entity;

use quickex\Unique;
use quickex\utils\UID;
use quickex\Tickable;
use quickex\Named;

abstract class Participant implements Unique, Tickable, Named {

	public function __construct(Game $game) {
		$this->id = UID::generate();
		$this->game = $game;
	}
	
	/*
	 * ----------------------------------------------------------
	 * IDENTIFIER
	 * ----------------------------------------------------------
	 */

	/**
	 * @var UID
	 */
	protected $id;

	public function getUniqueID() : UID {
		return $this->id;
	}

	/**
	 * @var Game
	 */
	protected $game;

	public function getGame() : Game {
		return $this->game;
	}

	/*
	 * ----------------------------------------------------------
	 * ABSTRACT FUNCTIONS
	 * ----------------------------------------------------------
	 */

	public abstract function sendMessage(string $message);

	public abstract function sendPopup(string $popup);

	public abstract function sendTip(string $tip);

	/*
	 * ----------------------------------------------------------
	 * MAGIC FUNCTIONS
	 * ----------------------------------------------------------
	 */

	/*
	 * ----------------------------------------------------------
	 * LOGIC
	 * ----------------------------------------------------------
	 */

	/**
	 * Insert logic here
	 */
	public function tick() {}

}