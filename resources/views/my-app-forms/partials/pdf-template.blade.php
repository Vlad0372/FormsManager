<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Invoice Example</title>
        <link rel="stylesheet" type="text/css" href="{{ ltrim(base_path('public/css/pdf-template.css'), '/') }}" />
    </head>
    <body>
        <div class="invoice-box">
            <table cellpadding="0" cellspacing="0">
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                    Application form #: {{ $appForm['id'] }}<br/>
                                    Created: {{ $appForm['created_at_f'] }} <br/>
                                    Printed: {{ $appForm['printed_at_f'] }}
                                </td>
                                <td class="secondinfo">
                                    Politechnika Opolska<br />
                                    Praktykant Vladyslav<br />
                                    vladek@example.com
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>             
            </table>
            <table>
                <tr class="darkline">
                    <th>Application name</th>
                    <td>{{ $appForm['app_name'] }}</td>
                </tr>
                <tr>
                    <th>Author name</th>
                    <td>{{ $appForm['author_name'] }}</td>
                </tr>
                <tr class="darkline">
                    <th>Type</th>
                    <td>{{ $appForm['type'] }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $appForm['description'] }}</td>
                </tr>
                <tr class="darkline">
                    <th>Place</th>
                    <td>{{ $appForm['place'] }}</td>
                </tr>
                
                </table>
        </div>
    </body>
</html>