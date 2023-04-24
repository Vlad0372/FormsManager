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
    private const REWRITE_TXT = true;
    //private const SEARCH_ENGINE = 'google';
    private const SEARCH_ENGINE = 'bing';
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

        $myfile = fopen("txt_files/scrapedLinks.txt", "w") or die("Unable to open file!");
        $txt = "John Doe\n";
        fwrite($myfile, $txt);
        $txt = "Jane Doe\n";
        fwrite($myfile, $txt);
        fclose($myfile);

        return view('bip-parser.index');

    }
    public function parse(Request $request): View
    {
        if(self::REWRITE_TXT){

            $links = self::scrapeLinks()['links'];

            $txtFile = fopen("txt_files/scrapedLinks.txt", "w") or die("Unable to open file!");

            foreach($links as $link){
                fwrite($txtFile, $link . "\n");
            }

            fclose($txtFile);
        }else{
            $array = explode("\n", file_get_contents("txt_files/scrapedLinks.txt"));
            array_pop($array);

            //Log::info($array);
        }



        // if($request->input('action') == 'dirtyParse'){
        //     return view('bip-parser.index')->with('status', 'showLinks')
        //                                     ->with('links', $fullLinks);
        // }else{
        //     return view('bip-parser.index')->with('status', 'showLinks')
        //                                     ->with('links', $links);
        // }

        // $trimedLink =  'https://www.bip.ires.pl/czg&sa=U&ved=2ahUKEwif-t6Ns8P-AhVuzDgGHZVWCgoQFnoECAkQAg&usg=AOvVaw1jykwl8Wtue9RnYVV4SxIj';
        // $govno = explode('&', $trimedLink);
        // Log::info($govno);
         return view('bip-parser.index');
    }

    function scrapeLinks(){
        $pagesNumber = 5;
        $domainName = 'https://www.bip.ires.pl/';

        if(self::SEARCH_ENGINE == 'bing'){
            $i = 1;
            $urlBase = "https://www.bing.com/search?q=site%3Abip.ires.pl&first=";
        }else{
            $i = 0;
            $urlBase = "https://www.google.pl/search?q=site%3Abip.ires.pl&start=";
        }

        for (; $i < $pagesNumber * 10; $i+=10) {
            $url = $urlBase . $i;
            $page = file_get_contents($url, false);

            //Log::info($page);
            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($page);
            libxml_use_internal_errors(false);
            //Log::info($page);

            if(self::SEARCH_ENGINE == 'bing'){
                foreach ($doc->getElementsByTagName('cite') as $element) {
                    $link = $element->textContent;
                    $fullLinks[] =  $link;

                    if (str_contains($link, $domainName)) {
                        $trimedLink = strval(explode('/', $link)[3]);

                        if(!is_numeric($trimedLink)){
                            $subdomainNames[] =  $trimedLink;
                            $links[] = $domainName . $trimedLink;
                        }
                    }
                }
            }else{
                foreach ($doc->getElementsByTagName('a') as $element) {
                    if ($element->hasAttribute('href')) {
                        $link = $element->getAttribute('href');

                        $fullLinks[] =  $link;

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

            $subdomainNames = array_unique($subdomainNames);
            $links = array_unique($links);

            $arrayGroup = array(
                'subdomainNames' => $subdomainNames,
                'links' => $links,
                'fullLinks' => $fullLinks,
            );
        }



        Log::info($arrayGroup);

        return $arrayGroup;
        //Log::info($links);
    }
}
