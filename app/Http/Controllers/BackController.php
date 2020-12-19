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

use function PHPUnit\Framework\fileExists;

class BackController extends Controller
{
    public function __construct()
    {
        @session_start();
    }
    public function home(){

        return view('back.home.home');
    }
    ///staff profile
    public function staff_profile(){
        return view('back.staff.profile');
    }
    public function staff_profile_post(Request $request){
        if($request->fullname == '' || $request->email==''||$request->phone==''){

            return redirect('admin/staff/profile')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $User = User::find($request->id);
        $User->fullname=$request->fullname;
        $User->address=$request->address;
        $User->email=$request->email;
        $User->phone=$request->phone;
        if(isset($request->password) && $request->password !=''){
            $User->password=bcrypt($request->password);
        }
       $Flag=$User->save();
        if($Flag==true){
            return redirect('admin/staff/profile')->with(['flash_level'=>'success','flash_message' => 'Cập nhật tài khoản thành công.']);
        }else{
            return redirect('admin/staff/profile')->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa tài khoản không thành công.']);

        }

    }
    public function staff_list(){
         $User= DB::table('users as a')
         -> join('users_level as b','a.level','=','b.id')
         ->selectRaw('a.id,a.fullname,a.address,a.email,a.phone,b.name')->get();
         return view('back.staff.list',compact('User'));
    }
    public function staff_add(){
        $UserLevel=UserLevel::where('status',1)->get();

        return view('back.staff.add',compact('UserLevel'));
    }

    public function staff_add_post(Request $request){
        if($request->fullname == '' || $request->email==''||$request->phone=='' || $request->username=='' || $request->password==''){

            return redirect('admin/staff/add')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $User =new User;
        $User->level=$request->level;
        $User->status=1;
        $User->username=$request->username;
        $User->password=bcrypt($request->password);
        $User->fullname=$request->fullname;
        $User->address=$request->address;
        $User->email=$request->email;
        $User->phone=$request->phone;
        $Flag= $User->save();
        if($Flag==true){
            return redirect('admin/staff/add')->with(['flash_level'=>'success','flash_message' => 'Thêm nhân viên thành công.']);
        }else{
            return redirect('admin/staff/add')->with(['flash_level'=>'danger','flash_message' => 'Lỗi thêm nhân viên.']);

        }
    }
    public function staff_edit(Request $request,$id)
       {
        $User=User::find($id);
        $UserLevel=UserLevel::where('status',1)->get();
        return view('back.staff.edit',compact('User','UserLevel'));
       }

    public function staff_edit_post(Request $request,$id){
        if($request->fullname == '' || $request->email==''||$request->phone==''){

            return redirect('admin/staff/edit')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $User =User::find($id);
        $User->level=$request->level;
        $User->status=$request->status;
        if(isset($request->password) && $request->password !=''){
            $User->password=bcrypt($request->password);
        }
        $User->fullname=$request->fullname;
        $User->address=$request->address;
        $User->email=$request->email;
        $User->phone=$request->phone;
        $Flag= $User->save();
        if($Flag==true){
            return redirect('admin/staff/edit/'.$id)->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa nhân viên thành công.']);
        }else{
            return redirect('admin/staff/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa nhân viên không thành công.']);

        }

    }
    public function staff_delete(Request $request,$id)
    {
        $User =User::find($id);
        $Flag=$User ->delete();
        if($Flag==true){
            return redirect('admin/staff/list/')->with(['flash_level'=>'success','flash_message' => 'Xóa nhân viên thành công.']);
        }else{
            return redirect('admin/staff/list/')->with(['flash_level'=>'danger','flash_message' => 'Xóa nhân viên không thành công.']);

        }
    }
    //staff management....


    //system menagement......
    public function system(){
        $name=System::where('Status',1)->where('Code','name')->first();
        $email=System::where('Status',1)->where('Code','email')->first();
        $phone=System::where('Status',1)->where('Code','phone')->first();
        $address=System::where('Status',1)->where('Code','address')->first();
        $copyright=System::where('Status',1)->where('Code','copyright')->first();
        $logo=System::where('Status',1)->where('Code','logo')->first();
        $favicon=System::where('Status',1)->where('Code','favicon')->first();
        return view('back.system.system',compact('name','logo','email','favicon','address','copyright','phone'));
    }
    public function system_post(Request $request){
        if($request->name == '' || $request->email==''||$request->phone==''){

            return redirect('admin/system')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        //update tên công ty
        System::where('Status', 1)
          ->where('Code', 'name')
          ->update(['Description' => $request->name]);


          System::where('Status', 1)
          ->where('Code', 'email')
          ->update(['Description' => $request->email]);


          System::where('Status', 1)
          ->where('Code', 'phone')
          ->update(['Description' => $request->phone]);


          System::where('Status', 1)
          ->where('Code', 'address')
          ->update(['Description' => $request->address]);


          System::where('Status', 1)
          ->where('Code', 'copyright')
          ->update(['Description' => $request->copyright]);

          if(!empty($request->file('logo'))){
                $logo= System::where('Status', 1)->where('Status', 1)->where('Code','logo')->first();
                $path='images/logo/'.$logo->Description;
                if(File::exists($path)){
                    File::delete($path);
                }
                //upload image
                $name=$request->file('logo')->getClientOriginalName();
                $request->file('logo')->move('images/logo/',$name);
                $logo->Description=$name;
                $logo->save();
        }
        if(!empty($request->file('favicon'))){
            $logo= System::where('Status', 1)->where('Status', 1)->where('Code','favicon')->first();
            $path='images/favicon/'.$logo->Description;
            if(File::exists($path)){
                File::delete($path);
            }
            //upload image
            $name=$request->file('favicon')->getClientOriginalName();
            $request->file('favicon')->move('images/favicon/',$name);
            $logo->Description=$name;
            $logo->save();
        }

       return redirect('admin/system')->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa thành công.']);
    }
    ///system management.

    ///page management
    public function page_list()
    {
        $Page= Page::get();

       return view('back.page.list',compact('Page'));
    }
    public function page_edit(Request $request, $id){
        $Page= Page::find($id);
        return view('back.page.edit',compact('Page'));
    }
    public function page_edit_post(Request $request, $id){
        if($request->Name == ''){

            return redirect('admin/page/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $Page =Page::find($id);
        $Page->Name=$request->Name;
        $Page->Alias=$request->Alias;
        $Page->Status=$request->Status;
        $Page->Font=$request->Font;
        $Page->Sort=$request->Sort;
        $Page->MetaTitle=$request->MetaTitle;
        $Page->MetaDescription=$request->MetaDescription;
        $Page->MetaKeyword=$request->MetaKeyword;
        $Page->Description=$request->Description;
        $Flag= $Page->save();
        if($Flag==true){
            return redirect('admin/page/edit/'.$id)->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa trang thành công.']);
        }else{
            return redirect('admin/page/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa trang không thành công.']);

        }

    }
    //Mạng xã hội-----///
    public function social_list(){
        $Social= Social::get();

       return view('back.social.list',compact('Social'));
    }
    public function social_edit(Request $request, $id){
        $Social= Social::find($id);
        return view('back.Social.edit',compact('Social'));
    }
    public function social_edit_post(Request $request, $id){
        if($request->Name == '' || $request->Font==''){

            return redirect('admin/social/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $Social =Social::find($id);
        $Social->Name=$request->Name;
        $Social->Status=$request->Status;
        $Social->Font=$request->Font;
        $Social->Sort=$request->Sort;
        $Flag= $Social->save();
        if($Flag==true){
            return redirect('admin/social/edit/'.$id)->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa trang thành công.']);
        }else{
            return redirect('admin/social/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa trang không thành công.']);

        }

    }
    ///Qản lý tin khuyến mãi
    public function newsletter_list()
    {
        $Newsletter= Newsletter::get();

       return view('back.newsletter.list',compact('Newsletter'));
    }
    public function newsletter_edit(Request $request, $id){
        $Newsletter= Newsletter::find($id);
        return view('back.newsletter.edit',compact('Newsletter'));
    }
    public function newsletter_edit_post(Request $request, $id){
        if($request->Email== ''){

            return redirect('admin/newsletter/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $Newsletter =Newsletter::find($id);
        $Newsletter->Email=$request->Email;
        $Newsletter->IsViews=$request->IsViews;
        $Flag= $Newsletter->save();
        if($Flag==true){
            return redirect('admin/newsletter/edit/'.$id)->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa  khuyến mại thành công.']);
        }else{
            return redirect('admin/newsletter/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa  khuyến mại không thành công.']);

        }

    }
    public function newsletter_delete(Request $request, $id){
        $Newsletter =Newsletter::find($id);
        $Flag=$Newsletter->delete();
        if($Flag==true){
            return redirect('admin/newsletter/list/')->with(['flash_level'=>'success','flash_message' => 'Xóa email khuyến mại thành công.']);
        }else{
            return redirect('admin/newsletter/list/')->with(['flash_level'=>'danger','flash_message' => 'Xóa email khuyến mại không thành công.']);

        }
    }
    ///Quản lý liên hệ.
    public function contact_list()
    {
        $Contact= Contact::get();

       return view('back.contact.list',compact('Contact'));
    }
    public function contact_edit(Request $request, $id){
        $Contact= Contact::find($id);
        return view('back.contact.edit',compact('Contact'));
    }
    public function contact_edit_post(Request $request, $id){
        if($request->Name == '' || $request->Email==''||$request->Phone==''){

            return redirect('admin/contact/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $Contact =Contact::find($id);
        $Contact->Name=$request->Name;
        $Contact->Email=$request->Email;
        $Contact->Phone=$request->Phone;
        $Contact->Message=$request->Message;
        $Contact->IsViews=$request->IsViews;
        $Flag= $Contact->save();
        if($Flag==true){
            return redirect('admin/contact/edit/'.$id)->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa liên hệ khuyến mại thành công.']);
        }else{
            return redirect('admin/contact/edit/'.$id)->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa liên hệ khuyến mại không thành công.']);

        }

    }
    public function contact_delete(Request $request, $id){
        $Contact =Contact::find($id);
        $Flag=$Contact->delete();
        if($Flag==true){
            return redirect('admin/contact/list/')->with(['flash_level'=>'success','flash_message' => 'Xóa liên hệ khuyến mại thành công.']);
        }else{
            return redirect('admin/contact/list/')->with(['flash_level'=>'danger','flash_message' => 'Xóa liên hệ khuyến mại không thành công.']);

        }
    }
    ////new  category
    public function news_cat_list(){
        $NewsCategory = NewsCategory::where('Status',1)->get();
        return view('back.news.cat_list',compact('NewsCategory'));
    }
    public function news_cat_getedit($RowID){
        $NewsCategory = NewsCategory::find($RowID);
        return view('back.news.cat_edit',compact('NewsCategory'));
    }
    public function news_cat_edit_post(Request $request, $RowID){
        if($request->Name == ''){

            return redirect('admin/news_cat/edit/'.$RowID)->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $NewsCategory =NewsCategory::find($RowID);
        $NewsCategory->Name=$request->Name;
        $NewsCategory->Status=$request->Status;
        $Flag= $NewsCategory->save();
        if($Flag==true){
            return redirect('admin/news_cat/edit/'.$RowID)->with(['flash_level'=>'success','flash_message' => 'Chỉnh sửa thành công.']);
        }else{
            return redirect('admin/news_cat/edit/'.$RowID)->with(['flash_level'=>'danger','flash_message' => 'Chỉnh sửa không thành công.']);

        }
    }
    /////newwww management
    public function news_list(){
        $News = DB::table('news as a')
        ->join ('news_cat as b','a.RowIDCat','=','b.RowID')
        ->selectRaw('a.*,b.Name as CategoryName')
        ->orderBy('a.RowID','DESC')
        ->get();
        return view('back.news.list',compact('News'));
    }
    public function news_getadd(){
        $NewsCategory = NewsCategory::get();
        return view('back.news.add',compact('NewsCategory'));
    }
    public function news_add(Request $request){
        if($request->Name == ''||$request->Description == '' ){
            return redirect('admin/news/add/')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $News = new News;
        $News->RowIDCat=$request->RowIDCat;
        $News->Status=$request->Status;
        $News->Name=$request->Name;
        $News->Alias=$request->Alias;
        $News->View=$request->View;
        $News->MetaTitle=$request->MetaTitle;
        $News->MetaDescription=$request->MetaDescription;
        $News->MetaKeyword=$request->MetaKeyword;
        $News->SmallDescription=$request->SmallDescription;
        $News->Description=$request->Description;
        if($request->hasFile('Images')){
            $file=$request->file('Images');
            $random_digit=rand(000000000,999999999);
            $name=$random_digit.'-'.$file->getClientOriginalName();
            $duoi=strtolower($file->getClientOriginalExtension());
            if($duoi !='png' && $duoi !='jpg' && $duoi !='jpeg' &&$duoi !='svg'){
                return back()->with(['flash_level' => 'danger','flash_message'=> trans('back.ad_error_images_ex')]);
            }
            $file ->move('images/news',$name);
            $img=Image::make('images/news/'.$name);
            ///Kiểm tra, nếu không tồn tại thì tao folder
            $filePath='images/news/'.date('Ymd');
            if(!file_exists($filePath)){
                mkdir('images/news/'.date('Ymd'),0777,true);
            }
            $img->fit(208,141);
            $img->save('images/news/'.date('Ymd').'/'.$name);
            //delete images upload
           // if(file_exists('images/news/'.$name)){
              //  unlink('images/news/'.$name);
           // }
           $News->Images=date('Ymd'.'/').$name;
       }
        $Flag= $News->save();
        if($Flag==true){
            return redirect('admin/news/add')->with(['flash_level'=>'success','flash_message' => 'Thêm thành công.']);
        }else{
            return redirect('admin/news/add')->with(['flash_level'=>'danger','flash_message' => 'Thêm không thành công.']);

        }
    }
    public function news_delete(Request $request,$RowID){
        $News =News::find($RowID);
        if($News->Images !='')
        {
             if(file_exists('images/news/'.$News->Images)){
                unlink('images/news/'.$News->Images);
             }
        }
        $Flag=$News->delete();
        if($Flag==true){
            return redirect('admin/news/list/')->with(['flash_level'=>'success','flash_message' => 'Xóa email khuyến mại thành công.']);
        }else{
            return redirect('admin/news/list/')->with(['flash_level'=>'danger','flash_message' => 'Xóa email khuyến mại không thành công.']);

        }
    }
    public function news_getedit(Request $request,$RowID){
        $NewsCategory = NewsCategory::get();
        $News =News::find($RowID);
        return view('back.news.edit',compact('News','NewsCategory'));
    }
    public function news_edit(Request $request, $RowID){
        if($request->Name == ''||$request->Description == '' ){
            return redirect('admin/news/edit/'.$RowID)->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $News = News::find($RowID);
        $News->RowIDCat=$request->RowIDCat;
        $News->Status=$request->Status;
        $News->Name=$request->Name;
        $News->Alias=$request->Alias;
        $News->View=$request->View;
        $News->MetaTitle=$request->MetaTitle;
        $News->MetaDescription=$request->MetaDescription;
        $News->MetaKeyword=$request->MetaKeyword;
        $News->SmallDescription=$request->SmallDescription;
        $News->Description=$request->Description;
        if($request->hasFile('Images')){
             $file=$request->file('Images');
             $random_digit=rand(000000000,999999999);
             $name=$random_digit.'_'.$file->getClientOriginalName();
             $duoi=strtolower($file->getClientOriginalExtension());
             if($duoi !='png' && $duoi !='jpg' && $duoi !='jpeg' &&$duoi !='svg'){
                 return back()->with(['flash_level' => 'danger','flash_message'=> trans('back.ad_error_images_ex')]);
             }
             if($News -> news_images !=''){
                 if(fileExists('images/news/'.$News->news_images)){
                     unlink('images/news/'.$News->news_images);
                 }
             }
             $file ->move('images/news',$name);
             $img=Image::make('images/news/'.$name);
             ///Kiểm tra, nếu không tồn tại thì tao folder
             $filePath='images/news/'.date('Ymd');
             if(!file_exists($filePath)){
                 mkdir('images/news/'.date('Ymd'),0777,true);
             }
             $img->fit(208,141);
             $img->save('images/news/'.date('Ymd').'/'.$name);
            /// delete images upload
             if(file_exists('images/news/'.$name)){
              unlink('images/news/'.$name);
             }
            $News->Images=date('Ymd').'/'.$name;
        }
        $Flag= $News->save();
        if($Flag==true){
            return redirect('admin/news/edit/'.$RowID)->with(['flash_level'=>'success','flash_message' => 'Sửa thành công.']);
        }else{
            return redirect('admin/news/edit/'.$RowID)->with(['flash_level'=>'danger','flash_message' => 'Thêm không thành công.']);

        }
    }




    /////slider managemen
    public function slider_list(){
        $Slider = Slider::selectRaw('*')
        ->orderBy('RowID','DESC')
        ->get();
        return view('back.slider.list',compact('Slider'));
    }
    public function slider_getadd(){
        return view('back.slider.add');
    }
    public function slider_add(Request $request){
        if($request->Name == ''||$request->Alias == '' ){
            return redirect('admin/slider/add/')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $Slider = new Slider;

        $Slider->Status=$request->Status;
        $Slider->Name=$request->Name;
        $Slider->Alias=$request->Alias;
        $Slider->Sort=$request->Sort;

        if($request->hasFile('Images')){
            $file=$request->file('Images');
            $random_digit=rand(000000000,999999999);
            $name=$random_digit.'-'.$file->getClientOriginalName();
            $duoi=strtolower($file->getClientOriginalExtension());
            if($duoi !='png' && $duoi !='jpg' && $duoi !='jpeg' &&$duoi !='svg'){
                return back()->with(['flash_level' => 'danger','flash_message'=> trans('back.ad_error_images_ex')]);
            }
            $file ->move('images/slider',$name);
            $img=Image::make('images/slider/'.$name);
            ///Kiểm tra, nếu không tồn tại thì tao folder
            $filePath='images/slider/'.date('Ymd');
            if(!file_exists($filePath)){
                mkdir('images/slider/'.date('Ymd'),0777,true);
            }
            $img->fit(1920,760);
            $img->save('images/slider/'.date('Ymd').'/'.$name);
            //delete images upload
           // if(file_exists('images/news/'.$name)){
              //  unlink('images/news/'.$name);
           // }
           $Slider->Images=date('Ymd'.'/').$name;
       }
        $Flag= $Slider->save();
        if($Flag==true){
            return redirect('admin/slider/add')->with(['flash_level'=>'success','flash_message' => 'Thêm thành công.']);
        }else{
            return redirect('admin/slider/add')->with(['flash_level'=>'danger','flash_message' => 'Thêm không thành công.']);

        }
    }
    public function slider_delete(Request $request,$RowID){
        $Slider =Slider::find($RowID);
        if($Slider->Images !='')
        {
             if(file_exists('images/slider/'.$Slider->Images)){
                unlink('images/slider/'.$Slider->Images);
             }
        }
        $Flag=$Slider->delete();
        if($Flag==true){
            return redirect('admin/slider/list/')->with(['flash_level'=>'success','flash_message' => 'Xóa email khuyến mại thành công.']);
        }else{
            return redirect('admin/slider/list/')->with(['flash_level'=>'danger','flash_message' => 'Xóa email khuyến mại không thành công.']);

        }
    }
    public function slider_getedit(Request $request,$RowID){

        $Slider =Slider::find($RowID);

        return view('back.slider.edit',compact('Slider'));
    }
    public function slider_edit(Request $request, $RowID){
        if($request->Name == ''||$request->Alias == '' ){
            return redirect('admin/slider/add/')->with(['flash_level'=>'danger','flash_message' => 'Vui lòng điền vào các trường có dấu sao.']);
        }
        $Slider =Slider::find($RowID);;
        $Slider->Status=$request->Status;
        $Slider->Name=$request->Name;
        $Slider->Alias=$request->Alias;
        $Slider->Sort=$request->Sort;
        if($request->hasFile('Images')){
             $file=$request->file('Images');
             $random_digit=rand(000000000,999999999);
             $name=$random_digit.'_'.$file->getClientOriginalName();
             $duoi=strtolower($file->getClientOriginalExtension());
             if($duoi !='png' && $duoi !='jpg' && $duoi !='jpeg' &&$duoi !='svg'){
                 return back()->with(['flash_level' => 'danger','flash_message'=> trans('back.ad_error_images_ex')]);
             }
             if($Slider -> slider_images !=''){
                 if(fileExists('images/slider/'.$Slider->slider_images)){
                     unlink('images/slider/'.$Slider->slider_images);
                 }
             }
             $file ->move('images/slider',$name);
             $img=Image::make('images/slider/'.$name);
             ///Kiểm tra, nếu không tồn tại thì tao folder
             $filePath='images/slider/'.date('Ymd');
             if(!file_exists($filePath)){
                 mkdir('images/slider/'.date('Ymd'),0777,true);
             }
             $img->fit(1920,760);
             $img->save('images/slider/'.date('Ymd').'/'.$name);
            /// delete images upload
             if(file_exists('images/slider/'.$name)){
              unlink('images/slider/'.$name);
             }
            $Slider->Images=date('Ymd').'/'.$name;
        }
        $Flag= $Slider->save();
        if($Flag==true){
            return redirect('admin/slider/edit/'.$RowID)->with(['flash_level'=>'success','flash_message' => 'Sửa thành công.']);
        }else{
            return redirect('admin/slider/edit/'.$RowID)->with(['flash_level'=>'danger','flash_message' => 'Thêm không thành công.']);

        }
    }
 }
