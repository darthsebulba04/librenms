<?php
/**
 * ServerStatsController.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link       http://librenms.org
 * @copyright  2018 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Controllers\Widgets;

use App\Models\Device;
use Illuminate\Http\Request;

class ServerStatsController extends WidgetController
{
    protected $title = 'Server Stats';
    protected $defaults = [
        'title' => null,
        'columnsize' => 3,
        'device' => null,
        'show_cpus' => 1,
        'show_mems' => 1,
        'show_disks' => 1,
        'show_fans' => 0,
        'show_temps' => 0,
        'show_voltages' => 0,
        'filter_mems' => '/.*/',
        'filter_disks' => '/.*/',
        'filter_temps' => '/.*/',
        'filter_fans' => '/.*/',
        'filter_voltages' => '/.*/',
        'cpu' => 0,
        'mempools' => [],
        'disks' => [],
        'fans' => [],
        'temps' => [],
        'voltages' => [],
    ];

    public function title(Request $request)
    {
        $settings = $this->getSettings();
        if ($settings['title']) {
            return $settings['title'];
        }

        /** @var Device $device */
        $device = Device::hasAccess($request->user())->find($settings['device']);
        if ($device) {
            return $device->displayName() . ' stats';
        }

        return $this->title;
    }

    public function getView(Request $request)
    {
        $data = $this->getSettings();

        if (is_null($data['device'])) {
            return $this->getSettingsView($request);
        }

        /** @var Device $device */
        $device = Device::hasAccess($request->user())->find($data['device']);
        if ($device) {
            if ($data['show_cpus']) {
                $data['cpu'] = $device->processors()->avg('processor_usage');
            }

            if ($data['show_mems']) {
                $data['mempools'] = $device->mempools()->select(\DB::raw('mempool_descr, mempool_                foreach ($data['mempools'] as $key => $mempool) {
                    if (!preg_match($data['filter_mems'], $mempool['mempool_descr'])) {
                        unset($data['mempools'][$key]);
                        continue;
                    }

                    $total = $this->formatBytesLabel($mempool['total']);
                    $used = $this->formatBytesLabel($mempool['used'], $total['round'], $total['po

                    $data['mempools'][$key]['used'] = $used['value'];
                    $data['mempools'][$key]['total'] = $total['value'];
                    $data['mempools'][$key]['unit'] = "\n".$total['unit'];
                }
            }

                                                                                     if ($data['show_disks']) {
                $data['disks'] = $device->storage()->select(\DB::raw('storage_descr, storage_used
                foreach ($data['disks'] as $key => $disk) {
                    if (!preg_match($data['filter_disks'], $disk['storage_descr'])) {
                        unset($data['disks'][$key]);
                        continue;
                    }

                    $data['disks'][$key]['storage_descr'] = $this->formatDiskLabel($disk['storage

                    $total = $this->formatBytesLabel($disk['total']);
                    $used = $this->formatBytesLabel($disk['used'], $total['round'], $total['power

                    $data['disks'][$key]['used'] = $used['value'];
                    $data['disks'][$key]['total'] = $total['value'];
                    $data['disks'][$key]['unit'] = "\n".$total['unit'];
                }
            }

            if ($data['show_fans']) {
                $data['fans'] = $device->sensors()->select(\DB::raw('sensor_descr as descr, senso
                foreach ($data['fans'] as $key => $fan) {
                    if (!preg_match($data['filter_fans'], $fan['descr'])) {
                        unset($data['fans'][$key]);
                        continue;
                    }

                    $data['fans'][$key]['descr'] = $this->formatFanLabel($fan['descr']);
                    $data['fans'][$key]['unit'] = 'RPM';
                    $data['fans'][$key]['current'] = round($fan['current'], 0);
                    $data['fans'][$key]['high'] = round($fan['high'], 0);
                    $data['fans'][$key]['low'] = round($fan['low'], 0);
                }
            }

            if ($data['show_temps']) {
                $data['temps'] = $device->sensors()->select(\DB::raw('sensor_descr as descr, sens
                foreach ($data['temps'] as $key => $temp) {
                    if (!preg_match($data['filter_temps'], $temp['descr'])) {
                        unset($data['temps'][$key]);
                        continue;
                    }

                    $data['temps'][$key]['descr'] = $this->formatTempLabel($temp['descr']);
                    $data['temps'][$key]['unit'] = 'C';
                }
            }

            if ($data['show_voltages']) {
                $data['voltages'] = $device->sensors()->select(\DB::raw('sensor_descr as descr, s
                foreach ($data['voltages'] as $key => $temp) {
                    if (!preg_match($data['filter_voltages'], $temp['descr'])) {
                        unset($data['voltages'][$key]);
                        continue;
                    }

                    $data['voltages'][$key]['descr'] = $this->formatVoltageLabel($temp['descr']);
                    $data['voltages'][$key]['unit'] = 'dBm';
                }
            }
        }

        return view('widgets.server-stats', $data);
    }

    public function getSettingsView(Request $request)
    {
        $settings = $this->getSettings(true);
        $settings['device'] = Device::hasAccess($request->user())->find($settings['device']) ?: null;

        return view('widgets.settings.server-stats', $settings);
    }

    public function getSettings($settingsView = false)
    {
        $settings = parent::getSettings($settingsView);
        $settings['columns'] = 12 / $settings['columnsize'];

        return $settings;
    }

    private function formatFanLabel($label)
    {
        return trim($label);
    }

    private function formatVoltageLabel($label)
    {
        return trim($label);
    }

    private function formatTempLabel($label)
    {
        $pos = strpos($label, 'Temperature');
        if ($pos) {
            return trim(substr($label, 0, $pos));
        }
        if (starts_with($label, 'HDD')) {
            return trim(substr($label, 0, 6));
        }

        return trim($label);
    }

    private function formatBytesLabel($value, $round = 2, $pow = 0)
    {
        $sizes = array("B", "KB", "MB", "GB", "TB", "PB", "EB");

        if ($pow == 0) {
            $value = max($value, 0);
            $pow = floor(($value ? log($value) : 0) / log(1024));
            $pow = min($pow, count($sizes) - 1);
        }

        $value /= pow(1024, $pow);

        $ret = array();
        $ret['value'] = round($value, $round);
        $ret['power'] = $pow;
        $ret['unit'] = $sizes[$pow];
        $ret['round'] = $round;

        return $ret;
    }

    private function formatDiskLabel($label, $max = 20)
    {
        $label = trim($label);

        if (null == $label || strlen($label) < $max) {
            return $label;
        }

        // Linux based file system
        if (starts_with($label, '/')) {
            return substr($label, 0, $max);
        } else {
            // Windows
            $letter = substr($label, 0, 3);

            $name_start = strpos($label, "Label:") + 6;
            $name_end = strpos($label, "Serial Number ");

            $name = substr($label, $name_start, ($name_end - $name_start));

            if (empty($name)) {
                return $letter;
            }

            return substr($letter . " " . $name, 0, $max);
        }
    }
}
