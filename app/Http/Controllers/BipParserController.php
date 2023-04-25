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
    //private const REWRITE_TXT = true;
    private const REWRITE_TXT = false;
    private const SEARCH_ENGINE = 'google';
    //private const SEARCH_ENGINE = 'bing';
    public function index(Request $request): View
    {
        return view('bip-parser.index');
    }

    public function parse(Request $request): View
    {
        if(self::REWRITE_TXT){
            $txtFile = fopen("txt_files/links_json.txt", "w") or die("Unable to open file!");
            $jsonArray = self::scrapeLinks();

            fwrite($txtFile, json_encode($jsonArray));
            fclose($txtFile);

            $txtFile = fopen("txt_files/page_htmls_json.txt", "w") or die("Unable to open file!");
            $jsonArray = self::getPagesHTML($jsonArray['links']);

            fwrite($txtFile, json_encode($jsonArray));
            fclose($txtFile);

            return view('bip-parser.index');
        }else{
            $jsonArray = json_decode(file_get_contents("txt_files/links_json.txt"), true);
            $jsonPagesArray = json_decode(file_get_contents("txt_files/page_htmls_json.txt"), true);

            $jsonArray['pageEmails'] = self::parsePages($jsonPagesArray);
        }

        return view('bip-parser.index')->with('status', 'showLinks')
                                        ->with('data', $jsonArray);
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

            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($page);
            libxml_use_internal_errors(false);

            if(self::SEARCH_ENGINE == 'bing'){
                foreach ($doc->getElementsByTagName('cite') as $element) {
                    $link = $element->textContent;
                    $allLinks[] =  $link;

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

                        $allLinks[] =  $link;

                        if (str_contains($link, $domainName)) {
                            $trimedLink = strval(explode('/', $link)[4]);

                            if(str_contains($trimedLink, '&')){
                                $trimedLink = strval(explode('&', $trimedLink)[0]);
                            }

                            if(!is_numeric($trimedLink) && !strlen($trimedLink) == 0){
                                $subdomainNames[] =  $trimedLink;
                                $links[] = $domainName . $trimedLink;
                            }
                        }
                    }
                }
            }
        }

        $subdomainNames = array_values(array_unique($subdomainNames));
        $links = array_values(array_unique($links));

        $arrayGroup = array(
            'subdomainNames' => $subdomainNames,
            'links' => $links,
            'allLinks' => $allLinks,
        );

        return $arrayGroup;
    }

    function getPagesHTML($urls){
        $pageHTMLs = [];

        foreach($urls as $url){
            $page = file_get_contents($url, false);

            $doc = new DOMDocument();
            libxml_use_internal_errors(true);
            $doc->loadHTML($page);
            libxml_use_internal_errors(false);

            $pageHTMLs[] = $page;
        }

        return $pageHTMLs;
    }

    function parsePages($pages){
        $allEmails = [];

        foreach($pages as $page){
            preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $page, $matches);

            if(count($matches[0]) != 0){
                $matches[0] = array_unique($matches[0]);
            }

            $allEmails[] = $matches[0];
        }
       
        return $allEmails;
    }
}
