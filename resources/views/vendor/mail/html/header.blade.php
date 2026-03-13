@props(['url'])

<tr>
    <td class="">
        <div class="header" style="text-align: center; margin: auto;">
            <a href="{{ $url }}" style="text-decoration: none;">
                <img src="{{ config('app.url') }}/assets/img/favicon.jpg"
                    alt="{{ config('app.name') }}"
                    style="max-height: 60px; display: inline-block; margin: 0 auto;">

                <h2 style="margin: 5px 0; color: #fff; display: inline-block;">
                    Teqhitch
                </h2>

            </a>
        </div>
        
    </td>
</tr>
