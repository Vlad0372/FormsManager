<?php
    $urls = json_decode(file_get_contents("public/scraper_txts/links_json.txt"), true);

    $pageHTMLs = [];

    $linksIndex = 0;
    
    tryScrapeAgain:

    foreach($urls as $url){
        $page = file_get_contents($url, false);

        if($page == false){
            echo("\n !!! SOMETHING WENT WRONG !!! \n");  
            sleep(60*60*24);
            goto tryScrapeAgain;
        }

        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($page);
        libxml_use_internal_errors(false);

        $pageHTMLs[] = $page;

        echo("\n. " . $linksIndex . "\n");
        $linksIndex++;

        sleep(5);
    }

    $txtFile = fopen("public/scraper_txts/links_htmls_json.txt", "w") or die("Unable to open file!");
    fwrite($txtFile, json_encode($pageHTMLs));
    fclose($txtFile);

    $pages = $pageHTMLs;

    $allEmails = [];

    foreach($pages as $page){
        preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $page, $matches);

        if(count($matches[0]) != 0){
            $matches[0] = array_unique($matches[0]);
        }

        $allEmails[] = $matches[0];
    }
    
    $txtFile = fopen("public/scraper_txts/htmls_emails_json.txt", "w") or die("Unable to open file!");
    fwrite($txtFile, json_encode($allEmails));
    fclose($txtFile);

    echo("\nScraping has been ended. Check the txt files.\n");
?>