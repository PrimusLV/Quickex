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
 namespace quickex;

 class Quickex {

 	/**
 	 * @var Quickex
 	 */
 	private static $instance;

 	/**
 	 * All controllers
 	 * @var Controller[]
 	 */
 	private $controllers = [];

 	/**
 	 * @var Server
 	 */
 	private $server;

 	private function __construct(Server $server) {
 		$this->server = $server;
 	}

 	/*
 	 * ----------------------------------------------------------
 	 * CONTROLLERS
 	 * ----------------------------------------------------------
 	 */

 	public static function getGameController() : GameController {
 		return self::$instance->controllers["game"];
 	}

 	public static function getPlaygroundController() : PlaygroundController {
 		return self::$instance->controllers["playground"];
 	}

 	public static function getTeamController() : TeamController {
 		return self::$instance->controllers["team"];
 	}

 	public static function getPlayerController() : PlayerController {
 		return self::$instance->controllers["player"];
 	}

 }