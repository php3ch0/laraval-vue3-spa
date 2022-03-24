<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use DB;
use App\Models\Services;
use App\Models\Galleries;
use App\Models\Blog;


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
        $pages[] = ['/about',0.6];
        $pages[] = ['/services',0.7];
        $pages[] = ['/blog',0.7];
        $pages[] = ['/login',0.4];
        $pages[] = ['/gallery',0.4];
        $pages[] = ['/contact',0.7];
        $pages[] = ['/legal',0.3];
        $pages[] = ['/privacy',0.3];
        $pages[] = ['/cookies',0.3];

        //categories
        $items = Services::all();
        foreach($items as $p) {
            $pages[] = [$p->url,0.8];
        }

        //products
        $items = Galleries::all();
        foreach($items as $p) {
            $pages[] = [$p->url,0.4];
        }

        //Blog Pgaes
        $blogs = Blog::all();
        foreach($blogs as $p) {
            $pages[] = [$p->url,0.6];
        }

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
