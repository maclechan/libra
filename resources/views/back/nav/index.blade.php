@section('title', '用户权限 - 菜单列表')
@extends('back.layout')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                @if (session('msg'))
                    <div class="col-lg-3">
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            {{ session('msg') }}
                        </div>
                    </div>
                @endif
                @if (count($errors) > 0)
                    <div class="col-lg-3">
                        <div class="alert alert-success alert-dismissable">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-9 m-b-xs">
                        <ul>
                            <span data-toggle="modal" data-target="#addmenu" class="btn btn-sm btn-primary btn-outline">
                                <i class="fa fa-plus"></i> 创建菜单
                            </span>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" placeholder="Search">
                            <span class="input-group-btn"><button class="btn btn-sm btn-primary" type="button"> <b>搜索</b></button> </span>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>菜单名称</th>
                                <th>控制器</th>
                                <th>方法</th>
                                <th>路由</th>
                                <th>是否导航</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($pages as $value)
                            @if(!$value->parent_id)
                            <tr>
                                <td data-toggle="collapse" href="#faq{{ $value->nav_id }}">
                                    <a class="badge badge-primary"><span class="fa fa-arrow-circle-down"> </span> {{ $value->nav_id }}</a>
                                </td>
                                <td>{{ $value->nav_name }}</td>
                                <td>{{ $value->controller_name }}</td>
                                <td>{{ $value->action_name }}</td>
                                <td>{{ $value->url }}</td>
                                <td>{!! $value->is_show?'<span class="badge badge-primary">导航</span>':'<span class="badge badge-danger">隐藏</span>' !!}</td>
                                <td>
                                    <span data-id="{{ $value->nav_id }}"
                                          data-name="{{ $value->nav_name }}"
                                          data-controller="{{ $value->controller_name }}"
                                          data-action="{{ $value->action_name }}"
                                          data-url="{{ $value->url }}"
                                          data-icon="{{ $value->icon_class }}"
                                          data-sort="{{ $value->sort }}"
                                          data-show="{{ $value->is_show }}"
                                          data-toggle="modal"
                                          data-target="#editmenu"
                                          class="btn btn-primary btn-xs btn-rounded btn-outline">
                                        <i class="fa fa-pencil"></i> 编辑
                                    </span>
                                    <span onClick="deleteNav({{$value['nav_id']}})" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                        <i class="fa fa-trash-o"></i> 删除
                                    </span>
                                </td>
                            </tr>
                            <tr id="faq{{ $value->nav_id }}" class="panel-collapse collapse" bgcolor="#F9F9F9">
                                    <td colspan="7">
                                        <table class="table table-bordered table-hover">
                                            <tbody>
                                            @foreach ($_smenu as $_v)
                                                @if($_v->parent_id == $value->nav_id)
                                                    <tr>
                                                        <td>{{ $_v->nav_id }}</td>
                                                        <td>{{ $_v->nav_name }}</td>
                                                        <td>{{ $_v->controller_name }}</td>
                                                        <td>{{ $_v->action_name }}</td>
                                                        <td>{{ $_v->url }}</td>
                                                        <td>{!! $_v->is_show?'<span class="badge badge-primary">导航</span>':'<span class="badge badge-danger">隐藏</span>' !!}</td>
                                                        <td>
                                                            <span data-id="{{ $_v->nav_id }}"
                                                                  data-name="{{ $_v->nav_name }}"
                                                                  data-controller="{{ $_v->controller_name }}"
                                                                  data-action="{{ $_v->action_name }}"
                                                                  data-url="{{ $_v->url }}"
                                                                  data-icon="{{ $_v->icon_class }}"
                                                                  data-sort="{{ $_v->sort }}"
                                                                  data-show="{{ $_v->is_show }}"
                                                                  data data-toggle="modal"
                                                                  data-target="#editmenu"
                                                                  class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                                  <i class="fa fa-pencil"></i> 编辑
                                                            </span>
                                                            <a href="#" class="btn btn-primary btn-xs btn-rounded btn-outline">
                                                                <i class="fa fa-trash-o"></i> 删除
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>

                    <div class="text-right">
                        <div class="mail-body text-right">
                            <ul class="pagination row">
                                <li class="footable-page-arrow"><a data-page="first" href="{!! $pages->url(1) !!} #first">首页</a></li>
                                <li class="footable-page-arrow"><a data-page="prev" href="{!! $pages->previousPageUrl() !!} #prev">上一页</a></li>

                                <li class="footable-page active"><a data-page="0" href="#">第{!! $pages->currentPage() !!}页</a></li>

                                <li class="footable-page-arrow"><a data-page="next" href="{!! $pages->nextPageUrl() !!} #next">下一页</a></li>
                                <li class="footable-page-arrow"><a data-page="last" href="{!! $pages->url($pages->lastPage()) !!} #last">末页</a></li>
                            </ul>

                            <div class="pull-right pagination">
                                <!-- Small button group -->
                                <div class="btn-group m-l-xs m-r-xs">
                                    <button type="button" class="p-xxs btn btn-primary btn-xs btn-outline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        跳转页 <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @for($i=1; $i<=ceil($pages->total()/$pages->perPage()); $i++)
                                            <li><a href="{!! $pages->url($i) !!}">第{!! $i !!}页</a></li>
                                        @endfor
                                    </ul>
                                </div>
                                <!-- Small button group -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function deleteNav(nav_id){
        var nav_id = nav_id;
        swal({
            title: "确定删除吗?",
            text: "此次操作不可逆!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#1ab394",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false
        },
        function(){
            $.ajax({
                type: 'POST',
                url: '/back/nav/del',
                data: {'nav_id':nav_id},
                dataType: "json",
                success: function (data) {
                    swal("删除成功", data.msg, "success");
                    location.reload();
                },
                error: function (data) {
                    swal("删除失败", data.msg, "error");
                }
            });
        });
    };
</script>
@include('back.nav.add')
@include('back.nav.edit')
@endsection