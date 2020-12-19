@extends('back.template.master')

@section('title', 'Quản lý danh sách slider')
@section('heading', 'Danh sách danh sách slider')
@section('slider', 'active')
@section('content')
    <div class="col-md-12">
     <!-- general form elements -->
        <div class="card">
            <div class="card-header">
                <a href="{{url('admin/slider/add')}}" class="btn btn-block btn-primary ad_add" title="Thêm">
                Thêm
                </a>
            </div>
              <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th class="text_align_center">STT</th>
                            <th class="text_align_center">Tên slider</th>
                            <th class="text_align_center">Ảnh đại diện</th>
                            <th class="text_align_center">Trạng thái</th>
                            <th class="text_align_center">Sắp xếp</th>

                            <th class="text_align_center"><i class="fas fa-tools fa-fw"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($Slider) && $Slider != NULL)
                            @foreach($Slider as $k => $v)
                                <tr>
                                    <td class="text_align_center">{{$k+1}}</td>
                                    <td>{{$v->Name}}</td>
                                    <td>
                                        <img src="{{url('images/slider/'.$v->Images)}}" alt="Avatar" width="100"/>
                                    </td>
                                    <td class="text_align_center">
                                        @if($v->Status==1)
                                            Bật
                                        @else
                                            Tắt
                                        @endif
                                    </td>
                                    <td class="text_align_center">{{$v->Sort}}</td>
                                <td class="text_align_center">
                                    <a href="{{url('admin/slider/edit/'.$v->RowID)}}" title="Chỉnh sửa" class="ad_button"><i class="fas fa-edit"></i> </a>
                                    <a href="{{url('admin/slider/delete/'.$v->RowID)}}" title="Xóa" class="ad_button ad_button_delete"><i class="fas fa-minus-circle"></i> </a>
                                </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
            </div>
        </div>
     <!-- /.card -->
    </div>
@stop
