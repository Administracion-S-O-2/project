@include('componentes.header')

    <section class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-3 card mt-5 gap-2">
                <form action="{{ route('admin.store') }}" method="POST" class="pt-2 pb-2 d-flex flex-column gap-2" autocomplete="off">
                    @csrf
                    @method('POST')
                    <div class="col-12 text-center">
                        <i class="bi bi-person-circle fs-1"></i>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-2 col-12"> 
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-2 col-12"> 
                        <label>Apellido</label>
                        <input type="text" class="form-control" name="lastname" required>
                    </div>
                    <div class="mb-2 col-12"> 
                        <label>Email</label>
                        <input type="email" class="form-control" name="new_admin_email">
                    </div>
                    <div class="mb-2 col-12"> 
                        <label>Password</label>
                        <input type="password" class="form-control" name="new_admin_password">
                    </div>
                    <div class="mb-2 col-12"> 
                        <span>
                            <label>Su email</label>
                            <input type="email" class="form-control" name="email">
                        </span>
                        <span>
                            <label>Su password</label>
                            <input type="password" class="form-control" name="password">
                        </span>
                    </div>
                    <button class="btn btn-primary" type="submit">Crear</button>
                </form>
            </div>
        </div>
    </section>

@include('componentes.footer')