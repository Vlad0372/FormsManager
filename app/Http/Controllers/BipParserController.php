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

    public function parse1(Request $request): View
    {
        
        $url = "/url?q=https://www.bip.ires.pl/sedziszow_mlp/drukuj_6426__127064__/&sa=U&ved=2ahUKEwj8nqrdqsP-AhWI7jgGHXnGDMg4ChAWegQICRAC&usg=AOvVaw1S8-ooaRWw_I7vO0z8X-4s";
        //$parts = parse_url($url);
        //Log::info($parts);

        $whatINeed = explode('/', $url);
        $whatINeed = $whatINeed[4];

        Log::info($whatINeed);

        return view('bip-parser.index');
                                            
    }
    public function parse(Request $request): View
    {
        //$request->input('action')
        
        //$pageStart = 10;
        $pagesNumber = 5;
        $domainName = 'https://www.bip.ires.pl/';
        
        //$link = "https://www.bip.ires.pl/sedziszow_mlp";

        for ($i = 0; $i < $pagesNumber * 10; $i+=10) {
            $url = "https://www.google.pl/search?q=site%3Abip.ires.pl&start=" . $i;
            $page = file_get_contents($url, false);
            // //https://www.google.pl/search?q=site%3Abip.ires.pl&start=10
            

            //Log::info($page);
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($page);
            libxml_use_internal_errors(false);
            //Log::info($page);
            if($request->input('action') == 'dirtyParse'){
                foreach ($doc->getElementsByTagName('a') as $element) {
                    if ($element->hasAttribute('href')) {
                        $link = $element->getAttribute('href');
                        
                        $fullLinks[] =  $link;          
                    }
                }
            }else{
                foreach ($doc->getElementsByTagName('a') as $element) {
                    if ($element->hasAttribute('href')) {
                        $link = $element->getAttribute('href');
                                        
                        if (str_contains($link, $domainName)) {
                            $trimedLink = strval(explode('/', $link)[4]);
                            
                            if(str_contains($trimedLink, '&')){
                                $trimedLink = strval(explode('&', $trimedLink)[0]);
                            }

                            if(!is_numeric($trimedLink)){
                                $subdomainNames[] =  $trimedLink;
                                $links[] = $domainName . $trimedLink; 
                            }                                       
                        }                              
                    }
                }
            } 
        }

        $subdomainNames = array_unique($subdomainNames);
        $links = array_unique($links);
        
        Log::info($links);
       
        return view('bip-parser.index')->with('status', 'showLinks')
                                      ->with('links', $links);
        // $trimedLink =  'https://www.bip.ires.pl/czg&sa=U&ved=2ahUKEwif-t6Ns8P-AhVuzDgGHZVWCgoQFnoECAkQAg&usg=AOvVaw1jykwl8Wtue9RnYVV4SxIj';
        // $govno = explode('&', $trimedLink); 
        // Log::info($govno);                  
        // return view('bip-parser.index');
    }
}
