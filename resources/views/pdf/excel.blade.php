<!DOCTYPE html>
<html>
<head>
	<title>{{ "Timesheet ".getFirstName($data['officer'])." - ".getMonthCode($data['month'])." ".$data['year'] }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
    table {
            border: 2px solid black;
            width: 100%;
            margin: auto
        }

        tr,
        th,
        td {
            font-family: Arial;
            border: 2px solid black;
            border-collapse: collapse
        }

        th,
        td {
            text-align: center;
        }

        tr>th {
            font-size: 12px;
        }

        tr>td {
            font-size: 10px;
            /* fonw */
        }
		table tr td,
		table tr th{
			font-size: 9pt;
		}
        #table-one{
            border: 1px solid rgba(0,0,0,.5);
            width: 100%;
            margin: 25px 0 15px 0;
        }
        #table-two{
            /* border: 1px solid rgba(0,0,0,.5); */
            width: 113%;
        }
        #table-two td{
            border: 1px solid rgba(0,0,0,.5);
        }
	</style>
	<center>
		<span>Timesheet for Officer</span>
	</center>

    {{-- {{ dd($data) }} --}}
    <table id="table-one">
        <tbody>
            <tr>
                <th width="100" class="pl-2 pt-1">Name of Company:</th>
                <td>{{ $data['company'] }}</td>
            </tr>
            <tr>
                <th width="100" class="pl-2">Project:</th>
                <td>{{ $data['project'] }}</td>
            </tr>
            <tr>
                <th width="100" class="pl-2">Name of Officer:</th>
                <td>{{ $data['officer'] }}</td>
            </tr>
            <tr>
                <th width="100" class="pl-2 pb-1">Position:</th>
                <td>{{ $data['position'] }}</td>
            </tr>
        </tbody>
    </table>

    <table id="table-two">
        <tbody>
            <tr>
                <td colspan="2" class="p-2">Month:</td>
                <td colspan="2" class="p-2">{{ getMonthCode($data['month']) }}-{{ $data['year'] }}</td>
            </tr>
            <tr>
                <td class="text-center py-2" style="line-height: 12px;width: 150px;text-align:center;border: 1px solid black">Day</td>
                <td class="text-center py-2" style="line-height: 12px;width: 150px;text-align:center;border: 1px solid black">Days worked</td>
                <td class="text-center py-2" style="line-height: 12px;width: 200px;text-align:center;border: 1px solid black">Place of Performance</td>
                <td class="text-center py-2" style="line-height: 12px;text-align:center;border: 1px solid black" width="300">Assigment/activities</td>
            </tr>
            @foreach($data['activities'] as $key => $activity)
            <tr>
                <td class="text-center" style="text-align: center;border: 1px solid black">{{ dateTimesheet($activity->date_activities) }}</td>
                <td class="text-center" style="text-align: center;border: 1px solid black">1</td>
                <td class="text-center" style="text-align: center;border: 1px solid black">{{ $activity->place }}</td>
                <td class="p-1" style="border: 1px solid black">{!! nl2br($activity->realization_activities) !!}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center py-3" style="line-height: 12px;">Total Working Days</td>
                <td class="text-center">{{ $data['total_working_days'] }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center py-3" style="line-height: 12px;">Total Calendar Days</td>
                <td class="text-center">
                    {{-- {{ $data['calculate'] }} --}}
                    {{ $data['calculate'] }}
                </td>
                <td></td>
                <td></td>
            </tr>
            {{-- <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td class="py-2"></td>
            </tr>
            <tr>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td style="border: none"></td>
                <td class="py-2"></td>
            </tr> --}}
        </tfoot>
    </table>
    <div style="page-break-before: always;"></div>
    <table style="width: 100%; mt-4">
        <tbody>
            <tr>
                <td>Jakarta, {{ getFullMonthCode($data['month']) }} {{ $data['full_year'] }}</td>
                <td>Aproved by,</td>
            </tr>
            <tr>
                <td>
                    <div style="height: 100px; border-bottom: 1px solid rgba(0,0,0,.2); max-width: 150px">
                        {{-- <img src="{{ $sign }}" width="99" height="99"> --}}
                    </div>
                </td>
                <td>
                    <div style="height: 100px; border-bottom: 1px solid rgba(0,0,0,.2); max-width: 150px"></div>
                </td>
            </tr>
            <tr>
                <td>{{ $data['officer'] }}</td>
                <td style="padding-left: 33px;">Harmada Sibuea</td>
            </tr>
        </tbody>
    </table>
</body>
</html>