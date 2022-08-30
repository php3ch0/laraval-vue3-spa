<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use DB;


class generateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate A Site Map';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //header
        $xml ='<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';

        $pages = [];
        //static pages
        $pages[] = ['/',1];
        $pages[] = ['/catering',0.9];
        $pages[] = ['/mobile-catering',0.9];
        $pages[] = ['/contact',0.9];
        $pages[] = ['/legal/terms',0.2];
        $pages[] = ['/legal/privacy',0.2];






        //now generate URLSET
        foreach($pages as $p) {
            $xml .='<url>
  <loc>'.url($p[0]).'</loc>
  <priority>'.$p[1].'</priority>
  </url>
';
        }

        $xml .='</urlset>';

        //save file
        $myfile = public_path("/sitemap.xml");

        @unlink($myfile);
        @touch($myfile);
        $fh = fopen($myfile, 'w') or die("can't open file");

        fwrite($fh, $xml);

        fclose($fh);
        return "Sitemap Generated Successfully";
    }
}
