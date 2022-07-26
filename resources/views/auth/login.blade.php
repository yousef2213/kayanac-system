<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('1.png') }}" type="image/*">
    <title>Kayanac - تسجيل الدخول</title>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Muli&display=swap');

        * {
            box-sizing: border-box;
        }

        body {
            background-color: steelblue;
            color: #fff;
            font-family: 'Muli', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow: hidden;
            margin: 0;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.4);
            padding: 20px 40px;
            border-radius: 5px;
        }

        .container h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .container a {
            text-decoration: none;
            color: lightblue;
        }

        .btn {
            cursor: pointer;
            display: inline-block;
            width: 100%;
            background: lightblue;
            padding: 15px;
            font-family: inherit;
            font-size: 16px;
            border: 0;
            border-radius: 5px;
        }

        .btn:focus {
            outline: 0;
        }

        .btn:active {
            transform: scale(0.98);
        }

        .text {
            margin-top: 30px;
        }

        .form-control {
            position: relative;
            margin: 20px 0 40px;
            width: 300px;
        }

        input::placeholder {
            color: #FFF
        }

        .form-control input {
            background-color: transparent;
            border: 0;
            border-bottom: 2px #fff solid;
            display: block;
            width: 100%;
            padding: 15px 0;
            font-size: 18px;
            color: #fff;
        }

        .form-control input:focus,
        .form-control input:valid {
            outline: 0;
            border-bottom-color: lightblue;
        }

        .form-control label {
            position: absolute;
            top: 15px;
            left: 0;
            pointer-events: none;
        }

        .form-control label span {
            display: inline-block;
            font-size: 18px;
            min-width: 5px;
            transition: 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .form-control input:focus+label span,
        .form-control input:valid+label span {
            color: lightblue;
            transform: translateY(-30px);
        }

        .captcha>span>img {
            width: 75%;
            height: 49px;
        }

        .alert-danger {
            color: #d35151
        }

    </style>
</head>

<body>
    <div class="container">
        @if (\Session::has('msg'))
            <div class="alert alert-danger">
                <ul style="list-style: none;text-align: right">
                    <li class="font-main font-main text-right">{!! \Session::get('msg') !!}</li>
                </ul>
            </div>
        @endif
        {{-- <h1>Please Login</h1> --}}

        <form method="POST" style="padding: 20px 0 40px 0px" action="{{ route('login') }}">
            @csrf
            <div style="text-align: center">
                <img src="{{ asset('1.png') }}" width="150" alt="">
            </div>
            <div class="form-control">
                <input type="text" required name="name">
                <label>Username</label>
            </div>

            <div class="form-control">
                <input type="password" required name="password">
                <label>Password</label>
            </div>
            {{-- <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Captcha</label>


                <div class="col-md-6 form-control">
                    <div class="captcha">
                        <span>{!! captcha_img() !!}</span>
                    </div>
                    <input id="captcha" type="text" class="" placeholder="Enter Captcha" name="captcha">


                    @if ($errors->has('captcha'))
                        <span class="text-danger">
                            <strong class=" font-main">تاكد من تحقق الرمز</strong>
                        </span>
                    @endif
                </div>
            </div> --}}
            <button class="btn font-main">الدخول الي النظام</button>

        </form>
    </div>
    <script>
        const labels = document.querySelectorAll('.form-control label')

        labels.forEach(label => {
            label.innerHTML = label.innerText
                .split('')
                .map((letter, idx) => `<span style="transition-delay:${idx * 50}ms">${letter}</span>`)
                .join('')
        })
    </script>
</body>

</html>
