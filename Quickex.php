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

 use pocketmine\plugin\PluginBase;
 use pocketmine\Server;

 use quickex\controller\GameController;
 use quickex\controller\SignController;
 use quickex\controller\PlayerController;
 use quickex\controller\TeamController;
 use quickex\controller\PlaygroundController;
 use quickex\listener\PlayerEventListener;
 use quickex\listener\BlockEventListener;
 use quickex\task\HeartTask;


final class Quickex {

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

 	/**
 	 * @var PluginBase
 	 */
 	private $plugin;

 	/**
 	 * Path to Quickex data
 	 * @var string
 	 */
 	private $dataPath;

 	private function __construct(PluginBase $plugin) {
 		$this->server = $plugin->getServer();
 		$this->plugin = $plugin;

 		// Prepare data
 		$path = realpath($this->server->getDataPath() . "quickex/");
 		@mkdir($path);
 		@mkdir(realpath($path . "languages"));
 		@mkdir(realpath($path . "spawns"));
 		@mkdir(realpath($path . "configs"));

 		// Load controllers
 		$this->controllers["game"] = new GameController($this);
 		$this->controllers["playground"] = new PlaygroundController($this);
 		$this->controllers["team"] = new TeamController($this);
 		$this->controllers["player"] = new PlayerController($this);
 		$this->controllers["sign"] = new SignController($this);

 		// Register listeners
 		$this->server->getPluginManager()->registerEvents(new PlayerEventListener($this), $plugin);
 		$this->server->getPluginManager()->registerEvents(new BlockEventListener($this), $plugin);

 		// Make my heart go on...
 		$this->server->getScheduler()->scheduleRepeatingTask(new HeartTask($this), 1);
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

 	public static function getSignController() : SignController {
 		return self::$instance->controllers["sign"];
 	}

 	/*
 	 * ----------------------------------------------------------
 	 * LOGIC
 	 * ----------------------------------------------------------
 	 */

 	public function beat($currentTick) {
 		if(($currentTick % 20) === 0) { // Controllers need to be updated only every second
 			foreach($this->controllers as $controller) {
 				$controller->tick();
 			}
 		}
 	}

 	/*
 	 * ----------------------------------------------------------
 	 * SOME API FUNCTIONS
 	 * ----------------------------------------------------------
 	 */

 	public static function init(PluginBase $plugin) {
 		if(self::$instance) throw new \InvalidStateException("Quickex already initiated");
 		self::$instance = new self($plugin);
 	}

 	/**
 	 * Handles the shutdown
 	 */
 	public static function shutdown() {
 		foreach(self::$instance->controllers as $controller) {
 			$controller->shutdown();
 		}
 	}

 	/**
 	 * The class must be extending Controller class and class' name must
 	 * be in format of 'NameController'
 	 * @param string $class
 	 * @throws \Exception|\ReflectionException
 	 * @return bool
 	 */
 	public static function registerController(string $class) {
 		$r = new \ReflectionClass($class);
 		if($r->getParentClass() !== Controller::class) {
 			throw new \InvalidArgumentException("expecting {Controller::class} got $class");
 		}
 		$name = strtolower(substr($class, strpos($class, 0, "Controller")));
 		if(!isset(self::$instance->controllers[$name])) {
 			self::$instance->controllers[$name] = new $class(self::$instance);
 			return true;
 		} else {
 			throw new \Exception("controller '$name' already registered");
 		}
 		return false;
 	}

 	public static function getDataPath() : string {
 		return self::$instance->$this->dataPath;
 	}

 	/**
 	 * Returns a resource. NOTE: use fclose() when job with it has done
 	 * @param string $path relative to $this->dataPath
 	 * @return resource|null
 	 */
 	public function getResource($path) {
 		return fopen(realpath($this->dataPath . $path));
 	}

 	public static function getServer() : Server {
 		return self::$instance->server;
 	}

 }