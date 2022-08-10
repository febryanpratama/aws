@extends('layouts.main')

@section('custom-asset')
<style>
    .hidden {
        display: none;
        visibility: hidden;
        opacity: 0;
    }
</style>
@endsection

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
                                    My Review File Order
                                </div>
                            </h5>
                        </div>
                        <p class="mb-0">Your review for file order from Admin in Alatan Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">

            @foreach($fileOrders as $key => $fileOrder)
            <div class="col-lg-12 col-xl-4">
                <div class="card trnasiction-card">
                    <div class="card-header {{ getStatusBackground($fileOrder->status) }}">
                        <h5 class="text-white">File Order {{ ucfirst($fileOrder->status) }}<span class="d-block">{{ $fileOrder->title }}</span></h5>
                        <small class="mt-1 mb-0 text-white d-block">
                            <i class="feather icon-user mr-1"></i>
                            <b>{{ getName($fileOrder->sender_id) }}</b>
                        </small>
                        <small class="mb-0 text-white d-block">
                            <i class="feather icon-calendar mr-1"></i>
                            <b>{{ indonesianDate($fileOrder->created_at) }}</b>
                        </small>
                        <div class="card-header-right">
                            <div class="transection-preogress complited">
                                <span class="fa fa-{{ getStatusIcon($fileOrder->status) }} f-20"></span>
                            </div>
                        </div>
                    </div>
                    <div class="border-bottom px-3 pt-2 pb-0 bg-light">
                        <div class="d-flex flex-row">
                            <b>Instruction:</b>
                            <p class="mb-0 ml-2">{{ $fileOrder->instruction }}</p>
                        </div>
                        <div class="d-flex flex-row">
                            <b>Participant:</b>
                            <ul class="pl-2 mb-1" style="list-style: none;">
                                @foreach(getFileOrderReceivers($fileOrder->id) as $key3 => $participant)
                                <li>{{ $key3 + 1 }}. {{ getName($participant->receiver_id) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    @if(count(getFileOrderDocuments($fileOrder->id)) == 0)
                    <div class="border-bottom px-3 py-3 text-center">
                        <span class="text-danger">No files from receiver yet.</span>
                    </div>
                    @endif

                    @foreach(getFileOrderDocuments($fileOrder->id) as $key2 => $document)
                    <div class="border-bottom">
                        <div class="px-3 py-2 d-flex flex-row justify-content-between">
                            <div>
                                <i class="fa fa-file text-{{ getStatusColor($fileOrder->status) }} f-30 pt-1"></i>
                            </div>
                            <div class="pt-0 pb-1 pl-3" style="flex: 1">
                                <span>{{ $document['link'] }}</span>
                                <small class="d-block">from <b>{{ $document['name'] }}</b></small>
                                <small class="d-block"><i>{{ indonesianDate($document['created_at']) }}</i></small>
                                
                                @if($document['comments'] !== NULL)
                                <!-- <p class="mt-1 bg-danger text-white p-2" style="border-radius: 5px; font-size: 13px">{{ $document['comments'] }}</p> -->
                                <div class="alert alert-{{ getStatusColor($fileOrder->status) }} px-2 py-1 mt-1 mb-0" role="alert" style="font-size: 11px; font-weight: 700">
                                    <b class="d-block mb-2">Comments:</b>
                                    {{ $document['comments'] }}
                                </div>
                                @endif

                                @if($document['reviews'] !== NULL)
                                <!-- <p class="mt-1 bg-danger text-white p-2" style="border-radius: 5px; font-size: 13px">{{ $document['comments'] }}</p> -->
                                <div class="alert alert-{{ getStatusColor($fileOrder->status) }} px-2 py-1 mt-1 mb-0" role="alert" style="font-size: 11px; font-weight: 700">
                                    <b class="d-block mb-2">Reviews:</b>
                                    {{ $document['reviews'] }}
                                </div>
                                @endif
                            </div>
                            <div class="pt-1">
                                <a href="{{ asset('assets/files/'.$document['link']) }}" target="__blank">
                                    <i class="feather icon-download-cloud text-{{ getStatusColor($fileOrder->status) }} f-30"></i>
                                </a>
                            </div>
                        </div>
                        @if(!in_array($fileOrder->status,["completed","canceled"]))
                        <div class="px-3 pb-2">
                            <form action="{{ route('fileOrderReviewPost', [$document['fileorderdocument_id']]) }}" method="post" class="d-flex flex-row justify-content-between">
                                @csrf
                                <div class="input-group mb-3">
                                    <textarea name="reviews" rows="2" placeholder="*If you want to give a review" class="form-control">{{ $document['reviews'] }}</textarea>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="feather icon-message-square"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                    @endforeach

                    @if(!in_array($fileOrder->status,["completed","canceled"]))
                    <div class="border-top transection-footer row">
                        <div class="col-6 border-right bg-danger">
                            <a href="{{ route('fileOrderCancel', [$fileOrder->id]) }}" class="text-white">
                                <i class="feather icon-x mr-1"></i>
                                Make order Canceled
                            </a>
                        </div>
                        <div class="col-6 border-right bg-primary">
                            <a href="{{ route('fileOrderCompleted', [$fileOrder->id]) }}" class="text-white">
                                <i class="feather icon-check mr-1"></i>
                                Make order Completed
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

<!-- Modal -->
<div id="exampleModalLive" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLiveLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form class="modal-content" method="post" action="{{ route('fileOrderPost') }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLiveLabel">Add an Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="user">To</label>
                    <div class="px-3 py-2" style="border: 1px solid #ced4da; border-radius: 6px">
                        @foreach($users as $key => $user)
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck{{$key+1}}" name="receiver_id[{{$key}}]" value="{{ $user->id }}">
                            <label class="custom-control-label" for="customCheck{{$key+1}}">
                                <img src="{{ asset('assets/images/user/'.$user->avatar) }}" alt="Avatar" class="img-radius mr-1" width="20">
                                {{$user->name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="Title of your order" class="form-control">
                </div>
                <div class="form-group">
                    <label for="instruction">Instruction</label>
                    <textarea name="instruction" id="instruction" rows="5" placeholder="Instruction of your order" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn  btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('custom-script')
<script>
    function triggerUpload(id) {
        $('#file-' + id).click();
    }
    $('.file').change(function() {
        var id = $('.file').attr('id');
        var ids = id.split('-');
        var real_id = ids[1];
        $('#form-' + real_id).submit();
    });
</script>
@endsection