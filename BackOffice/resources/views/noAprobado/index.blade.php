@include('componentes.header')

<section class="container-fluid mt-3 ">
    <h2 class="text-center">Solicitudes de registro</h2>
    <div class="row justify-content-center">
        <div class="col-10">
            @foreach ($noAprobados as $n)
                <div class="card m-1">
                    <div class="card-body fs-5 d-flex gap-3">
                        <label for="name">{{ $n->name }}</label>
                        <label for="email">{{ $n->email }}</label>
                        <a href="/noAprobado/approve/{{ $n->id }}"><i class="bi bi-check2-square text-success"></i></a>
                        <a href="/noAprobado/refuse/{{ $n->id }}"><i class="bi bi-x-square text-danger"></i></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</section>
    
@include('componentes.footer')