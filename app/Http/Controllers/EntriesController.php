<?php

namespace App\Http\Controllers;

use App\Entries;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EntriesController extends Controller
{
	public function index($entries_id = null)
	{
		if (!! $entries_id)
		{
			$entries = Entries::findOrFail($entries_id)->jsonSerialize();
		}
		else
		{
			$entries = Entries::all()->jsonSerialize();
		}

		return response($entries, Response::HTTP_OK);

	}

	public function save(Request $request)
	{
		$entries_id = $request->entries_id;
		if (!!$entries_id)
		{
			$entries = Entries::findOrFail($entries_id);
		}
		else
		{
			$entries = new Entries();
			$entries->users_id = \Auth::user()->id;
		}

		$entries->title = $request->title;
		$entries->entry = htmlentities($request->entry);
		$entries->save();

		return response(null, Response::HTTP_OK);
	}

	public function destroy($entries_id)
	{
		Entries::destroy($entries_id);

		return response(null, Response::HTTP_OK);
	}
}
