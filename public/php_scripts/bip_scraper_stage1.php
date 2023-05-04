<?php
    $foundLinks = [];
    $pagesContent = [];

    $maxPages = 50;

    $domainName = 'https://www.bip.ires.pl/';

    $url = "https://www.google.pl/search?q="; 
    $query = "site%3Abip.ires.pl&start="; 

    $i = 0;

    tryScrapeAgain:

    for (; $i <= $maxPages * 10; $i += 10) {
        echo("\n Page #: " . ($i/10) . " is being processed! \n");

        $fullUrl = $url . $query . $i;
        $page = file_get_contents($fullUrl, false);
       
        if($page == false){
            echo("\n !!! SOMETHING WENT WRONG !!! \n");  
            sleep(60*60*24);
            goto tryScrapeAgain;
        }
        
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);     
        $doc->loadHTML($page);
        libxml_use_internal_errors(false);

        //=================== last page finder ===================
        if($i > 10){
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
                echo("\nThe page number " . ($i / 10) . " is the last page.\n\n");
                break;
            } 
        }      
        //=================== last page finder ===================

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
                        $foundLinks[] = $domainName . $trimedLink;
                    }
                }
            }
        }

        $pagesContent[] = $page;
        sleep(10);
    }

    $foundLinks = array_values(array_unique($foundLinks));

    $txtFile = fopen("public/scraper_txts/htmls_json.txt", "w") or die("Unable to open file!");
    fwrite($txtFile, json_encode($pagesContent, JSON_INVALID_UTF8_IGNORE));
    fclose($txtFile);

    $txtFile = fopen("public/scraper_txts/links_json.txt", "w") or die("Unable to open file!");
    fwrite($txtFile, json_encode($foundLinks));
    fclose($txtFile);
?>