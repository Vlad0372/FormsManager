<?php
    $foundLinks = [];
    $pagesContent = [];

    $maxPages = 30;

    $domainName = 'https://www.bip.ires.pl/';

    $url = "https://www.google.pl/search?q="; 
    $query = "site%3Abip.ires.pl&start="; 
    //  $url = "https://www.bing.com/search?q=";
    // $query = "site%3Abip.ires.pl&first="; 

    $i = 10;

    tryScrapeAgain:

    for (; $i <= $maxPages * 10; $i += 10) {
        $fullUrl = $url . $query . $i;
        $page = file_get_contents($fullUrl, false);

        if($page == false){
            echo('!!! SOMETHING WENT WRONG !!!');
            sleep(60*60*24);
            goto tryScrapeAgain;
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        libxml_use_internal_errors(false);
        
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

        //-------------------
        echo('Page number: '. ($i / 10));
        //echo("\n" . 'Links number: '. (count($links)));
        //echo(var_dump($cites));
        //echo("\n" . 'Cites number: '. (count($cites)));
        echo("\n\n");
        //-------------------

        // if(count($cites) == 0){        
        //     break;
        // }

        $pagesContent[] = $page;
        $foundLinks[] = $links;       
    }

    $foundLinks = array_values(array_unique($foundLinks));

    $txtFile = fopen("public/scraper_txts/htmls_json.txt", "w") or die("Unable to open file!");

    fwrite($txtFile, json_encode($pagesContent));
    fclose($txtFile);

    $txtFile = fopen("public/scraper_txts/cites_json.txt", "w") or die("Unable to open file!");

    fwrite($txtFile, json_encode($foundLinks));
    fclose($txtFile);
?>