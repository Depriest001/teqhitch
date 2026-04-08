@props(['url'])

<tr>
    <td class="">
        <div class="header" style="text-align: center; margin: auto;">
            <a href="{{ $url }}" style="text-decoration: none;">
                <img  src="{{ url('uploads/' . $globalSetting->site_logo) }}" 
                    alt="{{ config('app.name') }}"
                    style="max-height: 60px; width: 40px; display: block; margin: 0 auto;">
                <h1 style="padding-top: 5px; color: #fff; display: inline-block;">
                    Teqhitch
                </h1>

            </a>
        </div>
        
    </td>
</tr>
