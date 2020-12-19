<div id="header">
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="header_logo">
                            <a href="{{url('/')}}" title="Trang chủ">
                                <img src="{{url('images/logo/'.$logo->Description)}}" alt="Logo">
                            </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="head_social">
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
    <div class="header_bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-7 col-md-9">
                    <div class="header_menu1">
                        <ul>
                            @if(@isset($Page) && count($Page)>0)
                            @foreach ($Page as $k => $v)
                            <li>
                                @if($v->Alias=='/')
                                <a  href="{{url('/')}}" class="active" title="{{$v->Name}}"> {!!$v->Font!!} </a>
                                @else
                                <a href="{{url('/'.$v->Alias)}}" title="{{$v->Name}}">{{$v->Name}}</a>
                                @endif
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-5 col-md-3">
                     <div class="header_seach">
                          <input type="text" id="btnsearch" placeholder="Nhập tự khóa tìm kiếm">
                          <button>
                            <i class="fas fa-search"></i>
                          </button>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
