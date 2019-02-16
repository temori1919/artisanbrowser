<link rel="stylesheet" href="{{ $css }}" type="text/css">
<script src="{{ $js['jquery'] }}"></script>
<script>var $ArtisanBrowser = jQuery.noConflict(true);</script>
<script src="{{ $js['js'] }}"></script>
<div class="artisanbrowser-overlay"></div>
<div class="artisanbrowser-root-box">
    <ul class="artisanbrowser-nav">
        <li class="artisanbrowser-nav-item artisanbrowser-nav-icon"><img src="{{ url('__artisanbrowser/assets/img') }}" alt="logo"></li>
        <li class="artisanbrowser-nav-item"><a class="artisanbrowser-nav-active" href="" data-artisanbrowseractive="route">Route</a></li>
        <li class="artisanbrowser-nav-item"><a href="" data-artisanbrowseractive="artisan">Command</a></li>
    </ul>
    <div class="artisanbrowser-window">
        <div class="artisanbrowser-window-border">
            <div class="artisanbrowser-window-route artisanbrowser-show">
                <table class"p-2">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Method</th>
                            <th>URI</th>
                            <th>Name</th>
                            <th>Action</th>
                            <th>Middleware</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{ !empty($item->action['domain']) ? $item->action['domain'] : '' }}</td>
                                <td>{{ implode(' | ', $item->methods) }}</td>
                                <td>{{ $item->uri }}</td>
                                <td>{{ !empty($item->action['as']) ? $item->action['as'] : '' }}</td>
                                <td>{{ is_object($item->action['uses']) ? get_class($item->action['uses']) : $item->action['uses'] }}</td>
                                <td>{{ !empty($item->action['middleware']) ? implode(',', $item->action['middleware']) : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="artisanbrowser-window-artisan">
                <input type="hidden" name="_artisanbrowser_token" value="{{ csrf_token() }}">
                <span class="artisanbrowser-window-command-prefix">&#036;</span>
                <input id="artisanbrowser-window-command-suffix" class="artisanbrowser-window-command-suffix" type="text" name="" value="" autocomplete="off" spellcheck="false">
                <div id="artisanbrowser-suggest" class="artisanbrowser-suggest" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>
<script>var artisanBrowserCmdList = '{!! json_encode($artisan) !!}';</script>