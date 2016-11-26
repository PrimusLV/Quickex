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
namespace quickex\controller;

use quickex\Quickex;

abstract class Controller implements \ArrayAccess {

    /**
     * @var Quickex
     */
    protected $quickex;

    public function __construct(Quickex $quickex) {
        $this->quickex = $quickex;
    }

    public function getQuickex() : Quickex {
        return $this->quickex;
    }
	
	/**
	 * @var mixed
	 */
	protected $container = [];

	public function offsetExists($offset) {
		return isset($this->container[$offset]);
	}

	public function offsetUnset($offset) {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset) {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function contains($value, $strict = true) : bool {
    	return in_array($value, $this->container, $strict);
    }

    /*
     * ----------------------------------------------------------
     * LOGIC
     * ----------------------------------------------------------
     */

    /**
     * Handle shutdown if necessary.
     */
    public function shutdown() {

    }

    public function tick() {
        foreach($this->container as $item) {
            $item->tick();
        }
    }

    /*
     * ----------------------------------------------------------
     * ABSTRACT FUNCTIONS
     * ----------------------------------------------------------
     */


}