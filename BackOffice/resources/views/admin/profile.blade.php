@include('componentes.header')

    <section class="container-fluid">
        <div class="row justify-content-center align-items-center">
            <div class="col-3 card mt-5 gap-2">
                <form class="pt-2 d-flex flex-column gap-2">
                    @csrf
                    <div class="col-12 text-center">
                        <i class="bi bi-person-circle fs-1"></i>
                    </div>
                    <div class=" mb-2 col-12"> 
                        <label for="floatingInput">Nombre</label>
                        <input type="text" class="form-control" name="name" value="{{ $admin->name }}" readonly>
                    </div>
                    <div class=" mb-2 col-12"> 
                        <label for="floatingInput">Apellido</label>
                        <input type="text" class="form-control" name="lastname" value="{{ $admin->lastname }}" readonly>
                    </div>
                    <div class=" mb-2 col-12"> 
                        <label for="floatingInput">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ $admin->email }}" readonly>
                    </div>
                    <div class=" mb-2 col-12"> 
                        <label for="floatingInput">Password</label>
                        <input type="password" class="form-control" name="password" value="{{ $admin->password }}" readonly>
                    </div>
                </form>
                <form action="{{ route('admin.comprobantes') }}" class="d-grid gap-2 col-12 mx-auto">
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="bi bi-file-arrow-down-fill"></i> Comprobantes evaluados</button>
                </form>
                <form action="{{ route('admin.solicitudes') }}" class="pb-3 d-grid gap-2 col-12 mx-auto">
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="bi bi-person-fill-down pe-2"></i>Solicitudes evaluadas</button>
                </form>
            </div>
        </div>
    </section>

@include('componentes.footer')