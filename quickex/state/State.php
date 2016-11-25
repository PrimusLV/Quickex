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
namespace quickex\state;

use quickex\Game;

abstract class State {

	/**
	 * @var Game
	 */
	protected $game;

	/**
	 * Construct new State instance
	 * @param Game $game owner of this state
	 */
	public function __construct(Game $game) {
		$this->game = $game;
	}

	/*
	 * ----------------------------------------------------------
	 * ABSTRACT FUNCTIONS
	 * ----------------------------------------------------------
	 */

	/**
	 * When game has this state
	 */
	public abstract function start();

	/**
	 * When game had this state and it changed
	 */
	public abstract function end();

	/**
	 * Usually the index of array position in StateBasedGame::$states array
	 * @return int
	 */
	public abstract function getID() : int;

	/**
	 * Init the state
	 */
	public abstract function init();

	/**
	 * Update the state
	 */
	public abstract function tick();

	/**
	 * @return Game
	 */
	public function getGame() : Game {
		return $this->game;
	}

}