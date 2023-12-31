<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


    @if(!Auth::guard('admin')->user()->two_factor_secret)
        <form action="{{route('two-factor.enable')}}" method="post">
            @csrf
            <button class="btn btn-primary" type="submit">Enable 2FA</button>
        </form>
    @else
        <form action="{{route('two-factor.disable')}}" method="post">
            @csrf
            @method('delete')
            <button class="btn btn-danger" type="submit">Disable 2FA</button>
        </form>
    @endif
</body>
</html>

