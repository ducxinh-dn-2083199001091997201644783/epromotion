@extends('layouts.template_admin')
@section('main-content')

    <div class="page-header">
            <h3>{{trans('product.product')}}</h3>
            <a href="{!! route('product.create') !!}">
            <h3><span class="glyphicon glyphicon-plus"></span></h3>
        </a>
        </div>
    <table class="table table-striped product-index">
        <thead>
            <tr class="tr-top">
            <th>{{trans('product.product_name')}}</th>
            <th>{{trans('product.price')}}</th>
            <th>{{trans('product.description')}}</th>
            <th>{{trans('product.quantity')}}</th>
            <th>{{trans('product.category')}}</th>
            <th>{{trans('product.picture')}}</th>
            <th>{{trans('promotion.app_name')}}</th>
            <th>{{trans('product.action')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($listProduct as $value)
            <tr>
                <td>{{$value->product_name}}</td>
                <td>{{$value->price}}</td>
                <td>{{ str_limit($value->description, 100) }}</td>
                <td>{{$value->quantity}}</td>
                <td>{{$value->name}}</td>
                <td class="product-img"><img src="{{asset(config('path.picture_product').'/'.$value->picture)}}"></td>
                <td><a class="view-detail" href="{{ route('show_promotion',['productId' => $value->id]) }}">{{trans('promotion.view_all')}}</a></td>
                <td>
                    <div class="row action ">
                        <button class="btn btn-success btn-view view-product"><a href="{{route('product.show', [$value->id])}}"><i class="glyphicon glyphicon-eye-open"></i></a></button>
                        </button>
                        {{ Form::open([ 'method' => 'delete', 'route' => ['product.destroy', $value->id],'class'=>'form-delete-product' ]) }}
                            {{ csrf_field() }}
                            <button type="submit" alt="{{trans('product.are_you_sure_delete')}}" class="delete-product btn btn-danger">
                                <i class="glyphicon glyphicon-trash"></i>
                            </button>
                            {{ Form::close() }}
                        <button class="btn btn-info btn-edit"><a href="{{route('product.edit',[$value->id])}}"><i class="glyphicon glyphicon-edit"></i></a></button>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
     {!! $listProduct->render() !!}
    @if(Session::has('msg'))
        <div class="alert alert-success">
        {{ Session::get('msg') }}
        </div>
    @endif
@endsection
