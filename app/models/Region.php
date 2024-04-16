<?php

class Region extends Eloquent {

	/**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function id()
	{
		return $this->name;
	}
	
	/**
	 * Get the comment's content.
	 *
	 * @return string
	 */
	public function name()
	{
		return $this->name;
	}

}