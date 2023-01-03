@extends('layouts.main')


@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-content">

        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10 d-flex flex-row justify-content-between">
                                <div>
                                    <i class="feather icon-file mr-1"></i>
                                    Reimburse Form
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">Provides an interface for working with file systems. This software is very useful for speeding up interaction with files.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>List Data Reimburse Form</h4>
                            </div>
                            {{-- {{ dd(Auth::user()->level) }} --}}
                            {{-- @if (Auth::user()->level == 'admin') --}}
                            <button type="button" class="btn btn-primary button" data-toggle="modal" data-target="#exampleModal">
                                <i class="feather icon-plus"></i>
                                Add Reimburse
                            </button>
                            {{-- @endif --}}
                            {{-- <a href="" class="btn btn-primary btn-sm">
                            </a> --}}
                        </div>
                    </div>
                    {{-- {{ dd($files) }} --}}
                    <div class="card-body">
                        <div class="table table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th width="20%">Name</th>
                                        <th width="30%">Category</th>
                                        <th>Description</th>
                                        <th>File</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($data as $item=>$dt)
                                        <tr>
                                            <td>{{ $item+1 }}</td>
                                            <td>{{ $dt->submitted->name }}</td>
                                            <td>{{ $dt->category }}</td>
                                            <td>{{ $dt->description_purchase }}</td>
                                            <td>
                                                <a href="{{ asset('uploads/reimburse/'.$dt->path_file) }}" target="_blank" class="badge badge-primary">File</a>
                                            </td>
                                            <td>
                                                @switch($dt->status)
                                                    @case("pending")
                                                        <div class="badge badge-warning"> {{ $dt->status }} </div>
                                                        @break
                                                    @case("approved")
                                                        <div class="badge badge-success"> {{ $dt->status }} </div>
                                                        @break
                                                        @case("rejected")
                                                        <div class="badge badge-danger"> {{ $dt->status }} </div>

                                                    @break
                                                    @default
                                                        
                                                @endswitch
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#vieModal{{ $dt->id }}">
                                                    <i class="feather icon-eye"></i>
                                                </button>
                                                @if (auth()->user()->level == 'admin' || auth()->user()->level == 'manager'))
                                                    <a href="{{ url('/reimburse/'.$dt->id."/approved") }}" class="btn btn-success btn-sm" title="approve">
                                                        <i class="feather icon-check"></i>
                                                    </a>
                                                    <a href="{{ url('/reimburse/'.$dt->id."/rejected") }}" class="btn btn-danger btn-sm" title="reject">
                                                        <i class="feather icon-x"></i>
                                                    </a>
                                                @endif
                                                
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="vieModal{{ $dt->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">Budget Category</label>
                                                                <input type="text" class="form-control" value="{{ $dt->category }}" readonly>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">Date Purchase</label>
                                                                <input type="text" class="form-control" value="{{ $dt->date_purchase }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">Description Of Purchase</label>
                                                                <textarea name="description_purchase" cols="30" rows="5" class="form-control" readonly>{{ $dt->description_purchase }}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">Total Amount</label>
                                                                <input type="text" class="form-control" value="{{ number_format($dt->amount,'0') }}" readonly>
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="" class="control-label">File</label>
                                                                <input type="file" class="form-control" name="file">
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <hr>
                                                    <h5>Name Of Product</h5>
                                                    <div class="row">
                                                        <div class="col-md-6 mt-2">
                                                            <label for="" class="control-label"><b>Product Name</b></label>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <label for="" class="control-label"><b>Price</b></label>
                                                            {{-- <input type="text" class="form-control" value="{{ $item->price }}" readonly> --}}
                                                        </div>
                                                        @foreach ($dt->detailReimburse as $item)
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" class="form-control" value="{{ $item->product_name }}" readonly>
                                                        </div>
                                                        <div class="col-md-6 mt-2">
                                                            <input type="text" class="form-control" value="{{ $item->price }}" readonly>
                                                        </div>
                                                            
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{ url("reimburse") }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="row">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Budget Category</label>
                        <select name="category" id="" class="form-control">
                            <option value="" selected disabled> == Pilih == </option>
                            <option value="Office Supply">Office Supply</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Stationeries">Stationeries</option>
                            <option value="Event Supplies Expenses">Event Supplies Expenses</option>
                            <option value="Other Expense">Other Expense</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Date Purchase</label>
                        <input type="date" class="form-control" name="date_purchase" placeholder="Form Izin Surat CUTI .. ">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="" class="control-label">Description Of Purchase</label>
                        <textarea name="description_purchase" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">Total Amount</label>
                        <input type="number" class="form-control" name="amount" placeholder="Amount Purchase ">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="" class="control-label">File</label>
                        <input type="file" class="form-control" name="file">
                    </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Name Produk</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicTable0">
                            <tr class="text-center">
                                <td>
                                    <input type="text" name="product_name[]" class="form-control">
                                </td>
                                <td>
                                    <input type="number" name="price[]" class="form-control">
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary badge-pill px-4" id="add">
                                        Add
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
  </div>
</div>

@endsection
{{-- @include('includes.scripts') --}}

@section('custom-script')

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
<script>
    $(document).ready(function(){
        var i = 0;

        console.log('ready')

        // $('.button').on('click', function(){
        //     // console.log('button')

        //     alert('button')
        // })
           
        $("#add").click(function(){
            console.log('add');
       
            ++i;
       
            $("#dynamicTable0").append(`
                <tr class="text-center">
                    <td>
                        <input type="text" name="product_name[]" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="price[]" class="form-control">
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger badge-pill px-4 remove-tr">
                            Remove
                        </button>
                    </td>
                </tr>
            `);
        });

        $(document).on('click', '.remove-tr', function(){  
            $(this).parents('tr').remove();
        }); 
        // var i = 0;
        // $(".add").click(function(){
        //     console.log('add');
        //     i++;
        //     $("#dynamicTable0").append('<tr id="row'+i+'"><td><input type="text" name="product_name[]" class="form-control"></td><td><input type="number" name="price[]" class="form-control"></td><td><button type="button" class="btn btn-danger badge-pill px-4" id="'+i+'" class="btn_remove">X</button></td></tr>');
        // });
        // $(document).on('click', '.btn_remove', function(){
        //     var button_id = $(this).attr("id");
        //     $("#row"+button_id+"").remove();
        // });
    });
</script>
    
@endsection
