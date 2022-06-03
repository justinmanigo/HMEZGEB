@extends('template.index')

@section('content')
<h4>Notifications</h4>
<div class="card ">
    <div class="card-body">
        <div class="list-group">
            @if (count($notifications)==0)
            <a class="dropdown-item">
                    No Notification
            </a>
            @else
            {{-- Display Notification --}}
            @foreach ($notifications as $notification)
            @if($notification->resolved=='0')
            {{-- Not yet resolved --}}
            <a class="dropdown-item bg-light p-3" href="/{{$notification->link}}">
                    <div class="small font-weight-bold">{{ $notification->created_at->diffForHumans() }} </div>
                    @if ($notification->type=='warning')
                    <span class="font-weight-bold text-warning">{{ $notification->title }}</span>
                    @elseif ($notification->type=='danger')
                    <span class="font-weight-bold text-danger">{{ $notification->title }}</span>
                    @elseif($notification->type=='success')
                    <span class="font-weight-bold text-success">{{ $notification->title }}</span>
                    @else
                    <span class="font-weight-bold">{{ $notification->title }}</span>
                    @endif
                    <br>
                    {{ $notification->message }}
            </a>
            @else
            <a class="dropdown-item " href="/{{$notification->link}}">
                <div class="d-flex justify-content-between">   
                    <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }} </div>
                  <div class="small text-primary"> Resolved </div>
                </div>
                    <span class="small">{{ $notification->title }}<br>
                        {{ $notification->message }}</span>

            </a>

            @endif
            @endforeach
            @endif
        </div>
    </div>
</div>



@endsection