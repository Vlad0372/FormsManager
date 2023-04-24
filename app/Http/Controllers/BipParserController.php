<?php

namespace App\Http\Controllers;

use DOMDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class BipParserController extends Controller
{
    public function index(Request $request): View
    {
        return view('bip-parser.index');
    }

    public function parse(Request $request): View
    {
       
        $page = file_get_contents("https://www.google.pl/search?q=site%3Abip.ires.pl", false);
        //https://www.google.pl/search?q=site%3Abip.ires.pl
        
        //Log::info($page);
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        libxml_use_internal_errors(false);

        foreach ($doc->getElementsByTagName('a') as $element) {
            if ($element->hasAttribute('href')) {
                $link = $element->getAttribute('href');

                if (str_contains($link, 'https://www.bip.ires.pl')) {
                    $links[] =  $link;
                }              
            }
        }
        $arra2y = array(
            1    => "a",
            "1"  => "b",
            1.5  => "c",
            true => "d",
        );
        $govno = 'govwee';
        Log::info($links);
        //Log::info(var_dump($links));
        // //Log::info($doc->saveHTML());
        Session::flash('status','showLinks');
        //['myAppForms' => AppForm::all()->where('author_id','=',auth()->user()->id)->reverse()]
        //$request->session()->flush('successMsg','Saved succesfully!');
        return view('bip-parser.index')->with('status', 'showLinks')
                                       ->with('links', $links);
                                            
    }
}
