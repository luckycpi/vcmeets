@extends('layouts.app')
@section('body-classes', 'login-page')
@section('main-classes', 'py-5')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 text-end pb-5">
                <a href="#">
                    <img src="{{asset('images/hub71-logo.png')}}" alt="Hub71 Logo" class="logo"/>
                </a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">

                <div class="row pt-4 pb-5 px-md-0 px-3">
                    <div class="col-12">
                        <img src="{{asset('images/login-title.png')}}" alt="Impowering today. Impacting tomorrow"
                             class="img-fluid title"/>
                    </div>
                </div>

                <div class="form-wrapper pt-4 position-relative">
                    <form method="POST" action="{{ route('login') }}" id="login-form"
                          class="animate__animated animate__fadeInUp">
                        @csrf

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-floating mb-4">

                                    <input type="email"
                                           class="form-control form-control-sm @error('email') is-invalid @enderror"
                                           id="floatingInput" placeholder="name@example.com" required
                                           autocomplete="email" value="{{ old('email') }}" name="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <i class="fa-regular fa-envelope"></i>
                                    <label for="floatingInput">Email address</label>
                                </div>

                                <div class="form-floating mb-5">
                                    <input type="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           id="floatingPassword"
                                           placeholder="Password" name="password" required
                                           autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <i class="fa-solid fa-key"></i>
                                    <label for="floatingPassword">Password</label>
                                </div>

                                <div class="text-center">
                                    <a href="#" class="btn-liquid" id="frm-submit">
                                        <span class="inner">{{ __('Login') }}</span>
                                    </a>
                                </div>

                                <div class="text-center mt-3">
                                    <a href="{{route('register')}}" class="btn btn-link text-white">Register</a>
                                </div>

                            </div>
                        </div>

                    </form>
                    <span class="processing-wrapper position-absolute" class="position-absolute">
                        <h2 id="processing" class="text-center animate__animated animate__fadeOutUp"><i
                                class="fas fa-spinner fa-spin"></i> Processing</h2>
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#frm-submit').on('click', function (e) {
                e.preventDefault();
                $('#login-form').addClass('animate__fadeOutDown').submit();
                $('#processing').removeClass('animate__fadeOutUp').addClass('animate__fadeInDown');
            });
        })
        $(function () {
            // Vars
            var pointsA = [],
                pointsB = [],
                $canvas = null,
                canvas = null,
                context = null,
                vars = null,
                points = 8,
                viscosity = 20,
                mouseDist = 70,
                damping = 0.05,
                showIndicators = false;
            mouseX = 0,
                mouseY = 0,
                relMouseX = 0,
                relMouseY = 0,
                mouseLastX = 0,
                mouseLastY = 0,
                mouseDirectionX = 0,
                mouseDirectionY = 0,
                mouseSpeedX = 0,
                mouseSpeedY = 0;

            /**
             * Get mouse direction
             */
            function mouseDirection(e) {
                if (mouseX < e.pageX)
                    mouseDirectionX = 1;
                else if (mouseX > e.pageX)
                    mouseDirectionX = -1;
                else
                    mouseDirectionX = 0;

                if (mouseY < e.pageY)
                    mouseDirectionY = 1;
                else if (mouseY > e.pageY)
                    mouseDirectionY = -1;
                else
                    mouseDirectionY = 0;

                mouseX = e.pageX;
                mouseY = e.pageY;

                relMouseX = (mouseX - $canvas.offset().left);
                relMouseY = (mouseY - $canvas.offset().top);
            }

            $(document).on('mousemove', mouseDirection);

            /**
             * Get mouse speed
             */
            function mouseSpeed() {
                mouseSpeedX = mouseX - mouseLastX;
                mouseSpeedY = mouseY - mouseLastY;

                mouseLastX = mouseX;
                mouseLastY = mouseY;

                setTimeout(mouseSpeed, 50);
            }

            mouseSpeed();

            /**
             * Init button
             */
            function initButton() {
                // Get button
                var button = $('.btn-liquid');
                var buttonWidth = button.width();
                var buttonHeight = button.height();

                // Create canvas
                $canvas = $('<canvas></canvas>');
                button.append($canvas);

                canvas = $canvas.get(0);
                canvas.width = buttonWidth + 100;
                canvas.height = buttonHeight + 100;
                context = canvas.getContext('2d');

                // Add points

                var x = buttonHeight / 2;
                for (var j = 1; j < points; j++) {
                    addPoints((x + ((buttonWidth - buttonHeight) / points) * j), 0);
                }
                addPoints(buttonWidth - buttonHeight / 5, 0);
                addPoints(buttonWidth + buttonHeight / 10, buttonHeight / 2);
                addPoints(buttonWidth - buttonHeight / 5, buttonHeight);
                for (var j = points - 1; j > 0; j--) {
                    addPoints((x + ((buttonWidth - buttonHeight) / points) * j), buttonHeight);
                }
                addPoints(buttonHeight / 5, buttonHeight);

                addPoints(-buttonHeight / 10, buttonHeight / 2);
                addPoints(buttonHeight / 5, 0);
                renderCanvas();
            }

            /**
             * Add points
             */
            function addPoints(x, y) {
                pointsA.push(new Point(x, y, 1));
                pointsB.push(new Point(x, y, 2));
            }

            /**
             * Point
             */
            function Point(x, y, level) {
                this.x = this.ix = 50 + x;
                this.y = this.iy = 50 + y;
                this.vx = 0;
                this.vy = 0;
                this.cx1 = 0;
                this.cy1 = 0;
                this.cx2 = 0;
                this.cy2 = 0;
                this.level = level;
            }

            Point.prototype.move = function () {
                this.vx += (this.ix - this.x) / (viscosity * this.level);
                this.vy += (this.iy - this.y) / (viscosity * this.level);

                var dx = this.ix - relMouseX,
                    dy = this.iy - relMouseY;
                var relDist = (1 - Math.sqrt((dx * dx) + (dy * dy)) / mouseDist);

                // Move x
                if ((mouseDirectionX > 0 && relMouseX > this.x) || (mouseDirectionX < 0 && relMouseX < this.x)) {
                    if (relDist > 0 && relDist < 1) {
                        this.vx = (mouseSpeedX / 4) * relDist;
                    }
                }
                this.vx *= (1 - damping);
                this.x += this.vx;

                // Move y
                if ((mouseDirectionY > 0 && relMouseY > this.y) || (mouseDirectionY < 0 && relMouseY < this.y)) {
                    if (relDist > 0 && relDist < 1) {
                        this.vy = (mouseSpeedY / 4) * relDist;
                    }
                }
                this.vy *= (1 - damping);
                this.y += this.vy;
            };


            /**
             * Render canvas
             */
            function renderCanvas() {
                // rAF
                rafID = requestAnimationFrame(renderCanvas);

                // Clear scene
                context.clearRect(0, 0, $canvas.width(), $canvas.height());
                context.fillStyle = 'transparent';
                context.fillRect(0, 0, $canvas.width(), $canvas.height());

                // Move points
                for (var i = 0; i <= pointsA.length - 1; i++) {
                    pointsA[i].move();
                    pointsB[i].move();
                }

                // Create dynamic gradient
                var gradientX = Math.min(Math.max(mouseX - $canvas.offset().left, 0), $canvas.width());
                var gradientY = Math.min(Math.max(mouseY - $canvas.offset().top, 0), $canvas.height());
                var distance = Math.sqrt(Math.pow(gradientX - $canvas.width() / 2, 2) + Math.pow(gradientY - $canvas.height() / 2, 2)) / Math.sqrt(Math.pow($canvas.width() / 2, 2) + Math.pow($canvas.height() / 2, 2));

                var gradient = context.createRadialGradient(gradientX, gradientY, 300 + (300 * distance), gradientX, gradientY, 0);
                gradient.addColorStop(0, '#3bd292');
                gradient.addColorStop(1, '#3bd292');

                // Draw shapes
                var groups = [pointsA, pointsB]

                for (var j = 0; j <= 1; j++) {
                    var points = groups[j];

                    if (j == 0) {
                        // Background style
                        context.fillStyle = '#104ef5';
                    } else {
                        // Foreground style
                        context.fillStyle = gradient;
                    }

                    context.beginPath();
                    context.moveTo(points[0].x, points[0].y);

                    for (var i = 0; i < points.length; i++) {
                        var p = points[i];
                        var nextP = points[i + 1];
                        var val = 30 * 0.552284749831;

                        if (nextP != undefined) {

                            p.cx1 = (p.x + nextP.x) / 2;
                            p.cy1 = (p.y + nextP.y) / 2;
                            p.cx2 = (p.x + nextP.x) / 2;
                            p.cy2 = (p.y + nextP.y) / 2;

                            context.bezierCurveTo(p.x, p.y, p.cx1, p.cy1, p.cx1, p.cy1);
                            // 	continue;
                            // }

                            // context.bezierCurveTo(p.cx1, p.cy1, p.cx2, p.cy2, nextP.x, nextP.y);
                        } else {
                            nextP = points[0];
                            p.cx1 = (p.x + nextP.x) / 2;
                            p.cy1 = (p.y + nextP.y) / 2;

                            context.bezierCurveTo(p.x, p.y, p.cx1, p.cy1, p.cx1, p.cy1);
                        }
                    }

                    // context.closePath();
                    context.fill();
                }

                if (showIndicators) {
                    // Draw points
                    context.fillStyle = '#000';
                    context.beginPath();
                    for (var i = 0; i < pointsA.length; i++) {
                        var p = pointsA[i];

                        context.rect(p.x - 1, p.y - 1, 2, 2);
                    }
                    context.fill();

                    // Draw controls
                    context.fillStyle = '#f00';
                    context.beginPath();
                    for (var i = 0; i < pointsA.length; i++) {
                        var p = pointsA[i];

                        context.rect(p.cx1 - 1, p.cy1 - 1, 2, 2);
                        context.rect(p.cx2 - 1, p.cy2 - 1, 2, 2);
                    }
                    context.fill();
                }
            }

            // Init
            initButton();
        });
    </script>

@endpush