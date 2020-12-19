@extends('back.template.master')

@section('title', 'Quản lý mạng xã hội')
@section('heading', 'Danh mạng xã hội')
@section('social', 'active')
@section('content')
<div class="col-md-12">
    <!-- general form elements -->
        <div class="card">  
              <!-- /.card-header -->
        <div class="card-body">          
        <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text_align_center">STT</th>
                    <th class="text_align_center">Tên mạng xã hội</th>
                    <th class="text_align_center">Trạng thái</th>
                    <th class="text_align_center">Sắp xếp</th>              
                    <th class="text_align_center"><i class="fas fa-tools fa-fw"></i></th>
                  </tr>
                  </thead>
                  <tbody>
                  @if(isset($Social) && count($Social)>0)
                  @foreach($Social as $k => $v)
                  <tr>
                    <td class="text_align_center">{{$k+1}}</td>
                    <td>{{$v->Name}}</td>

                    <td class="text_align_center">
                        @if($v->Status==1)
                             Bật
                        @else
                             Tắt
                        @endif
                    </td>

                    <td class="text_align_center"> {{$v->Sort}}</td>                
                    <td class="text_align_center">
                        <a href="{{url('admin/social/edit/'.$v->RowID)}}" title="Chỉnh sửa" class="ad_button"><i class="fas fa-edit"></i> </a>
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