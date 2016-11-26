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

abstract class StateBasedGame extends Game {

	/**
	 * @var State[]
	 */
	protected $states = [];


	/**
	 * @param State $state
	 * @throws InvalidArgumentException
	 */
	public function addState(State $state) {
		if($this->hasState($state)) 
			throw new \InvalidArgumentException("$this already has a state with id {$state->getID()}");
		$this->states[$state->getID()] = $state;
		$state->init();
	}

	/**
	 * @param State $state
	 * @return bool
	 */
	public function hasState(State $state) : bool {
		return isset($this->states[$state->getID()]);
	}

	/**
	 * @return State|null
	 * @throws \Exception
	 */
	public function getState($id) {
		if(!isset($this->states[$id]))
		{
			throw new \Exception("game has no state with id {$id}");
		}
		return $this->states[$id];
	}

	public function enterState(State $state, StateTransition $transition = null) {
		if(!$transition) { // Doesn't require any special transition.
			$this->setState($state->getID());
		} else {
			$this->transition = $transition;
		}
	}

	public function tick() {
		parent::tick();
		if($this->transition) 
		{
			if($this->transition->isCompleted()) 
			{
				$this->setState($this->transition->getTargetState());
			} 
			else 
			{
				$this->transition->tick();
			}
		}
	}

	/*
	 * ----------------------------------------------------------
	 * ABSTRACT FUNCTIONS
	 * ----------------------------------------------------------
	 */

	public abstract function initStatesList();

}