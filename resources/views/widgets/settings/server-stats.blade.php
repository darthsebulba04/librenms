@extends('widgets.settings.base')

@section('form')
    <div class="form-group">
        <label for="title-{{ $id }}" class="control-label">@lang('Widget title')</label>
        <input type="text" class="form-control" name="title" id="title-{{ $id }}" placeholder="@lang('Default Title')" value="{{ $title }}">
    </div>

    <div class="form-group">
        <label for="device-{{ $id }}" class="control-label">@lang('Device')</label>
        <select class="form-control" id="device-{{ $id }}" name="device" required>
            @if($device)
                <option value="{{ $device->device_id }}">{{ $device->displayName() }}</option>
            @endif
        </select>
    </div>

    <div class="form-group">
        <label for="columnsize-{{ $id }}" class="control-label">@lang('Columns')</label>
        <select name="columnsize" id="columnsize-{{ $id }}" class="form-control">
            <option value="1" @if($columnsize == 1) selected @endif>1</option>
            <option value="2" @if($columnsize == 2) selected @endif>2</option>
            <option value="3" @if($columnsize == 3) selected @endif>3</option>
            <option value="4" @if($columnsize == 4) selected @endif>4</option>
            <option value="6" @if($columnsize == 6) selected @endif>6</option>
            <option value="12" @if($columnsize == 12) selected @endif>12</option>
        </select>
    </div>

    <div class="form-group">
        <label class="control-label">@lang('Graphs')</label> </br>
        <table>
          <tr>
            <td>CPUs</td>
            <td>
              <input type="radio" name="show_cpus" id="show-cpus-yes-{{ $id }}" value="1" @if($show_cpus) checked @endif> Yes
            </td>
            <td>
              <input type="radio" name="show_cpus" id="show-cpus-no-{{ $id }}" value="0" @if(!$show_cpus) checked @endif> No
            </td>
          </tr>
          <tr>
            <td>Mempools</td>
            <td>
              <input type="radio" name="show_mems" id="show-mems-yes-{{ $id }}" value="1" @if($show_mems) checked @endif> Yes
            </td>
            <td>
              <input type="radio" name="show_mems" id="show-mems-no-{{ $id }}" value="0" @if(!$show_mems) checked @endif> No
            </td>
          </tr>
          <tr>
            <td>Disks</td>
            <td>
              <input type="radio" name="show_disks" id="show-disks-yes-{{ $id }}" value="1" @if($show_disks) checked @endif> Yes
            </td>
            <td>
              <input type="radio" name="show_disks" id="show-disks-no-{{ $id }}" value="0" @if(!$show_disks) checked @endif> No
            </td>
          </tr>
          <tr>
            <td>Fans</td>
            <td>
              <input type="radio" name="show_fans" id="show-fans-yes-{{ $id }}" value="1" @if($show_fans) checked @endif> Yes
            </td>
            <td>
              <input type="radio" name="show_fans" id="show-fans-no-{{ $id }}" value="0" @if(!$show_fans) checked @endif> No
            </td>
          </tr>
          <tr>
            <td>Temps</td>
            <td>
              <input type="radio" name="show_temps" id="show-temps-yes-{{ $id }}" value="1" @if($show_temps) checked @endif> Yes
            </td>
            <td>
              <input type="radio" name="show_temps" id="show-temps-no-{{ $id }}" value="0" @if(!$show_temps) checked @endif> No
            </td>
          </tr>
          <tr>
            <td>Voltages</td>
            <td>
              <input type="radio" name="show_voltages" id="show-voltages-yes-{{ $id }}" value="1" @if($show_voltages) checked @endif> Yes
            </td>
            <td>
              <input type="radio" name="show_voltages" id="show-voltages-no-{{ $id }}" value="0" @if(!$show_voltages) checked @endif> No
            </td>
          </tr>
        </table>
    </div>

    <div class="form-group">
        <label class="control-label">@lang('Filters')</label> </br>
        Mempools<input type="text" class="form-control" name="filter_mems" id="filter-mems-{{ $id }}" placeholder="@lang('Memory filter')" value="{{ $filter_mems }}"> </br>
        Disks<input type="text" class="form-control" name="filter_disks" id="filter-disks-{{ $id }}" placeholder="@lang('Disk filter')" value="{{ $filter_disks }}"> </br>
        Fans<input type="text" class="form-control" name="filter_fans" id="filter-fans-{{ $id }}" placeholder="@lang('Fan filter')" value="{{ $filter_fans }}"> </br>
        Temps<input type="text" class="form-control" name="filter_temps" id="filter-temps-{{ $id }}" placeholder="@lang('Temp filter')" value="{{ $filter_temps }}"> </br>
        Voltages<input type="text" class="form-control" name="filter_voltages" id="filter-voltages-{{ $id }}" placeholder="@lang('Voltage filter')" value="{{ $filter_voltages }}"> </br>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        init_select2('#device-{{ $id }}', 'device', {}, @json($device ? ['id' => $device->device_id, 'text' => $device->displayName()] : ''));
    </script>
@endsection
