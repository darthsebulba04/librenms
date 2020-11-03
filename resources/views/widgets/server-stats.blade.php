<div class="col-sm-{{ $columns }}">
    <div
        id="cpu-{{ $id }}"
        class="guage-{{ $id }}"
        data-value="{{ $cpu }}"
        data-max="100"
        data-symbol="%"
        data-title="CPU"
    ></div>
</div>

@foreach($mempools as $key => $mem)
    <div class="col-sm-{{ $columns }}">
        <div
            id="mem-{{ $key }}-{{ $id }}"
            class="guage-{{ $id }}"
            data-value="{{ $mem['used'] }}"
            data-max="{{ $mem['total'] }}"
            data-title="{{ $mem['mempool_descr'] }}"
            data-label="{{ $mem['used'] }}{{ $mem['unit'] }}"
            data-pointer=true
        ></div>
    </div>
@endforeach

@foreach($disks as $key => $disk)
    <div class="col-sm-{{ $columns }}">
        <div
            id="disk-{{ $key }}-{{ $id }}"
            class="guage-{{ $id }}"
            data-value="{{ $disk['used'] }}"
            data-max="{{ $disk['total'] }}"
            data-title="{{ $disk['storage_descr'] }}"
            data-label="{{ $disk['used'] }}{{ $disk['unit'] }}"
            data-pointer=true
        ></div>
    </div>
@endforeach

@foreach($fans as $key => $fan)
    <div class="col-sm-{{ $columns }}">
        <div
            id="fan-{{ $key }}-{{ $id }}"
            class="guage-{{ $id }}"
            data-value="{{ $fan['current'] }}"
            data-min="{{ $fan['low'] }}"
            data-max="{{ $fan['high'] }}"
            data-title="{{ $fan['descr'] }}"
            data-label="{{ $fan['unit'] }}"
            data-pointer=true
        ></div>
    </div>
@endforeach

@foreach($temps as $key => $temp)
    <div class="col-sm-{{ $columns }}">
        <div
            id="temp-{{ $key }}-{{ $id }}"
            class="guage-{{ $id }}"
            data-value="{{ $temp['current'] }}"
            data-min="{{ $temp['low'] }}"
            data-max="{{ $temp['high'] }}"
            data-title="{{ $temp['descr'] }}"
            data-label="{{ $temp['unit'] }}"
            data-pointer=true
        ></div>
    </div>
@endforeach

@foreach($voltages as $key => $voltage)
    <div class="col-sm-{{ $columns }}">
        <div
            id="voltage-{{ $key }}-{{ $id }}"
            class="guage-{{ $id }}"
            data-value="{{ $voltage['current'] }}"
            data-min="{{ $voltage['low'] }}"
            data-max="{{ $voltage['high'] }}"
            data-title="{{ $voltage['descr'] }}"
            data-label="{{ $voltage['unit'] }}"
            data-pointer=true
        ></div>
    </div>
@endforeach

<script type='text/javascript'>
    loadjs('js/raphael-min.js', function() {
        loadjs('js/justgage.js', function() {
            $('.guage-{{ $id }}').each(function() {
                new JustGage({
                    id: this.id,
                    min: 0,
                    valueFontSize: '2px'
                });
            });
        });
    });
</script>
