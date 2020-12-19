@extends('front.template.master')

@section('title', 'Trang chủ')
@section('description', '')
@section('keywords', '')
@section('url', url('/'))
@section('images', '')
@section('content')
   <div class="home_page">
        <div class="slider_wrap">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                  @if(isset($Slider) && count($Slider)>0)
                  @foreach ($Slider as $k =>$v)
                  <div class="item @if($k == 0) active @endif">
                      <a href="{{$v->Name}}" title="{{$v->Name}}">
                    <img src="{{url('images/slider/'.$v->Images)}}" alt="{{$v->Name}}" style=" margin-left: auto; margin-right: auto">
                     </a>
                </div>
                @endforeach
                @endif
                </div>
                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="home_top">
                        <div class="home_top_left">
                              <div class="heading">
                                     Blog mới nhất
                              </div>
                              <ul>
                                @if(isset($News) && count($News)>0 )
                                @foreach ($News as $k=>$v)
                                    <li>
                                        <a href="{{url('/'.$v->Alias)}}.html" title="{{url('$v->Name')}}">
                                        <img src="{{url('images/news/'.$v->Images)}}" alt="{{url('$v->Name')}}">
                                         <b>{{$v->Name}} </b>
                                        <p>
                                            {{ Illuminate\Support\Str::limit($v->SmallDescription, 100) }}
                                            <span>[Read more]</span>
                                        </p>
                                        </a>
                                    </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        <div class="home_top_right">
                            <div class="heading">
                                Về chúng tôi
                             </div>
                             <img src="{{url('public/images/about.jpg')}}" alt="About">
                             <b> Khái niệm thiết kế website tin tức</b>
                             <p>
                                Đó là thiết kế một trang báo điện tử – một hình thức báo chí có khả năng tiếp cận và phản hồi liên
                                tục trong mọi thời điểm trên toàn cầu, cập nhật liên tục các thông tin nóng hổi xảy ra trên khắp thế giới.
                                Khác biệt hoàn toàn với báo giấy, có rất nhiều hạn chế luôn bị giới hạn nhất định về số trang, số chữ, thời điểm
                                phát hành và số lượng tin tức, báo điện tử có tốc độ cập nhật tuyệt vời và không gian tin tức không giới hạn. Đặc biệt
                                trong thời đại công nghệ thông tin sức mạnh của báo điện tử đang uy
                                hiếp mạnh mẽ đến sự tồn tại của hình thức báo giấy truyền thống từng tồn tại hàng trăm năm nay.....
                                <a href="{{url('gioi-thieu')}}" title="Xem thêm"><span>[Read more]</span></p></a>
                               <div class="home_social">
                                        @if(@isset($Social) && $Social != NULL)
                                        @foreach ($Social as $k => $v)
                                        <a href="{{$v->Alias}}" title="{{$v->Name}}">
                                                {!!$v->Font!!}
                                        </a>
                                        @endforeach
                                        @endif
                               </div>


                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="heading" style="margin-top: 55px ; color: #fff">
                Khuyến mãi mới nhất.
            </div>
            <div class="row">
                @if(isset($NewsSale) && count($NewsSale)>0 )
                @foreach ($NewsSale as $k=>$v)
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="home_center">
                            <a href="{{url('/'.$v->Alias)}}.html" title="{{url('$v->Name')}}">
                                <img src="{{url('images/news/'.$v->Images)}}" alt="{{url('$v->Name')}}">
                                 <b>{{$v->Name}} </b>
                                 <p>
                                    {{ Illuminate\Support\Str::limit($v->SmallDescription, 100) }}
                                    <span>[Read more]</span>
                                </p>
                            </a>
                        </div>
                    </div>
                 @endforeach
                 @endif
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="home_bottom">
                        <div class="heading">
                            Blog xem nhiều.
                        </div>
                        <ul>
                            @if(isset($NewsView) && count($NewsView)>0 )
                            @foreach ($NewsView as $k=>$v)
                                  <li>
                                        <a href="{{url('/'.$v->Alias)}}.html" title="{{url('$v->Name')}}">
                                                <img src="{{url('images/news/'.$v->Images)}}" alt="{{url('$v->Name')}}">
                                                <b>{{$v->Name}} </b>
                                                <p>
                                                    {{ Illuminate\Support\Str::limit($v->SmallDescription, 100) }}
                                                    <span>[Read more]</span>
                                                </p>
                                        </a>

                                    </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
   </div>
@stop
