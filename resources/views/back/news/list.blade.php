@extends('back.template.master')

@section('title', 'Quản lý danh sách tin tức')
@section('heading', 'Danh sách danh sách tin tức')
@section('news', 'active')
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
        <div class="card">
          <div class="card-header">
            <a href="{{url('admin/news/add')}}" class="btn btn-block btn-primary ad_add" title="Thêm">
            Thêm
            </a>
        </div>
              <!-- /.card-header -->
        <div class="card-body">
        <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text_align_center">STT</th>
                    <th class="text_align_center">Tên tin tức</th>
                    <th class="text_align_center">Thuộc danh mục</th>
                    <th class="text_align_center">Trạng thái</th>
                    <th class="text_align_center"><i class="fas fa-tools fa-fw"></i></th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(isset($News) && $News != NULL)
                  @foreach($News as $k => $v)
                  <tr>
                    <td class="text_align_center">{{$k+1}}</td>
                    <td>{{$v->Name}}</td>
                    <td>{{$v->CategoryName}}</td>
                    <td class="text_align_center">
                        @if($v->Status==1)
                             Bật
                        @else
                             Tắt
                        @endif
                    </td>
                   <td class="text_align_center">
                      <a href="{{url('admin/news/edit/'.$v->RowID)}}" title="Chỉnh sửa" class="ad_button"><i class="fas fa-edit"></i> </a>
                      <a href="{{url('admin/news/delete/'.$v->RowID)}}" title="Xóa" class="ad_button ad_button_delete"><i class="fas fa-minus-circle"></i> </a>
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
