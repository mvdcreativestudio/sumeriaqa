@extends('frontend.layouts.login')

@section('title')
{{$settings->site_name}} || Iniciar Sesión
@endsection

@section('content')


<div class="primaryBackground">
    <section id="">
        <div id="app" class="d-flex align-items-center min-vh-100">
            <div class="container">
                <div class="row justify-content-center">

                    <div class="d-flex justify-content-center mb-5">
                      <img src="{{ asset('uploads/logo2.png') }}" alt="logo" width="400" class="">
                    </div>
        
                    <div class="card card-primary cardLogin d-flex">
                      <div class="card-header cardLoginHeader"><h4 class="cardLoginHeader" >Iniciar Sesión</h4></div>
        
                      <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                          <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" value="{{old('email')}}" name="email" placeholder="Email" class="form-control" required>
                            <div class="invalid-feedback">
                              Ingrese su correo electrónico
                            </div>
                          </div>
        
                          <div class="form-group mt-4 mb-3">
                            <div class="d-block">
                                <label for="password" class="control-label">Contraseña</label>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Contraseña" class="form-control" required>
                            <div class="invalid-feedback">
                              Ingrese su contraseña
                            </div>
                          </div>
        
                          <div class="form-check form-switch">
                            <input id="remember_me" name="remember" class="form-check-input" type="checkbox"
                                id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Recordar</label>
                            </div>
                            
                            {{-- <a class="forget_p" href="{{ route('password.request') }}">Reestablecer contraseña</a> --}}
    
    
                          <div class="form-group d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-md btn-block mt-3" tabindex="4">
                              Iniciar Sesión
                            </button>
                          </div>
                        </form>   
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
    </section>
</div>


@endsection

   
