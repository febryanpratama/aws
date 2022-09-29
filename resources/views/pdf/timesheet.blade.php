<!DOCTYPE html>
<html>
<head>
	<title>{{ "Timesheet ".getFirstName($officer)." - ".getMonthCode($month)." ".$year }}</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
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

    <table id="table-one">
        <tbody>
            <tr>
                <th width="100" class="pl-2 pt-1">Name of Company:</th>
                <td>{{ $company }}</td>
            </tr>
            <tr>
                <th width="100" class="pl-2">Project:</th>
                <td>{{ $project }}</td>
            </tr>
            <tr>
                <th width="100" class="pl-2">Name of Officer:</th>
                <td>{{ $officer }}</td>
            </tr>
            <tr>
                <th width="100" class="pl-2 pb-1">Position:</th>
                <td>{{ $position }}</td>
            </tr>
        </tbody>
    </table>

    <table id="table-two">
        <tbody>
            <tr>
                <td colspan="2" class="p-2">Month:</td>
                <td colspan="2" class="p-2">{{ getMonthCode($month) }}-{{ $year }}</td>
            </tr>
            <tr>
                <td class="text-center py-2" style="line-height: 12px;">Day</td>
                <td class="text-center py-2" style="line-height: 12px;">Days worked</td>
                <td class="text-center py-2" style="line-height: 12px;">Place of Performance</td>
                <td class="text-center py-2" style="line-height: 12px;" width="350">Assigment/activities</td>
            </tr>
            @foreach($activities as $key => $activity)
            <tr>
                <td class="text-center">{{ dateTimesheet($activity->date_activities) }}</td>
                <td class="text-center">1</td>
                <td class="text-center">{{ $activity->place }}</td>
                <td class="p-1">{!! nl2br($activity->realization_activities) !!}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center py-3" style="line-height: 12px;">Total Working Days</td>
                <td class="text-center">{{ $total_working_days }}</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="text-center py-3" style="line-height: 12px;">Total Calendar Days</td>
                <td class="text-center">
                    {{-- {{ $data['calculate'] }} --}}
                    {{ $calculate }}
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
                <td>Jakarta, {{ getFullMonthCode($month) }} {{ $full_year }}</td>
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
                <td>{{ $officer }}</td>
                <td style="padding-left: 33px;">Harmada Sibuea</td>
            </tr>
        </tbody>
    </table>
</body>
</html>