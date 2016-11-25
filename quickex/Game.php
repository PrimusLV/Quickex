<?php
namespace quickex;

use quickex\entity\Player;
use quickex\entity\Team;
use localizer\Localizer;

/**
 * 
 */
abstract class Game {

	/*
	 * ----------------------------------------------------------
	 * PARTICIPATOR
	 * ----------------------------------------------------------
	 */

	/**
	 * @var Participant[]
	 */
	protected function $participators = [];

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

	public function 

	/*
	 * ----------------------------------------------------------
	 * NAME
	 * ----------------------------------------------------------
	 */

	/**
	 * Human readable game name. Usually language key
	 * Warning: Should not be used as identifier!
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
		return Localizer::translate($this->getName(), $language);
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
	 * STATE
	 * ----------------------------------------------------------
	 */

	/**
	 * @var State
	 */
	protected $state;

	/**
	 * @return State
	 */
	public function getState() : State {
		return $this->state;
	}

	/**
	 * @return State
	 */
	public function getNextState() : State {

	}

	/**
	 * @return State
	 */
	public function getPreviousState() : State {

	}

	/*
	 * ----------------------------------------------------------
	 * PLAYGROUND
	 * ----------------------------------------------------------
	 */

	/**
	 * @var PlayGround
	 */
	protected $playground;

	public function getPlayGround() : PlayGround {
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
		$this->getState()->tick();
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

}