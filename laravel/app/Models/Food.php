<?php

namespace App\Models;

use Doctrine\DBAL\Exception\DatabaseObjectExistsException;

class Food extends \App\Models\Base\Food
{
	protected $fillable = [
		'isfood'
	];

    /** This function represent food as JSON object that can be accepted by jsTree library
     * @param $locale
     * @return array jsonObject as named array for jsTree library
     * @throws DatabaseObjectExistsException
     */
	public function toCustomJson($locale) {


	    $id = $this->path;

	    //finding parent id using material path
	    $slashCount = substr_count($id, '/'); //TODO '/' is duplicated knowledge, how  can we get rid of it?
	    if ( $slashCount > 1) { // if not root node
            $parent = substr($id,0,strrpos($id,'/',-1));
        } else if ($slashCount == 1) { //root node
	        $parent = '#';
        } else { //should never happen
	        throw new DatabaseObjectExistsException("Wrong foodpath in DB");
        }

        $text = $this->food_transls()->where('language_code', $locale)->first()->name;

	    return compact('id','parent','text');

    }
}
