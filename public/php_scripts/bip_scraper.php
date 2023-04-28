<?php
    $foundLinks = [];
    $pagesContent = [];

    $maxPages = 35;

    $domainName = 'https://www.bip.ires.pl/';

    $url = "https://www.google.pl/search?q="; 
    $query = "site%3Abip.ires.pl&start="; 
    $query =  "php+file+get+contents+429+error&start=";
    //  $url = "https://www.bing.com/search?q=";
    // $query = "site%3Abip.ires.pl&first="; 

    $i = 80;

    tryScrapeAgain:

    for (; $i <= $maxPages * 10; $i += 10) {
        $fullUrl = $url . $query . $i;
        $page = file_get_contents($fullUrl, false);
        //$page = fopen("public/scraper_txts/bruh.txt", "r") or die("Unable to open file!");
        //$page = true;

        if($page == false){
            echo("\n !!! SOMETHING WENT WRONG !!! \n");
            $i += 10;
            //sleep(60*60*24);
            sleep(10);
            goto tryScrapeAgain;
        }
        //echo(var_dump($page));
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        //$doc->validateOnParse = true;
        $doc->loadHTML($page);
        //$dom->preserveWhiteSpace = false;
        //$doc->validate();
        libxml_use_internal_errors(false);

        $classname="qFvlD";
        $finder = new DomXPath($doc);
        $spaner = $finder->query("//*[contains(@class, '$classname')]");

        if(count($spaner) > 0){
            foreach($spaner as $elem){
                $isLastPage = true;
                if($elem->textContent == '>'){
                    $isLastPage = false;
                }
            }
        }else{
            echo("\nElements with such a class dont exist.\n");
        }   
        
        if($isLastPage){
            echo('The page number ' . ($i / 10) . ' is the last page.');
            break;
        } 
        //echo $bruh->attributes->getNamedItem("span");
        // foreach ($doc->getElementsByTagName('span') as $element) {

        // }
        //$img = $dom->getElementsByTagName('img')->item(0);
//echo $img->attributes->getNamedItem("src")->value;
        //$crack = $bruh->item(0);
        //$crack-
        //echo(var_dump($crack));
        sleep(10);
        //qFvlD
        //echo(var_dump($doc->getElementById('pnnext')));

        //echo($page);

        // $dom = new DOMDocument();
        // $html ='<html>
        // <body>Hello <b id="bid">World</b>.</body>
        // </html>';
        // $dom->validateOnParse = true; //<!-- this first
        // $dom->loadHTML($page);        //'cause 'load' == 'parse

        // $dom->preserveWhiteSpace = false;

        // $belement = $dom->getElementById("pnnext");
        // echo $belement->nodeValue;



        // if($doc->getElementById('pnnext') == null){
        //     echo("\n Page #: " . ($i/10) . " is the last page! \n");
        // }
        
      
        // foreach ($doc->getElementsByTagName('a') as $element) {
        //     if ($element->hasAttribute('href')) {
        //         $link = $element->getAttribute('href');

        //         $allLinks[] =  $link;

        //         if (str_contains($link, $domainName)) {
        //             $trimedLink = strval(explode('/', $link)[4]);

        //             if(str_contains($trimedLink, '&')){
        //                 $trimedLink = strval(explode('&', $trimedLink)[0]);
        //             }

        //             if(!is_numeric($trimedLink) && !strlen($trimedLink) == 0){
        //                 $subdomainNames[] =  $trimedLink;
        //                 $links[] = $domainName . $trimedLink;
        //             }
        //         }
        //     }
        // }

        //-------------------
        //echo('Page number: '. ($i / 10));
        //echo("\n" . 'Links number: '. (count($links)));
        //echo(var_dump($cites));
        //echo("\n" . 'Cites number: '. (count($cites)));
        //echo("\n\n");
        //-------------------

        // if(count($cites) == 0){        
        //     break;
        // }

        //$pagesContent[] = $page;
        //$foundLinks[] = $links;       
    }
    echo("\n\nloop broke\n");
    // $foundLinks = array_values(array_unique($foundLinks));

    // $txtFile = fopen("public/scraper_txts/htmls_json.txt", "w") or die("Unable to open file!");

    // fwrite($txtFile, json_encode($pagesContent));
    // fclose($txtFile);

    // $txtFile = fopen("public/scraper_txts/cites_json.txt", "w") or die("Unable to open file!");

    // fwrite($txtFile, json_encode($foundLinks));
    // fclose($txtFile);
?>