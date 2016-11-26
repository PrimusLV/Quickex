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

use quickex\entity\Player;
use quickex\entity\Team;
use localizer\Localizer;
use quickex\utils\UID;
use quickex\entity\Participant;
use quickex\playground\Playground;

/**
 * 
 */
abstract class Game implements Unique, Tickable {

	public function __construct(Playground $playground, array $participators = [], string $name = null) {
		if($name) $this->name = $name;
		$this->playground = $playground;
		$this->participators = $participators;
	}

	/*
	 * ----------------------------------------------------------
	 * PARTICIPATOR
	 * ----------------------------------------------------------
	 */

	/**
	 * @var Participant[]
	 */
	protected $participators = [];

	/**
	 * @return Participant[]
	 */
	public function getParticipators() : array {
		return $this->participators;
	}

	/**
	 * @return Player[]
	 */
	public function getPlayers() : array {
		$players = [];
		foreach($this->getParticipators() as $participator) {
			if(!($participator instanceof Player)) {
				$players[] = array_merge($participator->getPlayers(), $players);
			}
		}
		return $players;
	}

	/**
	 * Checks if the participant is in this game
	 *
	 * @param Participant $participant
	 * @return bool
	 */
	public function isParticipant(Participant $participant) : bool {
		foreach($this->participant as $p) {
			if($p instanceof Team && $participant instanceof Player) {
				if($p->isParticipant($participant)) return true;
			}
			if($p === $participant) return true;
		}
		return false;
	}

	/**
	 * @param Participant $participant
	 * @throws \InvalidArgumentException
	 */
	public function addParticipator(Participant $participant) {
		if($this->isParticipant($participant))
			throw new \InvalidArgumentException("$participant already is a participant of $this");
		$this->participators[] = $participant;
	}

	/*
	 * ----------------------------------------------------------
	 * NAME
	 * ----------------------------------------------------------
	 */

	/**
	 * Human readable game name. Usually language key
	 * Warning: Should not be used as an identifier!
	 * @var string
	 */
	protected $name = "game.undefined";

	/**
	 * @return string
	 */
	public function getName() : string {
		return $this->name;
	}

	/**
	 * Translated language key
	 * @return string
	 */
	public function getDisplayName(string $language = null) : string {
		return Localizer::translate($this->getName(), [], $language);
	}

	public function setName(string $name) {
		$this->name = $name;
	}

	/*
	 * ----------------------------------------------------------
	 * IDENTIFIER
	 * ----------------------------------------------------------
	 */

	/**
	 * Unique game identifier
	 * @var UID
	 */
	private $uid;

	/**
	 * @return UID
	 */
	public function getUniqueID() : UID {
		return $this->uid;
	}

	/*
	 * ----------------------------------------------------------
	 * PLAYGROUND
	 * ----------------------------------------------------------
	 */

	/**
	 * @var Playground
	 */
	protected $playground;

	public function getPlayground() : Playground {
		return $this->playground;
	}

	/*
	 * ----------------------------------------------------------
	 * DURATION
	 * ----------------------------------------------------------
	 */

	/**
	 * Game duration in seconds
	 * @var int
	 */
	protected $duration = 0;

	public final function getDuration() : int {
		return $this->duration;
	}

	/**
	 * Resets the duration to zero
	 */
	public final function resetDuration() {
		$this->duration = 0;
	}

	/**
	 * @param int $duration
	 */
	public final function setDuration(int $duration) {
		$this->duration = $duration;
	}

	/**
	 * Game tick happens every 20 ticks
	 */
	public function tick() {
		$this->duration++;
	}

	/*
	 * ----------------------------------------------------------
	 * ABSTRACT FUNCTIONS
	 * ----------------------------------------------------------
	 */

	/**
	 * In every game there's winner and loser
	 * @return Participant
	 */
	public abstract function getWinner() : Participant;

	/**
	 * In every game there's winner and loser
	 * @return Participant
	 */
	public abstract function getLoser() : Participant;

	/**
	 * Award the winner
	 */
	public abstract function awardWinner(Participant $participant);

	/**
	 * On Participant Join
	 * @param Participant
	 */
	public abstract function onJoin(Participant $participant);

	/**
	 * On Participant Leave
	 * @param Participant
	 */
	public abstract function onLeave(Participant $participant);

	/*
	 * ----------------------------------------------------------
	 * MAGIC FUNCTIONS
	 * ----------------------------------------------------------
	 */

	public function __toString() {
		return "Game#".$this->uid."(".$this->getDisplayName().")";
	}

}