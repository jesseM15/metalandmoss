<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pages;

class PagesController extends Controller
{
    public function index($path = null)
	{
		// If we let uri be not unique and rely on the admin to create unique paths 
		// the worst thing that happens is the duplicate path will not be displayed 
		// until it is corrected.  This is pretty much fine I'd say.

		// We could put a nav_only field so that a page can function as a hierachical 
		// section and a uri segment, but does not serve as an endpoint itself.  If 
		// this is the case we could make content not required.  The worst thing that 
		// happens here is a real page gets left empty on accident.

		// Need to add a new field (or something) for not displaying a page in nav.

		if ($path !== null)
		{
			$pathArray = explode('/', $path);
			$lastSegment = $pathArray[array_key_last($pathArray)];

			// Get id, uri, and parent for all pages marked published that match one of the uri segments.
			// Iterate through each one that matches the last segment and see if its parents match the full path.
			// If it does then find the page by id and return content, etc.

			$queryPages = Pages::select('id', 'uri', 'parent')->whereIn('uri', $pathArray)->where('status', 'published')->get();

			foreach ($queryPages as $page)
			{
				if ($page->uri === $lastSegment)
				{
					if ($this->getParentPageUris($queryPages, $page->id) === array_reverse($pathArray))
					{
						$data['page'] = Pages::find($page->id);
					}
				}
			}

		}

		$data['page'] = $data['page'] ?? Pages::find(1); 	// TODO: Show 404 if page not found.

		$data['nav_pages'] = $this->getNav();

		return view('page', $data);
	}

	// Get only the pages that match the last uri segment.
	// Loop through these and recursively check the parent until it is null.
	// Add the uri to an array for each segment and if it matches pathArray when the parent is null we've found our page!
	private function getParentPageUris($pages, $id, &$path = [])
	{
		foreach ($pages as $page)
		{
			if ($page->id === $id)
			{
				$path[] = $page->uri;
				if ($page->parent !== null)
				{
					return $this->getParentPageUris($pages, $page->parent, $path);
				}
				else
				{
					return $path;
				}
			}
		}
	}

	// TODO: Use eloquent relationship to do this instead of parent id.
	// Or even better: Simply query all published pages and sort the results.
	private function getNav($parent = null)
	{
		$nav = [];
		$pages = Pages::select('id', 'uri', 'title', 'nav_only')->where('status', 'published')->where('parent', $parent)->orderBy('order', 'asc')->get();

		foreach ($pages as $page)
		{
			$navItem = new \stdClass();
			$navItem->uri = $page->uri;
			$navItem->title= $page->title;
			$navItem->nav_only = $page->nav_only;
			if ($subPages = $this->getNav($page->id))
			{
				$navItem->pages = $subPages;
			}
			$nav[] = $navItem;
		}

		return $nav;
	}

	public function home()
	{
		$data['nav_pages'] = $this->getNav();
		return view('home', $data);
	}
}