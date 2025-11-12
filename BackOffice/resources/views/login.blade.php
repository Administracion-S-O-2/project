@include('componentes.header')



@if(session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="errorToast" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<section class="container-fluid">
    <div class="row justify-content-center aling-items-center">
        <h2 class="text-center">Login</h2>
        <form action="{{ route('login') }}" method="POST" class="form-floating m-2 card col-4 p-3">
            @csrf
            @method('POST')
                <div class="form-floating mb-3">
                    <input type="text" name="email" class="form-control" name="street" placeholder="email" required>
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" name="door" placeholder="password" required>
                    <label for="floatingInput">Password</label>
                </div>
                <button class="btn btn-primary" type="submit">Iniciar sesion</button>
        </form>
    </div>
</section>
    
@include('componentes.footer')