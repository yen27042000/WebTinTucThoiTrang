@extends('back.template.master')

@section('title', 'Quản lý nhân viên')
@section('heading', 'Danh sách nhân viên')

@section('content')
<div class="col-md-12">
    <!-- general form elements -->
        <div class="card">  
        <div class="card-header">
            <a href="{{url('admin/staff/add')}}" class="btn btn-block btn-primary ad_add" title="Thêm">
            Thêm
            </a>
        </div>
              <!-- /.card-header -->
        <div class="card-body">          
        <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text_align_center">STT</th>
                    <th>Họ và tên</th>
                    <th>Cấp bậc</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th class="text_align_center"><i class="fas fa-tools fa-fw"></i></th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(isset($User) && count($User)>0)
                  @foreach($User as $k => $v)
                  <tr>
                    <td class="text_align_center">{{$k+1}}</td>
                    <td>{{$v->fullname}}</td>
                    <td>{{$v->name}}</td>
                    <td> {{$v->email}}</td>
                    <td>{{$v->phone}}</td>
                    <td class="text_align_center">
                        <a href="{{url('admin/staff/edit/'.$v->id)}}" title="Chỉnh sửa" class="ad_button"><i class="fas fa-edit"></i> </a>
                        <a href="{{url('admin/staff/delete/'.$v->id)}}" title="Xóa" class="ad_button ad_button_delete"><i class="fas fa-minus-circle"></i> </a>

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