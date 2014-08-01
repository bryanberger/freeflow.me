<?php

class Post extends Eloquent {
	protected $guarded = array('id');

	public function getPaletteAttribute($value)
	{
		return unserialize($value);
	}

	public function setPaletteAttribute($value)
    {
        $this->attributes['palette'] = serialize($value);
    }

}