<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use File;
use Image;
use App\Model\UserLevel;
use App\Model\System;
use App\Model\Page;
use App\Model\Social;
use App\Model\Newsletter;
use App\Model\Contact;
use App\Model\NewsCategory;
use App\Model\News;
use App\Model\Slider;
use Illuminate\Support\Str;

use function PHPUnit\Framework\fileExists;

class FrontController extends Controller
{
    public function __construct()
    {
        @session_start();
        //logo
        $logo=System::select('Description')->where('Code','logo')->first();
        view()->share('logo',$logo);
        ///mạng xã hội
        $favicon=System::select('Description')->where('Code','favicon')->first();
        view()->share('favicon',$favicon);
         ///coppyright
         $copyright=System::select('Description')->where('Code','copyright')->first();
         view()->share('copyright',$copyright);
        //social
        $Social=Social::where('Status',1)->selectRaw('Name,Font,Alias')->orderBy('Sort','ASC')->get();
        view()->share('Social',$Social);

        $Page=Page::where('Status',1)->selectRaw('Name,Font,Alias')->orderBy('Sort','ASC')->get();
        view()->share('Page',$Page);



    }
    public function home(){
        $News = DB::table('news as a')
        ->join ('news_cat as b','a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*,b.Name as CategoryName')
        ->where('a.RowIDCat',2)
        ->orderBy('a.RowID','DESC')
        ->limit(6)->get();

        $NewsSale = DB::table('news as a')
        ->join ('news_cat as b','a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*,b.Name as CategoryName')
        ->where('a.RowIDCat',1)
        ->orderBy('a.RowID','DESC')
        ->limit(4)->get();

        $NewsView = DB::table('news as a')
        ->join ('news_cat as b','a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*,b.Name as CategoryName')
        ->orderBy('a.View','DESC')
        ->limit(4)->get();
        $Slider=Slider::where('Status',1)->selectRaw('Name,Alias,Images')
        ->orderBy('Sort','ASC')->get();


        return view('front.home.home',compact('News','NewsSale','NewsView','Slider'));
    }
    public function contact(){

        echo 'đep lắm';
    }

 }
