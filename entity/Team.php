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
 namespace entity;

 use localizer\Localizer;

 use pocketmine\utils\TextFormat;

 class Team extends Participant {

 	public function __construct(string $name, int $maxPlayers, string $color = TextFormat::WHITE) {

 	}

 	/*
 	 * ----------------------------------------------------------
 	 * IDENTIFIER, NAME
 	 * ----------------------------------------------------------
 	 */

 	/**
 	 * The name of team must be unique in each game as it's used as identifier
 	 */
 	protected $name;

 	/**
 	 * @return string
 	 */
 	public function getName() : string {
 		return $this->name;
 	}

 	/**
 	 * 
 	 * @param bool $localize = true
 	 * @param string $lang = "en"
 	 * @return string
 	 */
 	public function getDisplayName(bool $localize = true, string $lang= "en") : string {
 		return ucfirst(Localizer::translate($lang, 'team.{$this->name}', [], $this->name));
 	}

 	/*
 	 * ----------------------------------------------------------
 	 * PLAYERS
 	 * ----------------------------------------------------------
 	 */

 	/**
 	 * @var Player[]
 	 */
 	protected $players = [];

 	/**
 	 * Get all players
 	 * @return Player[]
 	 */
 	public function getPlayers() : array {
 		return $this->players;
 	}

 	/**
 	 * Check if player is in this team
 	 * @param Player $player
 	 * @return bool
 	 */
 	public function isParticipant(Player $player) : bool {
 		return in_array($player, $this->players, true);
 	}

 	/**
 	 * Simply removes player form this team. For internal use.
 	 * Use Team::leave()
 	 * @param Player $player
 	 */
 	public function remove(Player $player) {
 		if($this->isParticipant($player))
 			unset($this->players[array_search($player, $this->players)]);
 	}

 	public function leave(Player $player) {
 		if($this->isParticipant($player)) {
 			$this->getGame()->leave($player);
 		}
 	}

 }