<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Logo;
use App\Models\Seo;
use App\Services\DataHandlingService;

class UtilsController extends Controller
{
    public function utils()
    {
        return view(
            'utils',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsGjj()
    {
        return view(
            'utils-gjj',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsZuhe()
    {
        return view(
            'utils-zuhe',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsTiqian()
    {
        return view(
            'utils-tiqian',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsLicai()
    {
        return view(
            'utils-licai',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsGongzi()
    {
        return view(
            'utils-gongzi',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsNzj()
    {
        return view(
            'utils-nzj',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    public function utilsWxyj()
    {
        return view(
            'utils-wxyj',
            [
                'help' => DataHandlingService::help(),  //系统设置
                'logo' => Logo::first(),
                'advert' => Ad::all()->toArray(),
                'seo' => Seo::all()->toArray()
            ]
        );
    }

    /**
     * sitemap download
     */
    public function sitemapDownload()
    {
        $file = public_path('sitemap.zip');

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: '.filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

        echo '<script>window.close();</script>';
    }

    /**
     * 小程序sitemap下载
     */
    public function mpsitemapDownload()
    {
        $file = public_path('mpsitemap.txt');
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: text/plain');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: '.filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }

        echo '<script>window.close();</script>';
    }
}
