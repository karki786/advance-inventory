<li class="dropdown messages-menu">
    <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success">{{count(Auth::user()->unreadNotifications)}}</span>
    </a>
    <ul class="dropdown-menu">
        <li class="header">You have {{count(Auth::user()->unreadNotifications)}} messages</li>
        <li>
            <!-- inner menu: contains the actual data -->

            <ul class="menu">
                @foreach(Auth::user()->unreadNotifications as $notification)
                    <li><!-- start message -->
                        <a href="{{action('NotificationsController@redirectToUrl',array('id'=>$notification->id,'url'=>rawurlencode($notification->data['url'])))}}">
                            <div class="pull-left">
                                <img alt="User Image" class="img-circle" src="{{App\Helper::avatar()}}">
                            </div>
                            <h4>
                                {{$notification->data['type']}}
                            </h4>
                            <p>
                                <small>  {{$notification->data['message']}}</small>
                            </p>
                        </a>
                    </li><!-- end message -->
                @endforeach

            </ul>
        </li>
        <li class="footer">
            <a href="{{action('NotificationsController@markAllAsRead')}}" class="btn btn-flat bg-green btn-block"> Mark
                All as read</a>
        </li>
    </ul>
</li>