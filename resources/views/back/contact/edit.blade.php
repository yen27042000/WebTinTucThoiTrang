@extends('back.template.master')

@section('title', 'Quản lý tin khuyến mại')
@section('heading', 'Chỉnh sửa email khuyến mại')

@section('content')
<div class="col-md-12">
      <div class="card-header">
            <a href="{{url('admin/contact/list')}}" class="btn btn-block btn-danger ad_add" title="Thêm">
            Quay lại
            </a>
        </div>
            <!-- general form elements -->
            <div class="card card-primary">            
              <!-- form start -->
              <form role="form" action="{{url('admin/contact/edit/'.$Contact->RowID)}}" method="POST">
                <div class="card-body">
                {!! csrf_field()  !!}
                <div class="form-group">
                    <select class="form-control" name="IsViews">
                         <option value="1" @if($Contact->IsViews==1) selected="" @endif>
                           Trạng thái: Đã xem</option>
                         <option value="0" @if($Contact->IsViews==0) selected="" @endif>
                           Trạng thái: Chưa xem</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Họ và tên <span class="color_red">*</span></label>
                    <input type="text" class="form-control" name="Name"  value="{{$Contact->Name}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email<span class="color_red">*</span></label>
                    <input type="email" class="form-control" name="Email" value="{{$Contact->Email}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Số điện thoại<span class="color_red">*</span></label>
                    <input type="text" class="form-control" name="Phone" value="{{$Contact->Phone}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Lời nhắn</label>
                    <textarea class="form-control" name="Message" rows="7">{{$Contact->Message}}</textarea>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
@stop