<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="icon" href="/assets/images/logo.ico" type="image/x-icon">
    
    <!-- Plugins e CSS -->
    <link href="/assets/css/simplebar.css" rel="stylesheet" />
    <link href="/assets/css/highcharts.css" rel="stylesheet" />
    <link href="/assets/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
    <link href="/assets/css/metisMenu.min.css" rel="stylesheet" />
    <link href="/assets/css/pace.min.css" rel="stylesheet" />
    <script src="/assets/js/pace.min.js"></script>

    <!-- Bootstrap e temas -->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
    <link href="/assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/dark-theme.css" />
    <link rel="stylesheet" href="/assets/css/semi-dark.css" />
    <link rel="stylesheet" href="/assets/css/header-colors.css" />

    <title>{{env("APP_NAME")}} Login - Admin</title>
</head>

<body>
    <div class="authentication-header"></div>

    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container" style="max-width: 480px;">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="text-center mb-4">
                        <img src="logos/slym.jpg" class="img-fluid mx-auto d-block" style="max-width: 200px;" alt="Piv-Web Sistemas">
                        
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if(session()->has('flash_login'))
                            <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-white">
                                        <i class="bx bxs-message-square-x"></i>
                                    </div>
                                    <div class="ms-3 text-white">
                                        {{ session()->get('flash_login') }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="mb-4 text-center">
                                <!--img src="assets/images/img15.jpg" class="img-fluid" alt="Imagem Login"-->
                                <img src="assets/images/img15.jpg" class="img-fluid w-25" alt="Imagem Login">

                                
                                <a href="/cadastro" class="btn btn-info text-white">
                                                <i class="bx bxs-layer-plus"></i> Quero cadastrar minha empresa
                                  </a>
                            </div>

                            <div class="login-separater text-center mb-4">
                                <span>{{env("APP_NAME")}}</span>
                                <hr />
                                
                                
                            </div>

                            <!-- FORMULÁRIO LOGIN -->
                            <div class="form-body" id="form-login">
                                <form class="row g-3" method="post" action="{{ route('login.request') }}">
                                    @csrf

                                    <div class="col-12">
                                        <label for="login" class="form-label">Login</label>
                                        <input autocomplete="off" type="text" class="form-control" id="login" placeholder="Login"
                                            name="login"
                                            @if(session('login') !=null) value="{{ session('login') }}"
                                            @else @if(isset($loginCookie)) value="{{$loginCookie}}" @endif @endif>
                                    </div>

                                    <div class="col-12">
                                        <label for="senha" class="form-label">Senha</label>
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control border-end-0" id="senha" name="senha" placeholder="Senha" autocomplete="off"
                                                @if(isset($senhaCookie)) value="{{$senhaCookie}}" @endif>
                                            <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="lembrar" name="lembrar"
                                                @isset($lembrarCookie) @if($lembrarCookie==true) checked @endif @endif>
                                            <label class="form-check-label" for="lembrar">Lembrar-me</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 text-end">
                                        <a href="javascript:;" id="forget-password">Esqueceu a senha?</a>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-success">
                                                <i class="bx bxs-check-circle"></i> Acessar
                                            </button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- FORMULÁRIO DE RECUPERAÇÃO DE SENHA -->
                            <div class="div-recuperar-senha-sicok d-none">
                                <form method="post" action="{{ route('recuperarSenha') }}" id="forget-form">
                                    @csrf
                                    <h3>Esqueceu a senha?</h3>
                                    <p>Receba uma nova senha em seu e-mail cadastrado.</p>
                                    <div class="form-group mb-3">
                                        <input class="form-control input-email-recuperar-senha-sicok" type="text" autocomplete="off" placeholder="E-mail cadastrado" name="email" />
                                    </div>
                                    <div class="form-actions mt-3 d-flex justify-content-between">
                                        <button type="button" id="back-btn" class="btn btn-primary">
                                            <i class="bx bx-home-alt"></i> Tela de login
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bx bx-check"></i> Solicitar nova senha
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/jquery.min.js"></script>

    <!-- Mostrar/Esconder Senha -->
    <script>
        $(document).ready(function () {
            $("#show_hide_password a").on('click', function (event) {
                event.preventDefault();
                const input = $('#show_hide_password input');
                const icon = $('#show_hide_password i');
                if (input.attr("type") === "text") {
                    input.attr('type', 'password');
                    icon.addClass("bx-hide").removeClass("bx-show");
                } else {
                    input.attr('type', 'text');
                    icon.removeClass("bx-hide").addClass("bx-show");
                }
            });
        });
    </script>

    <script src="assets/login1/login.js" type="text/javascript"></script>

<style>
    body {
        background-color: #0255A3; /* azul marinho */
        
    }
     #auth-right {
        background-color: #0255A3;
        height: 100vh;
    }
</style>

</body>

</html>
